<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);

        // For staff, only show enrollments for their courses
        if (auth()->user()->isStaff()) {
            $query->whereHas('course', function($q) {
                $q->where('trainer_id', auth()->id());
            });
    }

        // For guest, only show their own enrollments
        if (auth()->user()->isGuest()) {
            $query->where('user_id', auth()->id());
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->whereHas('course', function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            })->orWhereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(10);

        $view = auth()->user()->isAdmin() ? 'admin.enrollments.index' : 
                (auth()->user()->isStaff() ? 'staff.enrollments.index' : 'guest.enrollments.index');

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

        // Check if already enrolled
        $existing = Enrollment::where('user_id', auth()->id())
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
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'status' => 'pending',
            'enrollment_date' => now(),
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu persetujuan.');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,completed',
            'progress' => 'nullable|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $enrollment->update($request->all());

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
