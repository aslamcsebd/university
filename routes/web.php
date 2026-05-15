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
    });
});

require __DIR__.'/auth.php';
