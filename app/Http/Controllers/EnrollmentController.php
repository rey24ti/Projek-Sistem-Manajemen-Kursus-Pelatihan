<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User; 

class EnrollmentController extends Controller
{
    public function __construct()
    {
        // Ensure user is authenticated for controller actions that require auth
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        // DEBUG: log auth status to help track undefined id/check issues
        Log::info('EnrollmentController@index auth', [
            'check' => Auth::check(),
            'id'    => $user ? $user->id : null,
            'user'  => $user ? $user->id : null,
        ]);

        $query = Enrollment::with(['user', 'course']);

        // For staff, only show enrollments for their courses
        if ($user && $user->isStaff()) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('trainer_id', $user->id);
            });
        }

        // For guest, only show their own enrollments
        if ($user && $user->isGuest()) {
            $query->where('user_id', $user->id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment_status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            })->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(10);

        $view = ($user && $user->isAdmin()) ? 'admin.enrollments.index' :
            (($user && $user->isStaff()) ? 'staff.enrollments.index' : 'guest.enrollments.index');

        return view($view, compact('enrollments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $course = Course::findOrFail($request->course_id);

        /** @var User $user */
        $user = Auth::user();

        // Check if already enrolled
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar pada kursus ini.');
        }

        // Check if course is full
        $currentEnrollments = $course->enrollments()->where('status', 'approved')->count();
        if ($currentEnrollments >= $course->max_participants) {
            return back()->with('error', 'Kursus sudah penuh.');
        }

        Enrollment::create([
            'user_id'         => $user->id,
            'course_id'       => $course->id,
            'status'          => 'pending',
            'enrollment_date' => now(),
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu persetujuan.');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'status'          => 'required|in:pending,approved,rejected,completed',
            'progress'        => 'nullable|integer|min:0|max:100',
            'payment_status'  => 'nullable|in:pending,verified,rejected',
            'final_score'     => 'nullable|numeric|min:0|max:100',
            'completion_date' => 'nullable|date',
            'notes'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Collect only allowed fields
        $data = $request->only(['status', 'payment_status', 'progress', 'final_score', 'completion_date', 'notes']);

        // Calculate is_passed based on final_score and course passing_score
        if (array_key_exists('final_score', $data) && $data['final_score'] !== null) {
            $course            = $enrollment->course;
            $data['is_passed'] = $data['final_score'] >= $course->passing_score;

            // Auto set completion_date if final_score is set and no completion_date provided
            if (empty($data['completion_date'])) {
                $data['completion_date'] = now();
            }
        }

        $enrollment->update($data);

        // If progress is 100%, mark as completed (if not already)
        if (isset($data['progress']) && $data['progress'] >= 100 && $enrollment->status !== 'completed') {
            $enrollment->update([
                'status'          => 'completed',
                'completion_date' => now(),
            ]);
        }

        return back()->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Verify payment for enrollment
     */
    public function verifyPayment(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:verified,rejected',
            'notes'          => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'payment_status' => $request->payment_status,
        ];

        if ($request->filled('notes')) {
            $data['notes'] = $enrollment->notes
                ? $enrollment->notes . "\n[Payment] " . $request->notes
                : "[Payment] " . $request->notes;
        }

        // If payment verified, auto approve enrollment
        if ($request->payment_status === 'verified' && $enrollment->status === 'pending') {
            $data['status'] = 'approved';
        }

        $enrollment->update($data);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Update progress for enrollment
     */
    public function updateProgress(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'progress' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $enrollment->update([
            'progress' => $request->progress,
        ]);

        // If progress is 100%, mark as completed
        if ($request->progress >= 100 && $enrollment->status !== 'completed') {
            $enrollment->update([
                'status'          => 'completed',
                'completion_date' => now(),
            ]);
        }

        return back()->with('success', 'Progres belajar berhasil diperbarui.');

    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
