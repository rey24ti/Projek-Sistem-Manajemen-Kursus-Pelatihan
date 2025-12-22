<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        if (auth()->check()) {
            // For staff, only show their courses
            if (auth()->user()->isStaff()) {
                $query->where('trainer_id', auth()->id());
            }

            // For logged-in guest, only show open courses
            if (auth()->user()->isGuest()) {
                $query->where('status', 'open');
            }
        } else {
            // For non-logged-in visitors, only show open courses
            $query->where('status', 'open');
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        // Tentukan view berdasarkan role / status login
        if (!auth()->check()) {
            $view = 'guest.courses.index';
        } else {
            $view = auth()->user()->isAdmin()
                ? 'admin.courses.index'
                : (auth()->user()->isStaff()
                    ? 'staff.courses.index'
                    : 'guest.courses.index');
        }

        return view($view, compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        
        // For staff, they can only assign themselves as trainer
        if (auth()->user()->isStaff()) {
            $trainers = collect([auth()->user()]);
            $view = 'staff.courses.create';
        } else {
            // Admin can assign any trainer
            $trainers = User::whereIn('role', ['admin', 'staff'])->get();
            $view = 'admin.courses.create';
        }
        
        return view($view, compact('categories', 'trainers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,ongoing,completed,cancelled',
            'price' => 'required|numeric|min:0',
            'passing_score' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [], [
            'passing_score' => 'nilai minimum kelulusan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // For staff, ensure they can only create courses for themselves
        if (auth()->user()->isStaff() && $data['trainer_id'] != auth()->id()) {
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
        $course->load(['category', 'trainer', 'enrollments.user', 'materials', 'assignments', 'quizzes']);
        
        // Check if user is enrolled
        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', auth()->id())
                ->exists();
        }

        if (!auth()->check()) {
            $view = 'guest.courses.show';
        } else {
            $view = auth()->user()->isAdmin()
                ? 'admin.courses.show'
                : (auth()->user()->isStaff()
                    ? 'staff.courses.show'
                    : 'guest.courses.show');
        }

        return view($view, compact('course', 'isEnrolled'));
    }

    public function edit(Course $course)
    {
        // Check if staff can only edit their own courses
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kursus ini.');
        }

        $categories = Category::all();
        
        // For staff, they can only assign themselves as trainer
        if (auth()->user()->isStaff()) {
            $trainers = collect([auth()->user()]);
            $view = 'staff.courses.edit';
        } else {
            $trainers = User::whereIn('role', ['admin', 'staff'])->get();
            $view = 'admin.courses.edit';
        }
        
        return view($view, compact('course', 'categories', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        // Check if staff can only edit their own courses
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kursus ini.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,ongoing,completed,cancelled',
            'price' => 'required|numeric|min:0',
            'passing_score' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [], [
            'passing_score' => 'nilai minimum kelulusan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // For staff, ensure they can only assign themselves as trainer
        if (auth()->user()->isStaff() && $data['trainer_id'] != auth()->id()) {
            return back()->with('error', 'Anda hanya dapat mengassign diri sendiri sebagai trainer.');
        }

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        // Check if staff can only delete their own courses
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
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
