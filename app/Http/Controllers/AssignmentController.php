<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }

    public function index(Course $course)
    {
        // Check if user has access to this course
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kursus ini.');
        }

        $assignments = $course->assignments()->orderBy('order')->get();
        return view('staff.assignments.index', compact('course', 'assignments'));
    }

    public function create(Course $course)
    {
        // Check if user has access to this course
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kursus ini.');
        }

        return view('staff.assignments.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        // Check if user has access to this course
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kursus ini.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date',
            'max_score' => 'required|numeric|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('assignments.index', $course)
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Course $course, Assignment $assignment)
    {
        if ($assignment->course_id != $course->id) {
            abort(404);
        }

        // Check if user has access
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $assignment->load(['submissions.user']);
        return view('staff.assignments.show', compact('course', 'assignment'));
    }

    public function edit(Course $course, Assignment $assignment)
    {
        if ($assignment->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        return view('staff.assignments.edit', compact('course', 'assignment'));
    }

    public function update(Request $request, Course $course, Assignment $assignment)
    {
        if ($assignment->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date',
            'max_score' => 'required|numeric|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $assignment->update($request->all());

        return redirect()->route('assignments.index', $course)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Course $course, Assignment $assignment)
    {
        if ($assignment->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $assignment->delete();

        return redirect()->route('assignments.index', $course)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
