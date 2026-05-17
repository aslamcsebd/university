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

    // Student Panel (12 pages)
    Route::prefix('student')->group(function () {
        Route::get('/', fn() => redirect('/student/dashboard'));
        Route::get('/dashboard',       fn() => view('student.dashboard'))->name('student.dashboard');
        Route::get('/class-schedules', fn() => view('student.class-schedules'))->name('student.class-schedules');
        Route::get('/exam-schedules',  fn() => view('student.exam-schedules'))->name('student.exam-schedules');
        Route::get('/attendances',     fn() => view('student.attendances'))->name('student.attendances');
        Route::get('/apply-leaves',    fn() => view('student.apply-leaves'))->name('student.apply-leaves');
        Route::get('/fees-reports',    fn() => view('student.fees-reports'))->name('student.fees-reports');
        Route::get('/library',         fn() => view('student.library'))->name('student.library');
        Route::get('/notices',         fn() => view('student.notices'))->name('student.notices');
        Route::get('/assignments',     fn() => view('student.assignments'))->name('student.assignments');
        Route::get('/downloads',       fn() => view('student.downloads'))->name('student.downloads');
        Route::get('/transcript',      fn() => view('student.transcript'))->name('student.transcript');
        Route::get('/my-profile',      fn() => view('student.my-profile'))->name('student.my-profile');
    });

    // Academic Dashboard (10 pages)
    Route::prefix('academic')->group(function () {
        Route::get('/',            fn() => redirect('/academic/overview'));
        Route::get('/overview',    fn() => view('academic.overview'))->name('academic.overview');
        Route::get('/tree',        fn() => view('academic.tree'))->name('academic.tree');
        Route::get('/departments', fn() => view('academic.departments'))->name('academic.departments');
        Route::get('/courses',     fn() => view('academic.courses'))->name('academic.courses');
        Route::get('/subjects',    fn() => view('academic.subjects'))->name('academic.subjects');
        Route::get('/semesters',   fn() => view('academic.semesters'))->name('academic.semesters');
        Route::get('/buildings',   fn() => view('academic.buildings'))->name('academic.buildings');
        Route::get('/rooms',       fn() => view('academic.rooms'))->name('academic.rooms');
        Route::get('/staff',       fn() => view('academic.staff'))->name('academic.staff');
        Route::get('/timetable',   fn() => view('academic.timetable'))->name('academic.timetable');
    });

    // Admission (8)
    Route::prefix('admission')->group(function () {
        Route::get('/applications',    fn() => view('admission.applications'))->name('admission.applications');
        Route::get('/new-registration',fn() => view('admission.new-registration'))->name('admission.new-registration');
        Route::get('/student-list',    fn() => view('admission.student-list'))->name('admission.student-list');
        Route::get('/transfer-in',     fn() => view('admission.transfer-in'))->name('admission.transfer-in');
        Route::get('/transfer-out',    fn() => view('admission.transfer-out'))->name('admission.transfer-out');
        Route::get('/status-types',    fn() => view('admission.status-types'))->name('admission.status-types');
        Route::get('/id-cards',        fn() => view('admission.id-cards'))->name('admission.id-cards');
        Route::get('/id-card-setting', fn() => view('admission.id-card-setting'))->name('admission.id-card-setting');
    });

    // Students (9)
    Route::prefix('students')->group(function () {
        Route::get('/subject-attendances',  fn() => view('students.subject-attendances'))->name('students.subject-attendances');
        Route::get('/attendance-reports',   fn() => view('students.attendance-reports'))->name('students.attendance-reports');
        Route::get('/manage-leave',         fn() => view('students.manage-leave'))->name('students.manage-leave');
        Route::get('/student-notes',        fn() => view('students.student-notes'))->name('students.student-notes');
        Route::get('/single-enroll',        fn() => view('students.single-enroll'))->name('students.single-enroll');
        Route::get('/group-enrolls',        fn() => view('students.group-enrolls'))->name('students.group-enrolls');
        Route::get('/course-add-drop',      fn() => view('students.course-add-drop'))->name('students.course-add-drop');
        Route::get('/course-graduation',    fn() => view('students.course-graduation'))->name('students.course-graduation');
        Route::get('/alumni-list',          fn() => view('students.alumni-list'))->name('students.alumni-list');
    });

    // Academic Extended (9)
    Route::prefix('academic-ext')->group(function () {
        Route::get('/faculties',     fn() => view('academic-ext.faculties'))->name('academic-ext.faculties');
        Route::get('/programs',      fn() => view('academic-ext.programs'))->name('academic-ext.programs');
        Route::get('/batches',       fn() => view('academic-ext.batches'))->name('academic-ext.batches');
        Route::get('/sessions',      fn() => view('academic-ext.sessions'))->name('academic-ext.sessions');
        Route::get('/sections',      fn() => view('academic-ext.sections'))->name('academic-ext.sections');
        Route::get('/class-rooms',   fn() => view('academic-ext.class-rooms'))->name('academic-ext.class-rooms');
        Route::get('/enroll-courses',fn() => view('academic-ext.enroll-courses'))->name('academic-ext.enroll-courses');
    });

    // Routines (7)
    Route::prefix('routines')->group(function () {
        Route::get('/manage-classes',  fn() => view('routines.manage-classes'))->name('routines.manage-classes');
        Route::get('/class-schedules', fn() => view('routines.class-schedules'))->name('routines.class-schedules');
        Route::get('/manage-exams',    fn() => view('routines.manage-exams'))->name('routines.manage-exams');
        Route::get('/exam-schedules',  fn() => view('routines.exam-schedules'))->name('routines.exam-schedules');
        Route::get('/teacher-routines',fn() => view('routines.teacher-routines'))->name('routines.teacher-routines');
        Route::get('/class-schedule-setting', fn() => view('routines.class-schedule-setting'))->name('routines.class-schedule-setting');
        Route::get('/exam-schedule-setting',  fn() => view('routines.exam-schedule-setting'))->name('routines.exam-schedule-setting');
    });

    // Examinations (10)
    Route::prefix('examinations')->group(function () {
        Route::get('/exam-attendances',  fn() => view('examinations.exam-attendances'))->name('examinations.exam-attendances');
        Route::get('/exam-mark-ledger',  fn() => view('examinations.exam-mark-ledger'))->name('examinations.exam-mark-ledger');
        Route::get('/exam-results',      fn() => view('examinations.exam-results'))->name('examinations.exam-results');
        Route::get('/course-mark-ledger',fn() => view('examinations.course-mark-ledger'))->name('examinations.course-mark-ledger');
        Route::get('/course-results',    fn() => view('examinations.course-results'))->name('examinations.course-results');
        Route::get('/grading-systems',   fn() => view('examinations.grading-systems'))->name('examinations.grading-systems');
        Route::get('/exam-types',        fn() => view('examinations.exam-types'))->name('examinations.exam-types');
        Route::get('/admit-cards',       fn() => view('examinations.admit-cards'))->name('examinations.admit-cards');
        Route::get('/admit-setting',     fn() => view('examinations.admit-setting'))->name('examinations.admit-setting');
        Route::get('/mark-distribution', fn() => view('examinations.mark-distribution'))->name('examinations.mark-distribution');
    });

    // Study Materials (4)
    Route::prefix('study')->group(function () {
        Route::get('/assignments',   fn() => view('study.assignments'))->name('study.assignments');
        Route::get('/content-list',  fn() => view('study.content-list'))->name('study.content-list');
        Route::get('/content-types', fn() => view('study.content-types'))->name('study.content-types');
        Route::get('/downloads',     fn() => view('study.downloads'))->name('study.downloads');
    });

    // Staff / HR (18)
    Route::prefix('staff')->group(function () {
        Route::get('/staff-list',         fn() => view('staff.staff-list'))->name('staff.staff-list');
        Route::get('/staff-notes',        fn() => view('staff.staff-notes'))->name('staff.staff-notes');
        Route::get('/payrolls',           fn() => view('staff.payrolls'))->name('staff.payrolls');
        Route::get('/payroll-reports',    fn() => view('staff.payroll-reports'))->name('staff.payroll-reports');
        Route::get('/work-shift-types',   fn() => view('staff.work-shift-types'))->name('staff.work-shift-types');
        Route::get('/designations',       fn() => view('staff.designations'))->name('staff.designations');
        Route::get('/departments',        fn() => view('staff.departments'))->name('staff.departments');
        Route::get('/tax-settings',       fn() => view('staff.tax-settings'))->name('staff.tax-settings');
        Route::get('/pay-slip-setting',   fn() => view('staff.pay-slip-setting'))->name('staff.pay-slip-setting');
        Route::get('/daily-attendances',  fn() => view('staff.daily-attendances'))->name('staff.daily-attendances');
        Route::get('/daily-reports',      fn() => view('staff.daily-reports'))->name('staff.daily-reports');
        Route::get('/hourly-attendances', fn() => view('staff.hourly-attendances'))->name('staff.hourly-attendances');
        Route::get('/hourly-reports',     fn() => view('staff.hourly-reports'))->name('staff.hourly-reports');
        Route::get('/apply-leave',        fn() => view('staff.apply-leave'))->name('staff.apply-leave');
        Route::get('/my-leaves',          fn() => view('staff.my-leaves'))->name('staff.my-leaves');
        Route::get('/leave-types',        fn() => view('staff.leave-types'))->name('staff.leave-types');
        Route::get('/manage-leave',       fn() => view('staff.manage-leave'))->name('staff.manage-leave');
    });

    // Facilities (11)
    Route::prefix('facilities')->group(function () {
        Route::get('/hostel-list',        fn() => view('facilities.hostel-list'))->name('facilities.hostel-list');
        Route::get('/hostel-rooms',       fn() => view('facilities.hostel-rooms'))->name('facilities.hostel-rooms');
        Route::get('/room-types',         fn() => view('facilities.room-types'))->name('facilities.room-types');
        Route::get('/hostel-students',    fn() => view('facilities.hostel-students'))->name('facilities.hostel-students');
        Route::get('/hostel-staff',       fn() => view('facilities.hostel-staff'))->name('facilities.hostel-staff');
        Route::get('/vehicles',           fn() => view('facilities.vehicles'))->name('facilities.vehicles');
        Route::get('/routes',             fn() => view('facilities.routes'))->name('facilities.routes');
        Route::get('/transport-students', fn() => view('facilities.transport-students'))->name('facilities.transport-students');
        Route::get('/transport-staff',    fn() => view('facilities.transport-staff'))->name('facilities.transport-staff');
    });

    // Finance (15)
    Route::prefix('finance')->group(function () {
        Route::get('/fees-due',          fn() => view('finance.fees-due'))->name('finance.fees-due');
        Route::get('/quick-assign',      fn() => view('finance.quick-assign'))->name('finance.quick-assign');
        Route::get('/quick-received',    fn() => view('finance.quick-received'))->name('finance.quick-received');
        Route::get('/fees-reports',      fn() => view('finance.fees-reports'))->name('finance.fees-reports');
        Route::get('/assign-group-fees', fn() => view('finance.assign-group-fees'))->name('finance.assign-group-fees');
        Route::get('/assigned-history',  fn() => view('finance.assigned-history'))->name('finance.assigned-history');
        Route::get('/fees-types',        fn() => view('finance.fees-types'))->name('finance.fees-types');
        Route::get('/fees-discounts',    fn() => view('finance.fees-discounts'))->name('finance.fees-discounts');
        Route::get('/fees-fines',        fn() => view('finance.fees-fines'))->name('finance.fees-fines');
        Route::get('/receipt-setting',   fn() => view('finance.receipt-setting'))->name('finance.receipt-setting');
        Route::get('/income-list',       fn() => view('finance.income-list'))->name('finance.income-list');
        Route::get('/income-categories', fn() => view('finance.income-categories'))->name('finance.income-categories');
        Route::get('/expense-list',      fn() => view('finance.expense-list'))->name('finance.expense-list');
        Route::get('/expense-categories',fn() => view('finance.expense-categories'))->name('finance.expense-categories');
        Route::get('/outcome-overview',  fn() => view('finance.outcome-overview'))->name('finance.outcome-overview');
    });

    // Library (11)
    Route::prefix('library-mgmt')->group(function () {
        Route::get('/issue-book',       fn() => view('library-mgmt.issue-book'))->name('library-mgmt.issue-book');
        Route::get('/issue-return',     fn() => view('library-mgmt.issue-return'))->name('library-mgmt.issue-return');
        Route::get('/book-list',        fn() => view('library-mgmt.book-list'))->name('library-mgmt.book-list');
        Route::get('/book-requests',    fn() => view('library-mgmt.book-requests'))->name('library-mgmt.book-requests');
        Route::get('/book-categories',  fn() => view('library-mgmt.book-categories'))->name('library-mgmt.book-categories');
        Route::get('/book-return-due',  fn() => view('library-mgmt.book-return-due'))->name('library-mgmt.book-return-due');
        Route::get('/student-members',  fn() => view('library-mgmt.student-members'))->name('library-mgmt.student-members');
        Route::get('/staff-members',    fn() => view('library-mgmt.staff-members'))->name('library-mgmt.staff-members');
        Route::get('/outsider-members', fn() => view('library-mgmt.outsider-members'))->name('library-mgmt.outsider-members');
        Route::get('/card-setting',     fn() => view('library-mgmt.card-setting'))->name('library-mgmt.card-setting');
    });

    // Inventory (7)
    Route::prefix('inventory')->group(function () {
        Route::get('/issue-item',   fn() => view('inventory.issue-item'))->name('inventory.issue-item');
        Route::get('/issue-return', fn() => view('inventory.issue-return'))->name('inventory.issue-return');
        Route::get('/item-stocks',  fn() => view('inventory.item-stocks'))->name('inventory.item-stocks');
        Route::get('/item-list',    fn() => view('inventory.item-list'))->name('inventory.item-list');
        Route::get('/stores',       fn() => view('inventory.stores'))->name('inventory.stores');
        Route::get('/suppliers',    fn() => view('inventory.suppliers'))->name('inventory.suppliers');
        Route::get('/categories',   fn() => view('inventory.categories'))->name('inventory.categories');
    });

    // Front Desk (14)
    Route::prefix('frontdesk')->group(function () {
        Route::get('/visitor-logs',       fn() => view('frontdesk.visitor-logs'))->name('frontdesk.visitor-logs');
        Route::get('/phone-logs',         fn() => view('frontdesk.phone-logs'))->name('frontdesk.phone-logs');
        Route::get('/enquiry-list',       fn() => view('frontdesk.enquiry-list'))->name('frontdesk.enquiry-list');
        Route::get('/complain-list',      fn() => view('frontdesk.complain-list'))->name('frontdesk.complain-list');
        Route::get('/postal-exchanges',   fn() => view('frontdesk.postal-exchanges'))->name('frontdesk.postal-exchanges');
        Route::get('/meeting-schedules',  fn() => view('frontdesk.meeting-schedules'))->name('frontdesk.meeting-schedules');
        Route::get('/visit-purposes',     fn() => view('frontdesk.visit-purposes'))->name('frontdesk.visit-purposes');
        Route::get('/token-settings',     fn() => view('frontdesk.token-settings'))->name('frontdesk.token-settings');
        Route::get('/enquiry-sources',    fn() => view('frontdesk.enquiry-sources'))->name('frontdesk.enquiry-sources');
        Route::get('/enquiry-references', fn() => view('frontdesk.enquiry-references'))->name('frontdesk.enquiry-references');
        Route::get('/complain-types',     fn() => view('frontdesk.complain-types'))->name('frontdesk.complain-types');
        Route::get('/complain-sources',   fn() => view('frontdesk.complain-sources'))->name('frontdesk.complain-sources');
        Route::get('/postal-types',       fn() => view('frontdesk.postal-types'))->name('frontdesk.postal-types');
        Route::get('/meeting-types',      fn() => view('frontdesk.meeting-types'))->name('frontdesk.meeting-types');
    });

    // Transcripts (5)
    Route::prefix('transcripts')->group(function () {
        Route::get('/semester-marksheets',   fn() => view('transcripts.semester-marksheets'))->name('transcripts.semester-marksheets');
        Route::get('/total-marksheets',      fn() => view('transcripts.total-marksheets'))->name('transcripts.total-marksheets');
        Route::get('/marksheet-setting',     fn() => view('transcripts.marksheet-setting'))->name('transcripts.marksheet-setting');
        Route::get('/certificates',          fn() => view('transcripts.certificates'))->name('transcripts.certificates');
        Route::get('/certificate-templates', fn() => view('transcripts.certificate-templates'))->name('transcripts.certificate-templates');
    });

    // Reports (15)
    Route::prefix('reports')->group(function () {
        Route::get('/student-progress',   fn() => view('reports.student-progress'))->name('reports.student-progress');
        Route::get('/course-students',    fn() => view('reports.course-students'))->name('reports.course-students');
        Route::get('/student-attendance', fn() => view('reports.student-attendance'))->name('reports.student-attendance');
        Route::get('/subject-attendance', fn() => view('reports.subject-attendance'))->name('reports.subject-attendance');
        Route::get('/collected-fees',     fn() => view('reports.collected-fees'))->name('reports.collected-fees');
        Route::get('/student-fees',       fn() => view('reports.student-fees'))->name('reports.student-fees');
        Route::get('/salary-paid',        fn() => view('reports.salary-paid'))->name('reports.salary-paid');
        Route::get('/staff-leaves',       fn() => view('reports.staff-leaves'))->name('reports.staff-leaves');
        Route::get('/total-income',       fn() => view('reports.total-income'))->name('reports.total-income');
        Route::get('/total-expense',      fn() => view('reports.total-expense'))->name('reports.total-expense');
        Route::get('/library-history',    fn() => view('reports.library-history'))->name('reports.library-history');
        Route::get('/book-return-due',    fn() => view('reports.book-return-due'))->name('reports.book-return-due');
        Route::get('/inventory-history',  fn() => view('reports.inventory-history'))->name('reports.inventory-history');
        Route::get('/hostel-members',     fn() => view('reports.hostel-members'))->name('reports.hostel-members');
        Route::get('/transport-members',  fn() => view('reports.transport-members'))->name('reports.transport-members');
    });

    // Communicate (6)
    Route::prefix('communicate')->group(function () {
        Route::get('/send-email',        fn() => view('communicate.send-email'))->name('communicate.send-email');
        Route::get('/send-sms',          fn() => view('communicate.send-sms'))->name('communicate.send-sms');
        Route::get('/event-list',        fn() => view('communicate.event-list'))->name('communicate.event-list');
        Route::get('/calendar',          fn() => view('communicate.calendar'))->name('communicate.calendar');
        Route::get('/notice-list',       fn() => view('communicate.notice-list'))->name('communicate.notice-list');
        Route::get('/notice-categories', fn() => view('communicate.notice-categories'))->name('communicate.notice-categories');
    });

    // Front Web (13)
    Route::prefix('frontweb')->group(function () {
        Route::get('/contact-setting',  fn() => view('frontweb.contact-setting'))->name('frontweb.contact-setting');
        Route::get('/social-setting',   fn() => view('frontweb.social-setting'))->name('frontweb.social-setting');
        Route::get('/sliders',          fn() => view('frontweb.sliders'))->name('frontweb.sliders');
        Route::get('/about-us',         fn() => view('frontweb.about-us'))->name('frontweb.about-us');
        Route::get('/features',         fn() => view('frontweb.features'))->name('frontweb.features');
        Route::get('/courses',          fn() => view('frontweb.courses'))->name('frontweb.courses');
        Route::get('/event',            fn() => view('frontweb.event'))->name('frontweb.event');
        Route::get('/news',             fn() => view('frontweb.news'))->name('frontweb.news');
        Route::get('/faqs',             fn() => view('frontweb.faqs'))->name('frontweb.faqs');
        Route::get('/gallery',          fn() => view('frontweb.gallery'))->name('frontweb.gallery');
        Route::get('/testimonials',     fn() => view('frontweb.testimonials'))->name('frontweb.testimonials');
        Route::get('/footer-pages',     fn() => view('frontweb.footer-pages'))->name('frontweb.footer-pages');
        Route::get('/call-to-action',   fn() => view('frontweb.call-to-action'))->name('frontweb.call-to-action');
    });

    // Settings (13)
    Route::prefix('settings')->group(function () {
        Route::get('/general',             fn() => view('settings.general'))->name('settings.general');
        Route::get('/states-provinces',    fn() => view('settings.states-provinces'))->name('settings.states-provinces');
        Route::get('/districts-cities',    fn() => view('settings.districts-cities'))->name('settings.districts-cities');
        Route::get('/languages',           fn() => view('settings.languages'))->name('settings.languages');
        Route::get('/mail-setting',        fn() => view('settings.mail-setting'))->name('settings.mail-setting');
        Route::get('/sms-getaways',        fn() => view('settings.sms-getaways'))->name('settings.sms-getaways');
        Route::get('/payment-getaways',    fn() => view('settings.payment-getaways'))->name('settings.payment-getaways');
        Route::get('/online-application',  fn() => view('settings.online-application'))->name('settings.online-application');
        Route::get('/roles-permissions',   fn() => view('settings.roles-permissions'))->name('settings.roles-permissions');
        Route::get('/staffs-fields',       fn() => view('settings.staffs-fields'))->name('settings.staffs-fields');
        Route::get('/students-fields',     fn() => view('settings.students-fields'))->name('settings.students-fields');
        Route::get('/applications-fields', fn() => view('settings.applications-fields'))->name('settings.applications-fields');
        Route::get('/student-panel',       fn() => view('settings.student-panel'))->name('settings.student-panel');
    });

    Route::get('/advanced-nav', fn() => view('advanced-nav'))->name('advanced-nav');
});

Route::get('/university', fn() => view('university'))->name('university');
Route::get('/apply', fn() => view('apply'))->name('apply');

require __DIR__.'/auth.php';
