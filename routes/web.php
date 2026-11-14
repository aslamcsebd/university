<?php

use App\Http\Controllers\Finance;
use App\Http\Controllers\Examination;
use App\Http\Controllers\Admission;
use App\Http\Controllers\Students;
use App\Http\Controllers\Academic;
use App\Http\Controllers\HR;
use App\Http\Controllers\Payroll;
use App\Http\Controllers\Library;
use App\Http\Controllers\Hostel;
use App\Http\Controllers\Transport;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\Study;
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

    // ─── PHASE 4 — ADMISSION & STUDENTS ─────────────────────────────────

    // Admission Applications
    Route::resource('admissions', Admission\AdmissionController::class);
    Route::patch('/admissions/{admission}/status', [Admission\AdmissionController::class, 'updateStatus'])->name('admissions.status');
    Route::post('/admissions/{admission}/convert', [Admission\AdmissionController::class, 'convert'])->name('admissions.convert');

    // Admission Status Types
    Route::get('/admission-statuses', [Admission\AdmissionStatusController::class, 'index'])->name('admission.statuses.index');
    Route::post('/admission-statuses', [Admission\AdmissionStatusController::class, 'store'])->name('admission.statuses.store');
    Route::put('/admission-statuses/{status}', [Admission\AdmissionStatusController::class, 'update'])->name('admission.statuses.update');
    Route::delete('/admission-statuses/{status}', [Admission\AdmissionStatusController::class, 'destroy'])->name('admission.statuses.destroy');

    // Students
    Route::resource('students', Students\StudentController::class);
    Route::post('/students/{student}/notes', [Students\StudentController::class, 'storeNote'])->name('students.notes.store');

    // Enrollments
    Route::get('/enrollments', [Students\EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/enrollments/create', [Students\EnrollmentController::class, 'create'])->name('enrollments.create');
    Route::post('/enrollments', [Students\EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::get('/enrollments/bulk', fn() => view('students.bulk-enroll', [
        'semesters' => \App\Models\Semester::with('academicSession')->orderByDesc('created_at')->get(),
        'sections'  => \App\Models\Section::with('batch')->orderBy('name')->get(),
    ]))->name('enrollments.bulk');
    Route::post('/enrollments/bulk', [Students\EnrollmentController::class, 'bulkEnroll'])->name('enrollments.bulk-store');
    Route::patch('/enrollments/{enrollment}/withdraw', [Students\EnrollmentController::class, 'withdraw'])->name('enrollments.withdraw');

    // Leave (student)
    Route::get('/leave', ComingSoonController::class)->name('leave.index');

    // ─── PHASE 5 — ACADEMIC OPERATIONS ──────────────────────────────────

    // Grading System
    Route::resource('grading', Examination\GradingController::class);
    Route::post('/grading/{grading}/rules', [Examination\GradingController::class, 'storeRule'])->name('grading.rules.store');
    Route::delete('/grading/{grading}/rules/{rule}', [Examination\GradingController::class, 'destroyRule'])->name('grading.rules.destroy');
    Route::post('/grading/{grading}/seed', [Examination\GradingController::class, 'seedDefault'])->name('grading.seed');

    // Class Schedules
    Route::get('/schedules', [Academic\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [Academic\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [Academic\ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{schedule}', [Academic\ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Exam Schedules
    Route::get('/exam-schedules', [Academic\ExamScheduleController::class, 'index'])->name('exam-schedules.index');
    Route::post('/exam-schedules', [Academic\ExamScheduleController::class, 'store'])->name('exam-schedules.store');
    Route::post('/exam-schedules/{examSchedule}/publish', [Academic\ExamScheduleController::class, 'publish'])->name('exam-schedules.publish');
    Route::delete('/exam-schedules/{examSchedule}', [Academic\ExamScheduleController::class, 'destroy'])->name('exam-schedules.destroy');

    // Timetable view
    Route::get('/timetable', fn() => redirect()->route('schedules.index'))->name('timetable.index');

    // Student Attendance
    Route::get('/attendance/students', [Examination\AttendanceController::class, 'studentsIndex'])->name('attendance.students.index');
    Route::post('/attendance/students', [Examination\AttendanceController::class, 'markStudents'])->name('attendance.students.mark');
    Route::get('/attendance/students/list', [Examination\AttendanceController::class, 'getStudentsForCourse'])->name('attendance.students.list');

    // Staff Attendance
    Route::get('/attendance/staff', [Examination\AttendanceController::class, 'staffIndex'])->name('attendance.staff.index');
    Route::post('/attendance/staff', [Examination\AttendanceController::class, 'markStaff'])->name('attendance.staff.mark');

    // Exam Types
    Route::get('/exam-types', [Examination\ExamController::class, 'typesIndex'])->name('exam-types.index');
    Route::post('/exam-types', [Examination\ExamController::class, 'storeType'])->name('exam-types.store');
    Route::delete('/exam-types/{examType}', [Examination\ExamController::class, 'destroyType'])->name('exam-types.destroy');

    // Mark Distributions
    Route::get('/mark-distributions', [Examination\ExamController::class, 'distributionsIndex'])->name('mark-distributions.index');
    Route::post('/mark-distributions', [Examination\ExamController::class, 'storeDistribution'])->name('mark-distributions.store');
    Route::delete('/mark-distributions/{distribution}', [Examination\ExamController::class, 'destroyDistribution'])->name('mark-distributions.destroy');

    // Mark Entry
    Route::get('/marks', [Examination\ExamController::class, 'marksIndex'])->name('marks.index');
    Route::post('/marks', [Examination\ExamController::class, 'saveMarks'])->name('marks.save');

    // Results
    Route::get('/results', [Examination\ResultController::class, 'index'])->name('results.index');
    Route::post('/results/process', [Examination\ResultController::class, 'process'])->name('results.process');
    Route::post('/results/publish', [Examination\ResultController::class, 'publish'])->name('results.publish');

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

    // ─── PHASE 6 — FINANCE ───────────────────────────────────────────────

    // Fee Types
    Route::get('/fee-types', [Finance\FeeController::class, 'typesIndex'])->name('fee-types.index');
    Route::post('/fee-types', [Finance\FeeController::class, 'storeType'])->name('fee-types.store');
    Route::put('/fee-types/{feeType}', [Finance\FeeController::class, 'updateType'])->name('fee-types.update');
    Route::delete('/fee-types/{feeType}', [Finance\FeeController::class, 'destroyType'])->name('fee-types.destroy');

    // Fee Assignments
    Route::get('/fee-assignments', [Finance\FeeController::class, 'assignmentsIndex'])->name('fee-assignments.index');
    Route::get('/fee-assignments/create', [Finance\FeeController::class, 'createAssignment'])->name('fee-assignments.create');
    Route::post('/fee-assignments', [Finance\FeeController::class, 'storeAssignment'])->name('fee-assignments.store');
    Route::post('/fee-assignments/bulk', [Finance\FeeController::class, 'bulkAssign'])->name('fee-assignments.bulk');
    Route::post('/fee-assignments/{assignment}/waive', [Finance\FeeController::class, 'waive'])->name('fee-assignments.waive');
    Route::get('/fee-assignments/due', [Finance\FeeController::class, 'dueIndex'])->name('fee-assignments.due');

    // Payments
    Route::get('/payments', [Finance\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [Finance\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [Finance\PaymentController::class, 'store'])->name('payments.store');

    // Income & Expense
    Route::get('/finance/overview', [Finance\PaymentController::class, 'overviewIndex'])->name('finance.overview');
    Route::get('/finance/incomes', [Finance\PaymentController::class, 'incomeIndex'])->name('finance.incomes.index');
    Route::post('/finance/incomes', [Finance\PaymentController::class, 'storeIncome'])->name('finance.incomes.store');
    Route::get('/finance/expenses', [Finance\PaymentController::class, 'expenseIndex'])->name('finance.expenses.index');
    Route::post('/finance/expenses', [Finance\PaymentController::class, 'storeExpense'])->name('finance.expenses.store');
    Route::post('/finance/income-categories', [Finance\PaymentController::class, 'storeCategoryIncome'])->name('finance.income-categories.store');
    Route::post('/finance/expense-categories', [Finance\PaymentController::class, 'storeCategoryExpense'])->name('finance.expense-categories.store');

    // Scholarships
    Route::get('/scholarships', [Finance\ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::post('/scholarships', [Finance\ScholarshipController::class, 'store'])->name('scholarships.store');
    Route::delete('/scholarships/{scholarship}', [Finance\ScholarshipController::class, 'destroy'])->name('scholarships.destroy');
    Route::get('/scholarships/applications', [Finance\ScholarshipController::class, 'applicationsIndex'])->name('scholarships.applications');
    Route::post('/scholarships/apply', [Finance\ScholarshipController::class, 'apply'])->name('scholarships.apply');
    Route::post('/scholarships/applications/{application}/approve', [Finance\ScholarshipController::class, 'approve'])->name('scholarships.approve');
    Route::post('/scholarships/applications/{application}/reject', [Finance\ScholarshipController::class, 'reject'])->name('scholarships.reject');

    // ─── PHASE 7 — UNIVERSITY SERVICES ──────────────────────────────────

    // Library — Book Categories
    Route::get('/book-categories', [Library\BookCategoryController::class, 'index'])->name('book-categories.index');
    Route::post('/book-categories', [Library\BookCategoryController::class, 'store'])->name('book-categories.store');
    Route::put('/book-categories/{bookCategory}', [Library\BookCategoryController::class, 'update'])->name('book-categories.update');
    Route::delete('/book-categories/{bookCategory}', [Library\BookCategoryController::class, 'destroy'])->name('book-categories.destroy');

    // Library — Books
    Route::get('/books', [Library\BookController::class, 'index'])->name('books.index');
    Route::post('/books', [Library\BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [Library\BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [Library\BookController::class, 'destroy'])->name('books.destroy');

    // Library — Members
    Route::get('/library/student-members', [Library\LibraryMemberController::class, 'studentMembers'])->name('library.student-members');
    Route::get('/library/staff-members', [Library\LibraryMemberController::class, 'staffMembers'])->name('library.staff-members');
    Route::get('/library/outsider-members', [Library\LibraryMemberController::class, 'outsiderMembers'])->name('library.outsider-members');
    Route::post('/library/members', [Library\LibraryMemberController::class, 'store'])->name('library.members.store');
    Route::put('/library/members/{member}', [Library\LibraryMemberController::class, 'update'])->name('library.members.update');
    Route::delete('/library/members/{member}', [Library\LibraryMemberController::class, 'destroy'])->name('library.members.destroy');

    // Library — Issue & Return
    Route::get('/library/issue-book', [Library\BookIssueController::class, 'issueIndex'])->name('library.issue-book');
    Route::post('/library/issue-book', [Library\BookIssueController::class, 'issue'])->name('library.issue');
    Route::get('/library/issue-return', [Library\BookIssueController::class, 'returnIndex'])->name('library.issue-return');
    Route::post('/library/issue-return/{issue}/return', [Library\BookIssueController::class, 'processReturn'])->name('library.return');
    Route::get('/library/book-return-due', [Library\BookIssueController::class, 'overdueIndex'])->name('library.overdue');

    // Library — Book Requests
    Route::get('/library/book-requests', [Library\BookRequestController::class, 'index'])->name('library.book-requests');
    Route::post('/library/book-requests', [Library\BookRequestController::class, 'store'])->name('library.book-requests.store');
    Route::patch('/library/book-requests/{bookRequest}/status', [Library\BookRequestController::class, 'updateStatus'])->name('library.book-requests.status');

    // Library — Card Setting
    Route::get('/library/card-setting', [Library\LibraryCardSettingController::class, 'index'])->name('library.card-setting');
    Route::put('/library/card-setting', [Library\LibraryCardSettingController::class, 'update'])->name('library.card-setting.update');

    // Hostel
    Route::get('/hostels', [Hostel\HostelController::class, 'index'])->name('hostels.index');
    Route::post('/hostels', [Hostel\HostelController::class, 'store'])->name('hostels.store');
    Route::put('/hostels/{hostel}', [Hostel\HostelController::class, 'update'])->name('hostels.update');
    Route::delete('/hostels/{hostel}', [Hostel\HostelController::class, 'destroy'])->name('hostels.destroy');

    Route::get('/hostel-room-types', [Hostel\HostelRoomTypeController::class, 'index'])->name('hostel-room-types.index');
    Route::post('/hostel-room-types', [Hostel\HostelRoomTypeController::class, 'store'])->name('hostel-room-types.store');
    Route::put('/hostel-room-types/{roomType}', [Hostel\HostelRoomTypeController::class, 'update'])->name('hostel-room-types.update');
    Route::delete('/hostel-room-types/{roomType}', [Hostel\HostelRoomTypeController::class, 'destroy'])->name('hostel-room-types.destroy');

    Route::get('/hostel-rooms', [Hostel\HostelRoomController::class, 'index'])->name('hostel-rooms.index');
    Route::post('/hostel-rooms', [Hostel\HostelRoomController::class, 'store'])->name('hostel-rooms.store');
    Route::put('/hostel-rooms/{hostelRoom}', [Hostel\HostelRoomController::class, 'update'])->name('hostel-rooms.update');
    Route::delete('/hostel-rooms/{hostelRoom}', [Hostel\HostelRoomController::class, 'destroy'])->name('hostel-rooms.destroy');

    Route::get('/hostel/students', [Hostel\HostelAllocationController::class, 'studentIndex'])->name('hostel.students');
    Route::get('/hostel/staff', [Hostel\HostelAllocationController::class, 'staffIndex'])->name('hostel.staff');
    Route::post('/hostel/allocations', [Hostel\HostelAllocationController::class, 'store'])->name('hostel.allocations.store');
    Route::patch('/hostel/allocations/{allocation}/vacate', [Hostel\HostelAllocationController::class, 'vacate'])->name('hostel.allocations.vacate');

    // Transport
    Route::get('/vehicles', [Transport\VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/vehicles', [Transport\VehicleController::class, 'store'])->name('vehicles.store');
    Route::put('/vehicles/{vehicle}', [Transport\VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [Transport\VehicleController::class, 'destroy'])->name('vehicles.destroy');

    Route::get('/transport-routes', [Transport\TransportRouteController::class, 'index'])->name('transport-routes.index');
    Route::post('/transport-routes', [Transport\TransportRouteController::class, 'store'])->name('transport-routes.store');
    Route::put('/transport-routes/{route}', [Transport\TransportRouteController::class, 'update'])->name('transport-routes.update');
    Route::delete('/transport-routes/{route}', [Transport\TransportRouteController::class, 'destroy'])->name('transport-routes.destroy');
    Route::post('/transport-routes/{route}/stops', [Transport\TransportRouteController::class, 'storeStop'])->name('transport-routes.stops.store');
    Route::delete('/transport-routes/{route}/stops/{stop}', [Transport\TransportRouteController::class, 'destroyStop'])->name('transport-routes.stops.destroy');

    Route::get('/transport/students', [Transport\TransportAllocationController::class, 'studentIndex'])->name('transport.students');
    Route::get('/transport/staff', [Transport\TransportAllocationController::class, 'staffIndex'])->name('transport.staff');
    Route::post('/transport/allocations', [Transport\TransportAllocationController::class, 'store'])->name('transport.allocations.store');
    Route::patch('/transport/allocations/{allocation}/deactivate', [Transport\TransportAllocationController::class, 'deactivate'])->name('transport.allocations.deactivate');

    // Inventory
    Route::get('/item-categories', [Inventory\ItemCategoryController::class, 'index'])->name('item-categories.index');
    Route::post('/item-categories', [Inventory\ItemCategoryController::class, 'store'])->name('item-categories.store');
    Route::put('/item-categories/{category}', [Inventory\ItemCategoryController::class, 'update'])->name('item-categories.update');
    Route::delete('/item-categories/{category}', [Inventory\ItemCategoryController::class, 'destroy'])->name('item-categories.destroy');

    Route::get('/stores', [Inventory\StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores', [Inventory\StoreController::class, 'store'])->name('stores.store');
    Route::put('/stores/{store}', [Inventory\StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [Inventory\StoreController::class, 'destroy'])->name('stores.destroy');

    Route::get('/suppliers', [Inventory\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [Inventory\SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [Inventory\SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [Inventory\SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/items', [Inventory\ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [Inventory\ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{item}', [Inventory\ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [Inventory\ItemController::class, 'destroy'])->name('items.destroy');

    Route::get('/item-stocks', [Inventory\ItemStockController::class, 'index'])->name('item-stocks.index');
    Route::post('/item-stocks', [Inventory\ItemStockController::class, 'store'])->name('item-stocks.store');

    Route::get('/issue-items', [Inventory\ItemIssueController::class, 'issueIndex'])->name('issue-items.index');
    Route::post('/issue-items', [Inventory\ItemIssueController::class, 'issue'])->name('issue-items.issue');
    Route::get('/issue-items/return', [Inventory\ItemIssueController::class, 'returnIndex'])->name('issue-items.return-index');
    Route::post('/issue-items/{issue}/return', [Inventory\ItemIssueController::class, 'processReturn'])->name('issue-items.return');

    // Study Materials
    Route::get('/content-types', [Study\ContentTypeController::class, 'index'])->name('content-types.index');
    Route::post('/content-types', [Study\ContentTypeController::class, 'store'])->name('content-types.store');
    Route::put('/content-types/{contentType}', [Study\ContentTypeController::class, 'update'])->name('content-types.update');
    Route::delete('/content-types/{contentType}', [Study\ContentTypeController::class, 'destroy'])->name('content-types.destroy');

    Route::get('/study-contents', [Study\StudyContentController::class, 'index'])->name('study-contents.index');
    Route::post('/study-contents', [Study\StudyContentController::class, 'store'])->name('study-contents.store');
    Route::delete('/study-contents/{content}', [Study\StudyContentController::class, 'destroy'])->name('study-contents.destroy');
    Route::get('/study-downloads', [Study\StudyContentController::class, 'downloadsIndex'])->name('study-downloads.index');

    Route::get('/assignments', [Study\AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments', [Study\AssignmentController::class, 'store'])->name('assignments.store');
    Route::put('/assignments/{assignment}', [Study\AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [Study\AssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Front Desk
    Route::get('/visitors', ComingSoonController::class)->name('visitors.index');
    Route::get('/enquiries', ComingSoonController::class)->name('enquiries.index');
    Route::get('/complaints', ComingSoonController::class)->name('complaints.index');

    // Transcripts
    Route::get('/transcripts', ComingSoonController::class)->name('transcripts.index');

    // Communication
    Route::get('/notices', ComingSoonController::class)->name('notices.index');
    Route::get('/events', ComingSoonController::class)->name('events.index');

    // Front Website
    Route::get('/frontweb/pages', ComingSoonController::class)->name('frontweb.pages.index');
    Route::get('/frontweb/news', ComingSoonController::class)->name('frontweb.news.index');
    Route::get('/frontweb/sliders', ComingSoonController::class)->name('frontweb.sliders.index');
});

require __DIR__ . '/auth.php';
