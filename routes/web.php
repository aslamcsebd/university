<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('student')->group(function () {
        Route::get('/',              fn() => redirect('/student/dashboard'));
        Route::get('/dashboard',     fn() => view('student.dashboard'))->name('student.dashboard');
        Route::get('/class-schedules', fn() => view('student.class-schedules'))->name('student.class-schedules');
        Route::get('/exam-schedules',  fn() => view('student.exam-schedules'))->name('student.exam-schedules');
        Route::get('/attendances',   fn() => view('student.attendances'))->name('student.attendances');
        Route::get('/apply-leaves',  fn() => view('student.apply-leaves'))->name('student.apply-leaves');
        Route::get('/fees-reports',  fn() => view('student.fees-reports'))->name('student.fees-reports');
        Route::get('/library',       fn() => view('student.library'))->name('student.library');
        Route::get('/notices',       fn() => view('student.notices'))->name('student.notices');
        Route::get('/assignments',   fn() => view('student.assignments'))->name('student.assignments');
        Route::get('/downloads',     fn() => view('student.downloads'))->name('student.downloads');
        Route::get('/transcript',    fn() => view('student.transcript'))->name('student.transcript');
        Route::get('/my-profile',    fn() => view('student.my-profile'))->name('student.my-profile');
    });

    Route::prefix('academic')->group(function () {
        Route::get('/',             fn() => redirect('/academic/departments'));
        Route::get('/departments',  fn() => view('academic.departments'))->name('academic.departments');
        Route::get('/courses',      fn() => view('academic.courses'))->name('academic.courses');
        Route::get('/subjects',     fn() => view('academic.subjects'))->name('academic.subjects');
        Route::get('/semesters',    fn() => view('academic.semesters'))->name('academic.semesters');
        Route::get('/buildings',    fn() => view('academic.buildings'))->name('academic.buildings');
        Route::get('/rooms',        fn() => view('academic.rooms'))->name('academic.rooms');
        Route::get('/staff',        fn() => view('academic.staff'))->name('academic.staff');
        Route::get('/timetable',    fn() => view('academic.timetable'))->name('academic.timetable');
        Route::get('/overview',     fn() => view('academic.overview'))->name('academic.overview');
        Route::get('/tree',          fn() => view('academic.tree'))->name('academic.tree');
    });

    Route::get('/advanced-nav', fn() => view('advanced-nav'))->name('advanced-nav');
});

Route::get('/university', fn() => view('university'))->name('university');

require __DIR__.'/auth.php';
