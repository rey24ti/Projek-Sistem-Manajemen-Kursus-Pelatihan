<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);

    // Enrollments (hanya untuk user yang sudah login)
    Route::resource('enrollments', EnrollmentController::class)->except(['create', 'edit']);
    Route::post('enrollments/register', [EnrollmentController::class, 'store'])->name('enrollments.register');
    Route::post('enrollments/{enrollment}/verify-payment', [EnrollmentController::class, 'verifyPayment'])->name('enrollments.verify-payment');
    Route::post('enrollments/{enrollment}/update-progress', [EnrollmentController::class, 'updateProgress'])->name('enrollments.update-progress');

    // Admin routes
    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('materials', CourseMaterialController::class)->except(['index', 'show']);
        Route::resource('users', \App\Http\Controllers\UserController::class);

    });

    // Admin & Staff routes
    Route::group(['middleware' => 'role:admin,staff'], function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // Materials

        Route::get('courses/{course}/materials', [CourseMaterialController::class, 'index'])->name('materials.index');
        Route::get('courses/{course}/materials/create', [CourseMaterialController::class, 'create'])->name('materials.create');
        Route::post('courses/{course}/materials', [CourseMaterialController::class, 'store'])->name('materials.store');
        Route::get('materials/{material}/edit', [CourseMaterialController::class, 'edit'])->name('materials.edit');
        Route::put('materials/{material}', [CourseMaterialController::class, 'update'])->name('materials.update');
        Route::delete('materials/{material}', [CourseMaterialController::class, 'destroy'])->name('materials.destroy');

    });

    // Material download - accessible by enrolled users, admin, and staff
    Route::get('materials/{material}/download', [CourseMaterialController::class, 'show'])->name('materials.download');

    // Assignments
    Route::resource('courses.assignments', \App\Http\Controllers\AssignmentController::class)->except(['show']);
    Route::get('courses/{course}/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'show'])->name('assignments.show');

    // Quizzes
    Route::resource('courses.quizzes', \App\Http\Controllers\QuizController::class)->except(['show']);
    Route::get('courses/{course}/quizzes/{quiz}', [\App\Http\Controllers\QuizController::class, 'show'])->name('quizzes.show');

    // Submissions (grading)
    Route::post('courses/{course}/assignments/{assignment}/submissions/{submission}/grade', [\App\Http\Controllers\SubmissionController::class, 'gradeAssignment'])->name('submissions.grade-assignment');
    Route::post('courses/{course}/quizzes/{quiz}/submissions/{submission}/grade', [\App\Http\Controllers\SubmissionController::class, 'gradeQuiz'])->name('submissions.grade-quiz');
});
Route::post('courses/{course}/quizzes/{quiz}/submit', [\App\Http\Controllers\SubmissionController::class, 'submitQuiz'])->name('submissions.submit-quiz');

// Payment routes (for students)
Route::get('enrollments/{enrollment}/payment', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
Route::post('enrollments/{enrollment}/payment', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
Route::get('payments/{payment}/proof', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');

// Certificate routes
Route::get('enrollments/{enrollment}/certificate', [\App\Http\Controllers\CertificateController::class, 'show'])->name('certificates.show');

// Material download - accessible by enrolled users, admin, and staff
Route::get('materials/{material}/download', [CourseMaterialController::class, 'show'])->name('materials.download');

// Course content routes for enrolled students
Route::get('courses/{course}/student/materials', [CourseMaterialController::class, 'index'])->name('courses.student.materials');
Route::get('courses/{course}/student/assignments', [\App\Http\Controllers\AssignmentController::class, 'index'])->name('courses.student.assignments');
Route::get('courses/{course}/student/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'show'])->name('courses.student.assignments.show');
Route::get('courses/{course}/student/quizzes', [\App\Http\Controllers\QuizController::class, 'index'])->name('courses.student.quizzes');
Route::get('courses/{course}/student/quizzes/{quiz}', [\App\Http\Controllers\QuizController::class, 'show'])->name('courses.student.quizzes.show');



// Routes untuk tamu (belum login)
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [RegisterController::class, 'create'])->name('register');
        // Alias lama yang mungkin masih dipakai di view lama/tercache
        Route::get('/session/register', [RegisterController::class, 'create'])->name('session.register');
        Route::post('/register', [RegisterController::class, 'store']);
        Route::get('/login', [SessionsController::class, 'create']);
        Route::post('/session', [SessionsController::class, 'store']);
        Route::get('/login/forgot-password', [ResetController::class, 'create']);
        Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
        Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
        Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
    });

    Route::get('/login', function () {
        return view('session/login-session');
    })->name('login');

// Halaman utama: semua user (termasuk guest) diarahkan ke daftar kursus
    Route::get('/', [CourseController::class, 'index'])->name('home');

// Courses - index & detail bisa diakses guest tanpa login, yang lain tetap butuh auth (diatur di controller __construct)
    Route::resource('courses', CourseController::class);
