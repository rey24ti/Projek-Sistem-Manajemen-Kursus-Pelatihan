<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        // Hanya index dan show yang boleh diakses tanpa login
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Course::with(['category', 'trainer', 'enrollments']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        /** @var User|null $user */
        $user = Auth::user();
        if ($user) {
            // For staff, only show their courses
            if ($user->isStaff()) {
                $query->where('trainer_id', $user->id);
            }

            // For logged-in guest, only show open courses
            if ($user->isGuest()) {
                $query->where('status', 'open');
            }
        } else {
            // For non-logged-in visitors, only show open courses
            $query->where('status', 'open');
        }

        $courses    = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        // Tentukan view berdasarkan role / status login
        if (! Auth::check()) {
            $view = 'guest.courses.index';
        } else {
            /** @var User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                $view = 'admin.courses.index';
            } elseif ($user->isStaff()) {
                $view = 'staff.courses.index';
            } elseif ($user->isGuest()) {
                // logged-in guest sees the auth-specific guest view
                $view = 'guest.courses.auth_index';
            } else {
                $view = 'guest.courses.index';
            }
        }

        return view($view, compact('courses', 'categories'));
    }

    protected function validationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,ongoing,completed,cancelled',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'passing_score' => 'required|integer|min:0|max:100',
        ];
    }

    public function create()
    {
        /** @var User|null $user */
        $user = Auth::user();
        $categories = Category::all();

        if ($user && $user->isStaff()) {
            $trainers = collect([$user]);
            $view     = 'staff.courses.create';
        } else {
            $trainers = User::whereIn('role', ['admin', 'staff'])->get();
            $view     = 'admin.courses.create';
        }

        return view($view, compact('categories', 'trainers'));
    }

    public function store(Request $request)
    {
        $rules = $this->validationRules();
        $validator = Validator::make($request->all(), $rules, [], [
            'passing_score' => 'nilai minimum kelulusan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // For staff, ensure they can only create courses for themselves
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && $user->isStaff() && $data['trainer_id'] != $user->id) {
            return back()->with('error', 'Anda hanya dapat membuat kursus untuk diri sendiri.');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        /** @var User|null $user */
        $user = Auth::user();
        $course->load(['category', 'trainer', 'enrollments.user', 'materials', 'assignments', 'quizzes']);

        // Check if user is enrolled
        $isEnrolled = false;
        if ($user) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', $user->id)
                ->exists();
        }

        if (! $user) {
            $view = 'guest.courses.show';
        } else if ($user->isAdmin()) {
            $view = 'admin.courses.show';
        } else if ($user->isStaff()) {
            $view = 'staff.courses.show';
        } else {
            $view = 'guest.courses.show';
        }

        return view($view, compact('course', 'isEnrolled'));
    }

    public function edit(Course $course)
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Permission: staff can edit only their own courses
        if ($user && $user->isStaff() && $course->trainer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kursus ini.');
        }

        $categories = Category::all();

        if ($user && $user->isStaff()) {
            $trainers = collect([$user]);
            $view = 'staff.courses.edit';
        } else {
            $trainers = User::whereIn('role', ['admin', 'staff'])->get();
            $view = 'admin.courses.edit';
        }

        return view($view, compact('course', 'categories', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Permission: staff can only edit their own courses
        if ($user && $user->isStaff() && $course->trainer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kursus ini.');
        }

        $rules = $this->validationRules();
        $validator = Validator::make($request->all(), $rules, [], [
            'passing_score' => 'nilai minimum kelulusan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // For staff, ensure they can only assign themselves as trainer
        if ($user && $user->isStaff() && $data['trainer_id'] != $user->id) {
            return back()->with('error', 'Anda hanya dapat mengassign diri sendiri sebagai trainer.');
        }

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = null;
        }

        $course->update($data);

        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {

        // Check if staff can only delete their own courses
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && $user->isStaff() && $course->trainer_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus kursus ini.');
        }

        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}
