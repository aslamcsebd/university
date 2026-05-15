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
        Route::get('/',          fn() => redirect('/academic/staff'));
        Route::get('/staff',     fn() => view('academic.staff'))->name('academic.staff');
        Route::get('/terms',     fn() => view('academic.terms'))->name('academic.terms');
        Route::get('/courses',   fn() => view('academic.courses'))->name('academic.courses');
        Route::get('/rooms',     fn() => view('academic.rooms'))->name('academic.rooms');
        Route::get('/timetable', fn() => view('academic.timetable'))->name('academic.timetable');
        Route::get('/overview',  fn() => view('academic.overview'))->name('academic.overview');
    });
});

require __DIR__.'/auth.php';
