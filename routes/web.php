<?php

use App\Http\Controllers\Academic;
use App\Http\Controllers\HR;
use App\Http\Controllers\Payroll;
use App\Http\Controllers\ComingSoonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Settings\GeneralSettingsController;
use App\Http\Controllers\Audit\AuditController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── USERS ────────────────────────────────────────────────────────────
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');

    // ─── ROLES & PERMISSIONS ──────────────────────────────────────────────
    Route::resource('roles', RoleController::class)->except(['show']);

    // ─── SETTINGS ─────────────────────────────────────────────────────────
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general',  [GeneralSettingsController::class, 'index'])->name('general');
        Route::put('/general',  [GeneralSettingsController::class, 'update'])->name('general.update');

        // Coming soon settings pages
        Route::get('/states-provinces',    ComingSoonController::class)->name('states');
        Route::get('/districts-cities',    ComingSoonController::class)->name('districts');
        Route::get('/mail-setting',        ComingSoonController::class)->name('mail');
        Route::get('/sms-getaways',        ComingSoonController::class)->name('sms');
        Route::get('/payment-getaways',    ComingSoonController::class)->name('payment');
        Route::get('/online-application',  ComingSoonController::class)->name('online-application');
        Route::get('/student-panel',       ComingSoonController::class)->name('student-panel');
    });

    // ─── AUDIT LOGS ───────────────────────────────────────────────────────
    Route::prefix('audit')->name('audit.')->group(function () {
        Route::get('/',      [AuditController::class, 'index'])->name('index');
        Route::get('/{activity}', [AuditController::class, 'show'])->name('show');
    });

    // ─── NOTIFICATIONS (placeholder) ─────────────────────────────────────
    Route::get('/notifications', ComingSoonController::class)->name('notifications.index');

    // ─── PHASE 2 — UNIVERSITY STRUCTURE ──────────────────────────────────

    // Academic Overview
    Route::get('/academic', [Academic\AcademicController::class, 'index'])->name('academic.index');

    // Campuses
    Route::resource('campuses', Academic\CampusController::class);

    // Buildings
    Route::resource('buildings', Academic\BuildingController::class);

    // Rooms
    Route::resource('rooms', Academic\RoomController::class);

    // Faculties
    Route::resource('faculties', Academic\FacultyController::class);

    // Departments
    Route::resource('departments', Academic\DepartmentController::class);

    // Academic Sessions + Semesters
    Route::resource('sessions', Academic\AcademicSessionController::class);
    Route::post('/sessions/{session}/semesters', [Academic\AcademicSessionController::class, 'storeSemester'])->name('sessions.semesters.store');
    Route::delete('/sessions/{session}/semesters/{semester}', [Academic\AcademicSessionController::class, 'destroySemester'])->name('sessions.semesters.destroy');

    // Programs
    Route::resource('programs', Academic\ProgramController::class);

    // Courses + Subjects
    Route::resource('courses', Academic\CourseController::class);
    Route::post('/courses/{course}/subjects', [Academic\CourseController::class, 'storeSubject'])->name('courses.subjects.store');
    Route::delete('/courses/{course}/subjects/{subject}', [Academic\CourseController::class, 'destroySubject'])->name('courses.subjects.destroy');

    // Batches + Sections
    Route::resource('batches', Academic\BatchController::class);
    Route::post('/batches/{batch}/sections', [Academic\BatchController::class, 'storeSection'])->name('batches.sections.store');
    Route::delete('/batches/{batch}/sections/{section}', [Academic\BatchController::class, 'destroySection'])->name('batches.sections.destroy');

    // Admission & Students
    Route::get('/admissions', ComingSoonController::class)->name('admissions.index');
    Route::get('/admissions/create', ComingSoonController::class)->name('admissions.create');
    Route::get('/students', ComingSoonController::class)->name('students.index');
    Route::get('/enrollments', ComingSoonController::class)->name('enrollments.index');
    Route::get('/leave', ComingSoonController::class)->name('leave.index');

    // Schedule & Timetable
    Route::get('/schedules', ComingSoonController::class)->name('schedules.index');
    Route::get('/exam-schedules', ComingSoonController::class)->name('exam-schedules.index');
    Route::get('/timetable', ComingSoonController::class)->name('timetable.index');

    // Examinations
    Route::get('/exam-types', ComingSoonController::class)->name('exam-types.index');
    Route::get('/mark-distributions', ComingSoonController::class)->name('mark-distributions.index');
    Route::get('/marks', ComingSoonController::class)->name('marks.index');
    Route::get('/results', ComingSoonController::class)->name('results.index');
    Route::get('/grading', ComingSoonController::class)->name('grading.index');

    // ─── PHASE 3 — HR, TEACHERS & PAYROLL ────────────────────────────────

    // Staff
    Route::resource('staff', HR\StaffController::class);
    Route::patch('/staff/{staff}/toggle', [HR\StaffController::class, 'toggleStatus'])->name('staff.toggle');

    // Teachers
    Route::resource('teachers', HR\TeacherController::class);

    // Designations
    Route::get('/designations', [HR\DesignationController::class, 'index'])->name('designations.index');
    Route::post('/designations', [HR\DesignationController::class, 'store'])->name('designations.store');
    Route::put('/designations/{designation}', [HR\DesignationController::class, 'update'])->name('designations.update');
    Route::delete('/designations/{designation}', [HR\DesignationController::class, 'destroy'])->name('designations.destroy');

    // Work Shifts
    Route::get('/shifts', [HR\WorkShiftController::class, 'index'])->name('shifts.index');
    Route::post('/shifts', [HR\WorkShiftController::class, 'store'])->name('shifts.store');
    Route::put('/shifts/{shift}', [HR\WorkShiftController::class, 'update'])->name('shifts.update');
    Route::delete('/shifts/{shift}', [HR\WorkShiftController::class, 'destroy'])->name('shifts.destroy');

    // Leave Types
    Route::get('/leave-types', [HR\LeaveTypeController::class, 'index'])->name('leave-types.index');
    Route::post('/leave-types', [HR\LeaveTypeController::class, 'store'])->name('leave-types.store');
    Route::put('/leave-types/{leaveType}', [HR\LeaveTypeController::class, 'update'])->name('leave-types.update');
    Route::delete('/leave-types/{leaveType}', [HR\LeaveTypeController::class, 'destroy'])->name('leave-types.destroy');

    // Leave Management
    Route::get('/staff-leave', [HR\LeaveController::class, 'index'])->name('staff-leave.index');
    Route::post('/staff-leave/{application}/approve', [HR\LeaveController::class, 'approve'])->name('staff-leave.approve');
    Route::post('/staff-leave/{application}/reject', [HR\LeaveController::class, 'reject'])->name('staff-leave.reject');

    // HR Overview
    Route::get('/hr', fn() => redirect()->route('staff.index'))->name('hr.index');

    // Attendance (Phase 5)
    Route::get('/attendance/students', ComingSoonController::class)->name('attendance.students.index');
    Route::get('/attendance/staff', ComingSoonController::class)->name('attendance.staff.index');

    // Salary Structures
    Route::get('/salary', [Payroll\SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salary/{staff}/edit', [Payroll\SalaryController::class, 'edit'])->name('salary.edit');
    Route::put('/salary/{staff}', [Payroll\SalaryController::class, 'update'])->name('salary.update');

    // Payroll
    Route::get('/payroll', [Payroll\PayrollController::class, 'index'])->name('payroll.index');
    Route::post('/payroll/generate', [Payroll\PayrollController::class, 'generate'])->name('payroll.generate');
    Route::post('/payroll/{payroll}/approve', [Payroll\PayrollController::class, 'approve'])->name('payroll.approve');
    Route::post('/payroll/{payroll}/paid', [Payroll\PayrollController::class, 'markPaid'])->name('payroll.paid');
    Route::delete('/payroll/{payroll}', [Payroll\PayrollController::class, 'destroy'])->name('payroll.destroy');

    // Finance
    Route::get('/fee-types', ComingSoonController::class)->name('fee-types.index');
    Route::get('/fee-assignments', ComingSoonController::class)->name('fee-assignments.index');
    Route::get('/payments', ComingSoonController::class)->name('payments.index');
    Route::get('/scholarships', ComingSoonController::class)->name('scholarships.index');

    // Facilities
    Route::get('/library', ComingSoonController::class)->name('library.index');
    Route::get('/hostel', ComingSoonController::class)->name('hostel.index');
    Route::get('/transport', ComingSoonController::class)->name('transport.index');

    // Inventory
    Route::get('/inventory', ComingSoonController::class)->name('inventory.index');
    Route::get('/suppliers', ComingSoonController::class)->name('suppliers.index');

    // Front Desk
    Route::get('/visitors', ComingSoonController::class)->name('visitors.index');
    Route::get('/enquiries', ComingSoonController::class)->name('enquiries.index');
    Route::get('/complaints', ComingSoonController::class)->name('complaints.index');

    // Study Materials
    Route::get('/study-materials', ComingSoonController::class)->name('study-materials.index');

    // Transcripts
    Route::get('/transcripts', ComingSoonController::class)->name('transcripts.index');

    // Reports
    Route::get('/reports', ComingSoonController::class)->name('reports.index');

    // Communication
    Route::get('/notices', ComingSoonController::class)->name('notices.index');
    Route::get('/events', ComingSoonController::class)->name('events.index');

    // Front Website
    Route::get('/frontweb/pages', ComingSoonController::class)->name('frontweb.pages.index');
    Route::get('/frontweb/news', ComingSoonController::class)->name('frontweb.news.index');
    Route::get('/frontweb/sliders', ComingSoonController::class)->name('frontweb.sliders.index');
});

require __DIR__ . '/auth.php';
