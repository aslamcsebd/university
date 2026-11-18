<?php

use App\Http\Controllers\Library;
use App\Http\Controllers\Facilities;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\Study;
use App\Http\Controllers\Finance;
use App\Http\Controllers\Examination;
use App\Http\Controllers\Admission;
use App\Http\Controllers\Students;
use App\Http\Controllers\Academic;
use App\Http\Controllers\HR;
use App\Http\Controllers\Payroll;
use App\Http\Controllers\Communication;
use App\Http\Controllers\FrontDesk;
use App\Http\Controllers\Transcripts;
use App\Http\Controllers\Reports;
use App\Http\Controllers\FrontWeb;
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

    // Theme toggle
    Route::post('/theme', function (\Illuminate\Http\Request $request) {
        $theme = $request->input('theme') === 'dark' ? 'dark' : 'light';
        \App\Models\Setting::set('general.theme', $theme);
        return response()->json(['ok' => true]);
    })->name('theme.save');

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
    // Notifications
    Route::get('/notifications', [Communication\NoticeController::class, 'notificationsIndex'])->name('notifications.index');

    // ─── PHASE 2 — UNIVERSITY STRUCTURE ──────────────────────────────────

    // Academic Overview
    Route::get('/academic', [Academic\AcademicController::class, 'index'])->name('academic.index');

    // Campuses
    Route::resource('campuses', Academic\CampusController::class)->except(['show']);

    // Buildings
    Route::resource('buildings', Academic\BuildingController::class)->except(['show']);

    // Rooms
    Route::resource('rooms', Academic\RoomController::class)->except(['show']);

    // Faculties
    Route::resource('faculties', Academic\FacultyController::class)->except(['show']);

    // Departments
    Route::resource('departments', Academic\DepartmentController::class)->except(['show']);

    // Academic Sessions + Semesters
    Route::resource('sessions', Academic\AcademicSessionController::class)->except(['show']);
    Route::post('/sessions/{session}/semesters', [Academic\AcademicSessionController::class, 'storeSemester'])->name('sessions.semesters.store');
    Route::delete('/sessions/{session}/semesters/{semester}', [Academic\AcademicSessionController::class, 'destroySemester'])->name('sessions.semesters.destroy');

    // Programs
    Route::resource('programs', Academic\ProgramController::class)->except(['show']);

    // Courses + Subjects
    Route::resource('courses', Academic\CourseController::class);
    Route::post('/courses/{course}/subjects', [Academic\CourseController::class, 'storeSubject'])->name('courses.subjects.store');
    Route::delete('/courses/{course}/subjects/{subject}', [Academic\CourseController::class, 'destroySubject'])->name('courses.subjects.destroy');

    // Batches + Sections
    Route::resource('batches', Academic\BatchController::class)->except(['show']);
    Route::post('/batches/{batch}/sections', [Academic\BatchController::class, 'storeSection'])->name('batches.sections.store');
    Route::delete('/batches/{batch}/sections/{section}', [Academic\BatchController::class, 'destroySection'])->name('batches.sections.destroy');

    // ─── PHASE 4 — ADMISSION & STUDENTS ─────────────────────────────────

    // Admission Applications
    Route::resource('admissions', Admission\AdmissionController::class)->except(['edit', 'update']);
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
    Route::resource('grading', Examination\GradingController::class)->except(['show']);
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

    // Library
    Route::get('/library', [Library\LibraryController::class, 'booksIndex'])->name('library.index');
    Route::post('/library/books', [Library\LibraryController::class, 'storeBook'])->name('library.books.store');
    Route::delete('/library/books/{book}', [Library\LibraryController::class, 'destroyBook'])->name('library.books.destroy');
    Route::post('/library/categories', [Library\LibraryController::class, 'storeCat'])->name('library.categories.store');
    Route::get('/library/members', [Library\LibraryController::class, 'membersIndex'])->name('library.members');
    Route::post('/library/members', [Library\LibraryController::class, 'storeMember'])->name('library.members.store');
    Route::get('/library/issue', [Library\LibraryController::class, 'issueIndex'])->name('library.issue');
    Route::post('/library/issue', [Library\LibraryController::class, 'issueBook'])->name('library.issue.store');
    Route::post('/library/return/{issue}', [Library\LibraryController::class, 'returnBook'])->name('library.return');
    Route::get('/library/overdue', [Library\LibraryController::class, 'overdueIndex'])->name('library.overdue');

    // Hostel
    Route::get('/hostel', [Facilities\HostelController::class, 'index'])->name('hostel.index');
    Route::post('/hostel', [Facilities\HostelController::class, 'store'])->name('hostel.store');
    Route::get('/hostel/{hostel}/rooms', [Facilities\HostelController::class, 'roomsIndex'])->name('hostel.rooms');
    Route::post('/hostel/{hostel}/rooms', [Facilities\HostelController::class, 'storeRoom'])->name('hostel.rooms.store');
    Route::get('/hostel/allocations', [Facilities\HostelController::class, 'allocationsIndex'])->name('hostel.allocations');
    Route::post('/hostel/allocations', [Facilities\HostelController::class, 'allocate'])->name('hostel.allocate');
    Route::patch('/hostel/allocations/{allocation}/vacate', [Facilities\HostelController::class, 'vacate'])->name('hostel.vacate');
    Route::post('/hostel/room-types', [Facilities\HostelController::class, 'storeRoomType'])->name('hostel.room-types.store');

    // Transport
    Route::get('/transport', [Facilities\TransportController::class, 'index'])->name('transport.index');
    Route::post('/transport/vehicles', [Facilities\TransportController::class, 'storeVehicle'])->name('transport.vehicles.store');
    Route::post('/transport/routes', [Facilities\TransportController::class, 'storeRoute'])->name('transport.routes.store');
    Route::post('/transport/routes/{route}/stops', [Facilities\TransportController::class, 'storeStop'])->name('transport.stops.store');
    Route::get('/transport/allocations', [Facilities\TransportController::class, 'allocationsIndex'])->name('transport.allocations');
    Route::post('/transport/allocations', [Facilities\TransportController::class, 'allocate'])->name('transport.allocate');
    Route::patch('/transport/allocations/{allocation}/remove', [Facilities\TransportController::class, 'deallocate'])->name('transport.deallocate');

    // Inventory
    Route::get('/inventory', [Inventory\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/items', [Inventory\InventoryController::class, 'storeItem'])->name('inventory.items.store');
    Route::post('/inventory/stock-in', [Inventory\InventoryController::class, 'stockIn'])->name('inventory.stock-in');
    Route::post('/inventory/issue', [Inventory\InventoryController::class, 'issueItem'])->name('inventory.issue');
    Route::get('/suppliers', [Inventory\InventoryController::class, 'suppliersIndex'])->name('suppliers.index');
    Route::post('/suppliers', [Inventory\InventoryController::class, 'storeSupplier'])->name('inventory.suppliers.store');
    Route::post('/inventory/categories', [Inventory\InventoryController::class, 'storeCat'])->name('inventory.categories.store');
    Route::post('/inventory/stores', [Inventory\InventoryController::class, 'storeStore'])->name('inventory.stores.store');

    // Study Materials
    Route::get('/study-materials', [Study\StudyController::class, 'index'])->name('study-materials.index');
    Route::post('/study-materials/contents', [Study\StudyController::class, 'storeContent'])->name('study-materials.contents.store');
    Route::delete('/study-materials/contents/{content}', [Study\StudyController::class, 'destroyContent'])->name('study-materials.contents.destroy');
    Route::post('/study-materials/assignments', [Study\StudyController::class, 'storeAssignment'])->name('study-materials.assignments.store');
    Route::delete('/study-materials/assignments/{assignment}', [Study\StudyController::class, 'destroyAssignment'])->name('study-materials.assignments.destroy');
    Route::post('/study-materials/types', [Study\StudyController::class, 'storeType'])->name('study-materials.types.store');

    // ─── PHASE 8 — COMMUNICATION & ADMIN ────────────────────────────────

    // Notices & Events
    Route::get('/notices', [Communication\NoticeController::class, 'noticesIndex'])->name('notices.index');
    Route::post('/notices', [Communication\NoticeController::class, 'storeNotice'])->name('notices.store');
    Route::delete('/notices/{notice}', [Communication\NoticeController::class, 'destroyNotice'])->name('notices.destroy');
    Route::post('/notices/categories', [Communication\NoticeController::class, 'storeCat'])->name('notices.categories.store');
    Route::get('/events', [Communication\NoticeController::class, 'eventsIndex'])->name('events.index');
    Route::post('/events', [Communication\NoticeController::class, 'storeEvent'])->name('events.store');
    Route::delete('/events/{event}', [Communication\NoticeController::class, 'destroyEvent'])->name('events.destroy');

    // Front Desk
    Route::get('/visitors', [FrontDesk\FrontDeskController::class, 'visitorsIndex'])->name('visitors.index');
    Route::post('/visitors', [FrontDesk\FrontDeskController::class, 'storeVisitor'])->name('visitors.store');
    Route::patch('/visitors/{visitor}/checkout', [FrontDesk\FrontDeskController::class, 'checkoutVisitor'])->name('visitors.checkout');
    Route::post('/visitors/purposes', [FrontDesk\FrontDeskController::class, 'storePurpose'])->name('visitors.purposes.store');
    Route::get('/enquiries', [FrontDesk\FrontDeskController::class, 'enquiriesIndex'])->name('enquiries.index');
    Route::post('/enquiries', [FrontDesk\FrontDeskController::class, 'storeEnquiry'])->name('enquiries.store');
    Route::patch('/enquiries/{enquiry}/status', [FrontDesk\FrontDeskController::class, 'updateEnquiryStatus'])->name('enquiries.status');
    Route::post('/enquiries/sources', [FrontDesk\FrontDeskController::class, 'storeSource'])->name('enquiries.sources.store');
    Route::get('/complaints', [FrontDesk\FrontDeskController::class, 'complaintsIndex'])->name('complaints.index');
    Route::post('/complaints', [FrontDesk\FrontDeskController::class, 'storeComplaint'])->name('complaints.store');
    Route::patch('/complaints/{complaint}/status', [FrontDesk\FrontDeskController::class, 'updateComplaintStatus'])->name('complaints.status');
    Route::post('/complaints/types', [FrontDesk\FrontDeskController::class, 'storeComplaintType'])->name('complaints.types.store');

    // Transcripts
    Route::get('/transcripts', [Transcripts\TranscriptController::class, 'index'])->name('transcripts.index');
    Route::post('/transcripts', [Transcripts\TranscriptController::class, 'generate'])->name('transcripts.generate');
    Route::get('/transcripts/{document}', [Transcripts\TranscriptController::class, 'show'])->name('transcripts.show');

    // Reports
    Route::get('/reports', [Reports\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/students', [Reports\ReportController::class, 'students'])->name('reports.students');
    Route::get('/reports/fees', [Reports\ReportController::class, 'fees'])->name('reports.fees');
    Route::get('/reports/salary', [Reports\ReportController::class, 'salary'])->name('reports.salary');
    Route::get('/reports/finance', [Reports\ReportController::class, 'finance'])->name('reports.finance');
    Route::get('/reports/library', [Reports\ReportController::class, 'library'])->name('reports.library');

    // Front Website CMS
    Route::get('/frontweb/sliders', [FrontWeb\FrontWebController::class, 'slidersIndex'])->name('frontweb.sliders.index');
    Route::post('/frontweb/sliders', [FrontWeb\FrontWebController::class, 'storeSlider'])->name('frontweb.sliders.store');
    Route::delete('/frontweb/sliders/{slider}', [FrontWeb\FrontWebController::class, 'destroySlider'])->name('frontweb.sliders.destroy');
    Route::get('/frontweb/news', [FrontWeb\FrontWebController::class, 'newsIndex'])->name('frontweb.news.index');
    Route::post('/frontweb/news', [FrontWeb\FrontWebController::class, 'storeNews'])->name('frontweb.news.store');
    Route::delete('/frontweb/news/{news}', [FrontWeb\FrontWebController::class, 'destroyNews'])->name('frontweb.news.destroy');
    Route::get('/frontweb/pages', [FrontWeb\FrontWebController::class, 'pagesIndex'])->name('frontweb.pages.index');

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
