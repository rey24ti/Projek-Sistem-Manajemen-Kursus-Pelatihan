<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function index(Course $course)
    {
        $user = Auth::user();
        $enrolled = $course->enrollments()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
        if (!$enrolled) {
            abort(403, 'Anda belum terdaftar di kursus ini.');
        }
        $quizzes = $course->quizzes()->orderBy('order')->get();
        return view('guest.quizzes.index', compact('course', 'quizzes'));
    }

    public function show(Course $course, Quiz $quiz)
    {
        $user = Auth::user();
        $enrolled = $course->enrollments()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
        if (!$enrolled) {
            abort(403, 'Anda belum terdaftar di kursus ini.');
        }
        if ($quiz->course_id != $course->id) {
            abort(404);
        }
        return view('guest.quizzes.show', compact('course', 'quiz'));
    }
}
