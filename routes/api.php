<?php

use App\Http\Controllers\Admin\Auth\ManagerAuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Instructor\Auth\InstructorAuthController;
use App\Http\Controllers\Student\CommentController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;


Route::prefix('manager')->middleware(['auth:sanctum', 'is_manager'])->controller(ManagerAuthController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(['auth:sanctum', 'is_manager']);
    Route::post('logout', 'logout');

    Route::prefix('instructor')->controller(InstructorController::class)->group(function () {
        Route::post('/store', 'store');
        Route::post('/show', 'show');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
        Route::post('/restore', 'restore');
    });

    Route::prefix('student')->controller(StudentController::class)->group(function () {
        Route::post('/import', 'import');
        Route::get('/export', 'export')->withoutMiddleware(['auth:sanctum', 'is_manager']);
    });

    Route::prefix('course')->controller(CourseController::class)->group(function () {
        Route::post('/store', 'store');
        Route::post('/show', 'show');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
        Route::post('/restore', 'restore');
        Route::get('/getAllEnrollmentStudents', 'getAllEnrollmentStudents');
        Route::post('/acceptStudent', 'acceptStudent');
    });

    Route::prefix('post')->controller(PostController::class)->group(function () {
        Route::post('/store', 'store');
        Route::post('/show', 'show');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
        Route::post('/restore', 'restore');
    });
});
Route::prefix('instructor')->middleware(['auth:sanctum', 'is_instructor'])->controller(InstructorAuthController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(['auth:sanctum', 'is_instructor']);
    Route::post('logout', 'logout');
});

Route::prefix('student')->middleware(['auth:sanctum', 'is_student'])->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->withoutMiddleware(['auth:sanctum', 'is_student']);
    Route::post('logout', 'logout');

    Route::prefix('course')->controller(StudentCourseController::class)->group(function () {
        Route::post('enroll', 'enroll');
        Route::get('/getAllcourses', 'getAllcourses');
    });

    Route::prefix('comment')->controller(CommentController::class)->group(function(){
        Route::post('/store', 'store');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/attendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/attendance/{course_id}', [AttendanceController::class, 'showAttendance'])->name('attendance.show');
});


Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('courses', CourseController::class);
Route::post('courses/{course}/comments', [CommentController::class, 'store'])->name('courses.comments.store');
Route::post('courses/{course}/like', [LikeController::class, 'store'])->name('courses.like');
Route::delete('courses/{course}/like', [LikeController::class, 'destroy'])->name('courses.unlike');
//Route::post('courses/{course}/like', [LikeController::class, 'toggle'])->name('courses.like');
