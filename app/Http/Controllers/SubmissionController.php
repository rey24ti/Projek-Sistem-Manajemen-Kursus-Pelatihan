<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // For grading assignments (staff/admin only)
    public function gradeAssignment(Request $request, Course $course, Assignment $assignment, Submission $submission)
    {
        if ($assignment->course_id != $course->id || $submission->assignment_id != $assignment->id) {
            abort(404);
        }

        if (!auth()->user()->isAdmin() && !(auth()->user()->isStaff() && $course->trainer_id == auth()->id())) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dinilai.');
    }

    // For grading quizzes (staff/admin only)
    public function gradeQuiz(Request $request, Course $course, Quiz $quiz, Submission $submission)
    {
        if ($quiz->course_id != $course->id || $submission->quiz_id != $quiz->id) {
            abort(404);
        }

        if (!auth()->user()->isAdmin() && !(auth()->user()->isStaff() && $course->trainer_id == auth()->id())) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Kuis berhasil dinilai.');
    }

    // For students to submit assignment
    public function submitAssignment(Request $request, Course $course, Assignment $assignment)
    {
        if ($assignment->course_id != $course->id) {
            abort(404);
        }

        // Check if user is enrolled
        $enrollment = $course->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Anda belum terdaftar pada kursus ini.');
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if already submitted
        $existing = Submission::where('user_id', auth()->id())
            ->where('assignment_id', $assignment->id)
            ->first();

        if ($existing) {
            // Update existing submission
            if ($existing->file_path) {
                Storage::disk('public')->delete($existing->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('submissions', 'public');

            $existing->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return back()->with('success', 'Tugas berhasil diupdate.');
        }

        // Create new submission
        $file = $request->file('file');
        $filePath = $file->store('submissions', 'public');

        Submission::create([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // For students to submit quiz
    public function submitQuiz(Request $request, Course $course, Quiz $quiz)
    {
        if ($quiz->course_id != $course->id) {
            abort(404);
        }

        // Check if user is enrolled
        $enrollment = $course->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Anda belum terdaftar pada kursus ini.');
        }

        // Check if quiz is still open
        if (now() > $quiz->end_date) {
            return back()->with('error', 'Waktu kuis sudah habis.');
        }

        if (now() < $quiz->start_date) {
            return back()->with('error', 'Kuis belum dimulai.');
        }

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if already submitted
        $existing = Submission::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengerjakan kuis ini.');
        }

        // Calculate score automatically (simple calculation, bisa dikembangkan lebih kompleks)
        $questions = $quiz->questions ?? [];
        $userAnswers = $request->answers;
        $correctAnswers = 0;
        $totalQuestions = count($questions);

        foreach ($questions as $index => $question) {
            if (isset($userAnswers[$index]) && isset($question['correct_answer'])) {
                if ($userAnswers[$index] == $question['correct_answer']) {
                    $correctAnswers++;
                }
            }
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $isPassed = $score >= $quiz->passing_score;

        // Create submission
        Submission::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'answers' => $userAnswers,
            'score' => $score,
            'status' => $isPassed ? 'graded' : 'submitted',
            'submitted_at' => now(),
            'graded_at' => $isPassed ? now() : null,
        ]);

        return back()->with('success', 'Kuis berhasil dikumpulkan. Nilai: ' . number_format($score, 2));
    }
}
