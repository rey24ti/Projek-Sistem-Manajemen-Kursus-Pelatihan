<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'total_users' => User::where('role', 'guest')->count(),
            'active_courses' => Course::where('status', 'ongoing')->count(),
            'completed_courses' => Course::where('status', 'completed')->count(),
        ];

        // For staff, only show their courses stats
        if (auth()->user()->isStaff()) {
            $stats['total_courses'] = Course::where('trainer_id', auth()->id())->count();
            $stats['total_enrollments'] = Enrollment::whereHas('course', function($q) {
                $q->where('trainer_id', auth()->id());
            })->count();
            $stats['active_courses'] = Course::where('trainer_id', auth()->id())
                ->where('status', 'ongoing')->count();
            $stats['completed_courses'] = Course::where('trainer_id', auth()->id())
                ->where('status', 'completed')->count();
        }

        // Recent enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // For staff, filter by their courses
        if (auth()->user()->isStaff()) {
            $recentEnrollments = Enrollment::whereHas('course', function($q) {
                $q->where('trainer_id', auth()->id());
            })->with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        }

        // Course completion rates
        $courses = Course::withCount(['enrollments as total_enrollments', 
            'enrollments as completed_enrollments' => function($q) {
                $q->where('status', 'completed');
            }])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // For staff, filter by their courses
        if (auth()->user()->isStaff()) {
            $courses = Course::where('trainer_id', auth()->id())
                ->withCount(['enrollments as total_enrollments', 
                    'enrollments as completed_enrollments' => function($q) {
                        $q->where('status', 'completed');
                    }])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        $view = auth()->user()->isAdmin() ? 'admin.reports.index' : 'staff.reports.index';

        return view($view, compact('stats', 'recentEnrollments', 'courses'));
    }
}
