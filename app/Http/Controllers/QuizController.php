<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }

    public function index(Course $course)
    {
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kursus ini.');
        }

        $quizzes = $course->quizzes()->orderBy('order')->get();
        return view('staff.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course)
    {
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        return view('staff.quizzes.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'nullable|json',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['course_id'] = $course->id;
        
        // Parse questions if it's a JSON string
        if (isset($data['questions']) && is_string($data['questions'])) {
            $data['questions'] = json_decode($data['questions'], true);
        }

        Quiz::create($data);

        return redirect()->route('quizzes.index', $course)
            ->with('success', 'Kuis berhasil ditambahkan.');
    }

    public function show(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $quiz->load(['submissions.user']);
        return view('staff.quizzes.show', compact('course', 'quiz'));
    }

    public function edit(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        return view('staff.quizzes.edit', compact('course', 'quiz'));
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        if ($quiz->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'nullable|json',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        
        // Parse questions if it's a JSON string
        if (isset($data['questions']) && is_string($data['questions'])) {
            $data['questions'] = json_decode($data['questions'], true);
        }

        $quiz->update($data);

        return redirect()->route('quizzes.index', $course)
            ->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        if ($quiz->course_id != $course->id) {
            abort(404);
        }

        if (auth()->user()->isStaff() && $course->trainer_id != auth()->id()) {
            abort(403);
        }

        $quiz->delete();

        return redirect()->route('quizzes.index', $course)
            ->with('success', 'Kuis berhasil dihapus.');
    }
}
