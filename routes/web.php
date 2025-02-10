<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Lecturer routes
    Route::middleware(['role:lecturer'])->group(function () {
        Route::get('/lecturer/dashboard', [LecturerController::class, 'dashboard'])->name('lecturer.dashboard');
        Route::match(['get', 'post'], '/generate-qr', [AttendanceController::class, 'generateQR'])->name('qr.generate');
        Route::get('/analytics', [AttendanceController::class, 'analytics'])->name('lecturer.analytics');
        Route::get('/report', [AttendanceController::class, 'generateReport'])->name('attendance.report');
        Route::get('/attendance/session/{session}/attendees', [AttendanceController::class, 'viewAttendees'])->name('attendance.viewAttendees');
    });

    // Student routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/student/attendance-history', [StudentController::class, 'attendanceHistory'])->name('student.attendance.history');
        Route::get('/scan/{token}', [AttendanceController::class, 'scan'])->name('attendance.scan');
    });
});

// Auth routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Lecturer management routes
    Route::get('/lecturers', [AdminController::class, 'lecturerIndex'])->name('lecturers.index');
    Route::get('/lecturers/create', [AdminController::class, 'lecturerCreate'])->name('lecturers.create');
    Route::post('/lecturers', [AdminController::class, 'lecturerStore'])->name('lecturers.store');
    Route::get('/lecturers/{lecturer}/edit', [AdminController::class, 'lecturerEdit'])->name('lecturers.edit');
    Route::put('/lecturers/{lecturer}', [AdminController::class, 'lecturerUpdate'])->name('lecturers.update');
    Route::delete('/lecturers/{lecturer}', [AdminController::class, 'lecturerDestroy'])->name('lecturers.destroy');
    
    // Student management routes
    Route::get('/students', [AdminController::class, 'studentIndex'])->name('students.index');
    Route::get('/students/create', [AdminController::class, 'studentCreate'])->name('students.create');
    Route::post('/students', [AdminController::class, 'studentStore'])->name('students.store');
    Route::get('/students/{student}/edit', [AdminController::class, 'studentEdit'])->name('students.edit');
    Route::put('/students/{student}', [AdminController::class, 'studentUpdate'])->name('students.update');
    Route::delete('/students/{student}', [AdminController::class, 'studentDestroy'])->name('students.destroy');
});
