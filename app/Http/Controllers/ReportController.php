<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'total_users' => User::where('role', 'guest')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'active_courses' => Course::where('status', 'ongoing')->count(),
            'completed_courses' => Course::where('status', 'completed')->count(),
            'total_participants' => Enrollment::where('status', 'approved')->count(),
            'total_revenue' => Enrollment::where('payment_status', 'verified')
                ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum('courses.price'),
            'pending_payments' => Enrollment::where('payment_status', 'pending')->count(),
            'passed_students' => Enrollment::where('is_passed', true)->count(),
            'failed_students' => Enrollment::where('is_passed', false)
                ->whereNotNull('final_score')->count(),
        ];

        // For staff, only show their courses stats
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && $user->isStaff()) {
            $stats['total_courses'] = Course::where('trainer_id', $user->id)->count();
            $stats['total_enrollments'] = Enrollment::whereHas('course', function($q) use ($user) {
                $q->where('trainer_id', $user->id);
            })->count();
            $stats['active_courses'] = Course::where('trainer_id', $user->id)
                ->where('status', 'ongoing')->count();
            $stats['completed_courses'] = Course::where('trainer_id', $user->id)
                ->where('status', 'completed')->count();
            $stats['total_participants'] = Enrollment::where('status', 'approved')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
            $stats['total_revenue'] = Enrollment::where('payment_status', 'verified')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })
                ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum('courses.price');
            $stats['pending_payments'] = Enrollment::where('payment_status', 'pending')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
            $stats['passed_students'] = Enrollment::where('is_passed', true)
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
            $stats['failed_students'] = Enrollment::where('is_passed', false)
                ->whereNotNull('final_score')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
        }

        // Recent enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // For staff, filter by their courses
        if ($user && $user->isStaff()) {
            $recentEnrollments = Enrollment::whereHas('course', function($q) use ($user) {
                $q->where('trainer_id', $user->id);
            })->with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        }

        // Course completion rates with progress and graduation stats
        $courses = Course::withCount([
                'enrollments as total_enrollments',
                'enrollments as completed_enrollments' => function($q) {
                    $q->where('status', 'completed');
                },
                'enrollments as passed_enrollments' => function($q) {
                    $q->where('is_passed', true);
                },
                'enrollments as paid_enrollments' => function($q) {
                    $q->where('payment_status', 'verified');
                }
            ])
            ->withAvg('enrollments as avg_progress', 'progress')

            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // For staff, filter by their courses
        if ($user && $user->isStaff()) {
            $courses = Course::where('trainer_id', $user->id)

                ->withCount(['enrollments as total_enrollments', 
                    'enrollments as completed_enrollments' => function($q) {
                        $q->where('status', 'completed');
                    }])

                ->withCount([
                    'enrollments as total_enrollments',
                    'enrollments as completed_enrollments' => function($q) {
                        $q->where('status', 'completed');
                    },
                    'enrollments as passed_enrollments' => function($q) {
                        $q->where('is_passed', true);
                    },
                    'enrollments as paid_enrollments' => function($q) {
                        $q->where('payment_status', 'verified');
                    }
                ])
                ->withAvg('enrollments as avg_progress', 'progress')

                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        // Progress statistics
        $progressQuery = function() use (&$user) {
            $query = Enrollment::query();
            if ($user && $user->isStaff()) {
                $query->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                });
            }
            return $query;
        };
        
        $progressStats = [
            'avg_progress' => $progressQuery()->avg('progress') ?? 0,
            'high_progress' => $progressQuery()->where('progress', '>=', 80)->count(),
            'medium_progress' => $progressQuery()->whereBetween('progress', [50, 79])->count(),
            'low_progress' => $progressQuery()->where('progress', '<', 50)->count(),
        ];

        // Graduation statistics
        $graduationQuery = function() use (&$user) {
            $query = Enrollment::query();
            if ($user && $user->isStaff()) {
                $query->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                });
            }
            return $query;
        };
        
        $totalWithScore = $graduationQuery()->whereNotNull('final_score')->count();
        $totalPassed = $graduationQuery()->where('is_passed', true)->count();
        $graduationStats = [
            'total_completed' => $graduationQuery()->where('status', 'completed')->count(),
            'total_passed' => $totalPassed,
            'total_failed' => $graduationQuery()->where('is_passed', false)->whereNotNull('final_score')->count(),
            'pass_rate' => $totalWithScore > 0 ? ($totalPassed / $totalWithScore) * 100 : 0,
        ];

        // Financial statistics
        $financialStats = [
            'total_revenue' => $stats['total_revenue'],
            'pending_revenue' => Enrollment::where('payment_status', 'pending')
                ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum('courses.price'),
            'verified_payments' => Enrollment::where('payment_status', 'verified')->count(),
            'pending_payments' => Enrollment::where('payment_status', 'pending')->count(),
        ];

        // For staff, filter financial stats
        if ($user && $user->isStaff()) {
            $financialStats['pending_revenue'] = Enrollment::where('payment_status', 'pending')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })
                ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum('courses.price');
            $financialStats['verified_payments'] = Enrollment::where('payment_status', 'verified')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
            $financialStats['pending_payments'] = Enrollment::where('payment_status', 'pending')
                ->whereHas('course', function($q) use ($user) {
                    $q->where('trainer_id', $user->id);
                })->count();
        }

        // Instructor activity (only for admin)
        $instructorActivity = [];
        if ($user && $user->isAdmin()) {
            // Fetch top staff by course count then compute additional metrics in PHP to avoid fragile SQL joins in withCount
            $instructorActivity = User::where('role', 'staff')
                ->withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->limit(10)
                ->get()
                ->map(function($u) {
                    $u->active_courses_count = $u->courses()->where('status', 'ongoing')->count();
                    $u->enrollments_count = Enrollment::whereHas('course', function($q) use ($u) {
                        $q->where('trainer_id', $u->id);
                    })->count();
                    return $u;
                });
        }

        $view = ($user && $user->isAdmin()) ? 'admin.reports.index' : 'staff.reports.index';

        return view($view, compact('stats', 'recentEnrollments', 'courses', 'progressStats', 'graduationStats', 'financialStats', 'instructorActivity'));
    }
}
