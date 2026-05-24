<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Academic') — Timetable Module</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
        .badge { display:inline-flex; align-items:center; padding:2px 8px; border-radius:9999px; font-size:11px; font-weight:600; }
        .badge-green  { background:#dcfce7; color:#166534; }
        .badge-red    { background:#fee2e2; color:#991b1b; }
        .badge-yellow { background:#fef9c3; color:#854d0e; }
        .badge-blue   { background:#dbeafe; color:#1e40af; }
        .badge-gray   { background:#f3f4f6; color:#374151; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer; border:none; transition:background .15s; }
        .btn-primary { background:#4f46e5; color:#fff; }
        .btn-primary:hover { background:#4338ca; }
        .btn-secondary { background:#f3f4f6; color:#374151; border:1px solid #e5e7eb; }
        .btn-secondary:hover { background:#e5e7eb; }
        .btn-danger { background:#fee2e2; color:#991b1b; }
        .btn-danger:hover { background:#fecaca; }
        .btn-sm { padding:4px 10px; font-size:12px; }
        table { width:100%; border-collapse:collapse; }
        thead th { background:#1e1b4b; padding:12px 16px; text-align:left; font-size:14px; font-weight:800; color:#e0e7ff; letter-spacing:.05em; border-bottom:3px solid #4f46e5; white-space:nowrap; }
        tbody td { padding:11px 14px; font-size:13px; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
        tbody tr:hover { background:#fafafa; }
        .card { background:#fff; border-radius:10px; border:1px solid #e5e7eb; box-shadow:0 1px 3px rgba(0,0,0,.06); }
        .form-label { display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:4px; }
        .form-input { width:100%; padding:7px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; outline:none; }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 2px rgba(99,102,241,.15); }
        .form-select { width:100%; padding:7px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; }
        .modal { position:fixed; inset:0; z-index:50; display:flex; align-items:center; justify-content:center; }
        .modal-box { background:#fff; border-radius:12px; width:100%; max-width:520px; box-shadow:0 20px 60px rgba(0,0,0,.18); padding:28px; position:relative; z-index:51; }
        .modal-box-lg { max-width:680px; }
        .day-check label { display:flex; align-items:center; gap:6px; font-size:13px; cursor:pointer; }
        .nc { display:inline-flex;align-items:center;justify-content:center;min-width:20px;height:18px;padding:0 5px;border-radius:9px;font-size:10px;font-weight:700;background:rgba(99,102,241,.35);color:#c7d2fe;flex-shrink:0; }
    </style>
</head>
<body style="background:#f1f5f9; height:100vh; overflow:hidden;">

@php
$path = request()->getPathInfo();

$mergedNav = [

    // ── 🔴 ADMIN ──────────────────────────────────────────
    ['role_divider'=>true, 'label'=>'Admin', 'color'=>'#f87171', 'line'=>'rgba(248,113,113,.25)'],

    [
        'label'=>'Academic',     'icon'=>'🏛️',
        'sub' => [
            ['label'=>'Departments',      'url'=>'/academic/departments'],
            ['label'=>'Courses',          'url'=>'/academic/courses'],
            ['label'=>'Subjects',         'url'=>'/academic/subjects'],
            ['label'=>'Semesters',        'url'=>'/academic/semesters'],
            ['sep'=>true,'label'=>'Extended'],
            ['label'=>'Faculties',        'url'=>'/academic-ext/faculties'],
            ['label'=>'Programs',         'url'=>'/academic-ext/programs'],
            ['label'=>'Batches',          'url'=>'/academic-ext/batches'],
            ['label'=>'Sessions',         'url'=>'/academic-ext/sessions'],
            ['label'=>'Sections',         'url'=>'/academic-ext/sections'],
            ['label'=>'Class Rooms',      'url'=>'/academic-ext/class-rooms'],
            ['label'=>'Enroll Courses',   'url'=>'/academic-ext/enroll-courses'],
        ],
    ],
    [
        'label'=>'Timetable',    'icon'=>'🗓️',
        'sub' => [
            ['label'=>'Timetable',        'url'=>'/academic/timetable'],
            ['sep'=>true,'label'=>'Routines'],
            ['label'=>'Manage Classes',   'url'=>'/routines/manage-classes'],
            ['label'=>'Class Schedules',  'url'=>'/routines/class-schedules'],
            ['label'=>'Manage Exams',     'url'=>'/routines/manage-exams'],
            ['label'=>'Exam Schedules',   'url'=>'/routines/exam-schedules'],
            ['label'=>'Teacher Routines', 'url'=>'/routines/teacher-routines'],
            ['sep'=>true,'label'=>'Schedule Settings'],
            ['label'=>'Class Schedule',   'url'=>'/routines/class-schedule-setting'],
            ['label'=>'Exam Schedule',    'url'=>'/routines/exam-schedule-setting'],
        ],
    ],
    [
        'label'=>'Examinations', 'icon'=>'📝',
        'sub' => [
            ['label'=>'Exam Attendances',  'url'=>'/examinations/exam-attendances'],
            ['label'=>'Exam Mark Ledger',  'url'=>'/examinations/exam-mark-ledger'],
            ['label'=>'Exam Results',      'url'=>'/examinations/exam-results'],
            ['label'=>'Course Mark Ledger','url'=>'/examinations/course-mark-ledger'],
            ['label'=>'Course Results',    'url'=>'/examinations/course-results'],
            ['label'=>'Grading Systems',   'url'=>'/examinations/grading-systems'],
            ['label'=>'Exam Types',        'url'=>'/examinations/exam-types'],
            ['label'=>'Admit Cards',       'url'=>'/examinations/admit-cards'],
            ['sep'=>true,'label'=>'Settings'],
            ['label'=>'Admit Setting',     'url'=>'/examinations/admit-setting'],
            ['label'=>'Mark Distribution', 'url'=>'/examinations/mark-distribution'],
        ],
    ],
    [
        'label'=>'Students',     'icon'=>'👨‍🎓',
        'sub' => [
            ['sep'=>true,'label'=>'Admission'],
            ['label'=>'Applications',      'url'=>'/admission/applications'],
            ['label'=>'New Registration',  'url'=>'/admission/new-registration'],
            ['label'=>'Student List',      'url'=>'/admission/student-list'],
            ['label'=>'Transfer In',       'url'=>'/admission/transfer-in'],
            ['label'=>'Transfer Out',      'url'=>'/admission/transfer-out'],
            ['label'=>'Status Types',      'url'=>'/admission/status-types'],
            ['label'=>'ID Cards',          'url'=>'/admission/id-cards'],
            ['label'=>'ID Card Setting',   'url'=>'/admission/id-card-setting'],
            ['sep'=>true,'label'=>'Manage'],
            ['label'=>'Attendances',       'url'=>'/student/attendances'],
            ['label'=>'Subject Attendances','url'=>'/students/subject-attendances'],
            ['label'=>'Attendance Reports','url'=>'/students/attendance-reports'],
            ['label'=>'Manage Leave',      'url'=>'/students/manage-leave'],
            ['label'=>'Student Notes',     'url'=>'/students/student-notes'],
            ['label'=>'Alumni List',       'url'=>'/students/alumni-list'],
            ['sep'=>true,'label'=>'Enrollments'],
            ['label'=>'Single Enroll',     'url'=>'/students/single-enroll'],
            ['label'=>'Group Enrolls',     'url'=>'/students/group-enrolls'],
            ['label'=>'Course Add Drop',   'url'=>'/students/course-add-drop'],
            ['label'=>'Course Graduation', 'url'=>'/students/course-graduation'],
        ],
    ],
    [
        'label'=>'Study Materials','icon'=>'📖',
        'sub' => [
            ['label'=>'Assignments',       'url'=>'/study/assignments'],
            ['label'=>'Content List',      'url'=>'/study/content-list'],
            ['label'=>'Content Types',     'url'=>'/study/content-types'],
            ['label'=>'Downloads',         'url'=>'/study/downloads'],
        ],
    ],
    [
        'label'=>'Staff',        'icon'=>'👥',
        'sub' => [
            ['label'=>'Staff',              'url'=>'/academic/staff'],
            ['sep'=>true,'label'=>'HR'],
            ['label'=>'Staff List',         'url'=>'/staff/staff-list'],
            ['label'=>'Staff Notes',        'url'=>'/staff/staff-notes'],
            ['label'=>'Payrolls',           'url'=>'/staff/payrolls'],
            ['label'=>'Payroll Reports',    'url'=>'/staff/payroll-reports'],
            ['label'=>'Work Shift Types',   'url'=>'/staff/work-shift-types'],
            ['label'=>'Designations',       'url'=>'/staff/designations'],
            ['label'=>'Departments',        'url'=>'/staff/departments'],
            ['label'=>'Tax Settings',       'url'=>'/staff/tax-settings'],
            ['label'=>'Pay Slip Setting',   'url'=>'/staff/pay-slip-setting'],
            ['sep'=>true,'label'=>'Attendance'],
            ['label'=>'Daily Attendances',  'url'=>'/staff/daily-attendances'],
            ['label'=>'Daily Reports',      'url'=>'/staff/daily-reports'],
            ['label'=>'Hourly Attendances', 'url'=>'/staff/hourly-attendances'],
            ['label'=>'Hourly Reports',     'url'=>'/staff/hourly-reports'],
            ['sep'=>true,'label'=>'Leave'],
            ['label'=>'Apply Leave',        'url'=>'/staff/apply-leave'],
            ['label'=>'My Leaves',          'url'=>'/staff/my-leaves'],
            ['label'=>'Leave Types',        'url'=>'/staff/leave-types'],
            ['label'=>'Manage Leave',       'url'=>'/staff/manage-leave'],
        ],
    ],
    [
        'label'=>'Facilities',   'icon'=>'🏢',
        'sub' => [
            ['label'=>'Buildings',          'url'=>'/academic/buildings'],
            ['label'=>'Rooms',              'url'=>'/academic/rooms'],
            ['sep'=>true,'label'=>'Hostels'],
            ['label'=>'Hostel List',        'url'=>'/facilities/hostel-list'],
            ['label'=>'Hostel Rooms',       'url'=>'/facilities/hostel-rooms'],
            ['label'=>'Room Types',         'url'=>'/facilities/room-types'],
            ['label'=>'Hostel Students',    'url'=>'/facilities/hostel-students'],
            ['label'=>'Hostel Staff',       'url'=>'/facilities/hostel-staff'],
            ['sep'=>true,'label'=>'Transport'],
            ['label'=>'Vehicles',           'url'=>'/facilities/vehicles'],
            ['label'=>'Routes',             'url'=>'/facilities/routes'],
            ['label'=>'Transport Students', 'url'=>'/facilities/transport-students'],
            ['label'=>'Transport Staff',    'url'=>'/facilities/transport-staff'],
        ],
    ],
    [
        'label'=>'Finance',      'icon'=>'💳',
        'sub' => [
            ['sep'=>true,'label'=>'Fees'],
            ['label'=>'Fees Due',           'url'=>'/finance/fees-due'],
            ['label'=>'Quick Assign',       'url'=>'/finance/quick-assign'],
            ['label'=>'Quick Received',     'url'=>'/finance/quick-received'],
            ['label'=>'Fees Reports',       'url'=>'/finance/fees-reports'],
            ['label'=>'Assign Group Fees',  'url'=>'/finance/assign-group-fees'],
            ['label'=>'Assigned History',   'url'=>'/finance/assigned-history'],
            ['label'=>'Fees Types',         'url'=>'/finance/fees-types'],
            ['label'=>'Fees Discounts',     'url'=>'/finance/fees-discounts'],
            ['label'=>'Fees Fines',         'url'=>'/finance/fees-fines'],
            ['label'=>'Receipt Setting',    'url'=>'/finance/receipt-setting'],
            ['sep'=>true,'label'=>'Accounts'],
            ['label'=>'Income List',        'url'=>'/finance/income-list'],
            ['label'=>'Income Categories',  'url'=>'/finance/income-categories'],
            ['label'=>'Expense List',       'url'=>'/finance/expense-list'],
            ['label'=>'Expense Categories', 'url'=>'/finance/expense-categories'],
            ['label'=>'Outcome Overview',   'url'=>'/finance/outcome-overview'],
        ],
    ],
    [
        'label'=>'Library',      'icon'=>'📚',
        'sub' => [
            ['label'=>'Library',            'url'=>'/student/library'],
            ['label'=>'Issue Book',         'url'=>'/library-mgmt/issue-book'],
            ['label'=>'Issue & Return',     'url'=>'/library-mgmt/issue-return'],
            ['label'=>'Book List',          'url'=>'/library-mgmt/book-list'],
            ['label'=>'Book Requests',      'url'=>'/library-mgmt/book-requests'],
            ['label'=>'Book Categories',    'url'=>'/library-mgmt/book-categories'],
            ['label'=>'Book Return Due',    'url'=>'/library-mgmt/book-return-due'],
            ['sep'=>true,'label'=>'Members'],
            ['label'=>'Student Members',    'url'=>'/library-mgmt/student-members'],
            ['label'=>'Staff Members',      'url'=>'/library-mgmt/staff-members'],
            ['label'=>'Outsider Members',   'url'=>'/library-mgmt/outsider-members'],
            ['label'=>'Card Setting',       'url'=>'/library-mgmt/card-setting'],
        ],
    ],
    [
        'label'=>'Inventory',    'icon'=>'📦',
        'sub' => [
            ['label'=>'Issue Item',         'url'=>'/inventory/issue-item'],
            ['label'=>'Issue & Return',     'url'=>'/inventory/issue-return'],
            ['label'=>'Item Stocks',        'url'=>'/inventory/item-stocks'],
            ['label'=>'Item List',          'url'=>'/inventory/item-list'],
            ['label'=>'Stores',             'url'=>'/inventory/stores'],
            ['label'=>'Suppliers',          'url'=>'/inventory/suppliers'],
            ['label'=>'Categories',         'url'=>'/inventory/categories'],
        ],
    ],
    [
        'label'=>'Front Desk',   'icon'=>'🖥',
        'sub' => [
            ['label'=>'Visitor Logs',       'url'=>'/frontdesk/visitor-logs'],
            ['label'=>'Phone Logs',         'url'=>'/frontdesk/phone-logs'],
            ['label'=>'Enquiry List',       'url'=>'/frontdesk/enquiry-list'],
            ['label'=>'Complain List',      'url'=>'/frontdesk/complain-list'],
            ['label'=>'Postal Exchanges',   'url'=>'/frontdesk/postal-exchanges'],
            ['label'=>'Meeting Schedules',  'url'=>'/frontdesk/meeting-schedules'],
            ['sep'=>true,'label'=>'Settings'],
            ['label'=>'Visit Purposes',     'url'=>'/frontdesk/visit-purposes'],
            ['label'=>'Token Settings',     'url'=>'/frontdesk/token-settings'],
            ['label'=>'Enquiry Sources',    'url'=>'/frontdesk/enquiry-sources'],
            ['label'=>'Enquiry References', 'url'=>'/frontdesk/enquiry-references'],
            ['label'=>'Complain Types',     'url'=>'/frontdesk/complain-types'],
            ['label'=>'Complain Sources',   'url'=>'/frontdesk/complain-sources'],
            ['label'=>'Postal Types',       'url'=>'/frontdesk/postal-types'],
            ['label'=>'Meeting Types',      'url'=>'/frontdesk/meeting-types'],
        ],
    ],

    [
        'label'=>'Transcripts',  'icon'=>'🏅',
        'sub' => [
            ['label'=>'Semester Marksheets','url'=>'/transcripts/semester-marksheets'],
            ['label'=>'Total Marksheets',   'url'=>'/transcripts/total-marksheets'],
            ['label'=>'Marksheet Setting',  'url'=>'/transcripts/marksheet-setting'],
            ['label'=>'Certificates',       'url'=>'/transcripts/certificates'],
            ['label'=>'Certificate Templates','url'=>'/transcripts/certificate-templates'],
        ],
    ],
    [
        'label'=>'Reports',      'icon'=>'📊',
        'sub' => [
            ['label'=>'Student Progress',   'url'=>'/reports/student-progress'],
            ['label'=>'Course Students',    'url'=>'/reports/course-students'],
            ['label'=>'Student Attendance', 'url'=>'/reports/student-attendance'],
            ['label'=>'Subject Attendance', 'url'=>'/reports/subject-attendance'],
            ['label'=>'Collected Fees',     'url'=>'/reports/collected-fees'],
            ['label'=>'Student Fees',       'url'=>'/reports/student-fees'],
            ['label'=>'Salary Paid',        'url'=>'/reports/salary-paid'],
            ['label'=>'Staff Leaves',       'url'=>'/reports/staff-leaves'],
            ['label'=>'Total Income',       'url'=>'/reports/total-income'],
            ['label'=>'Total Expense',      'url'=>'/reports/total-expense'],
            ['label'=>'Library History',    'url'=>'/reports/library-history'],
            ['label'=>'Book Return Due',    'url'=>'/reports/book-return-due'],
            ['label'=>'Inventory History',  'url'=>'/reports/inventory-history'],
            ['label'=>'Hostel Members',     'url'=>'/reports/hostel-members'],
            ['label'=>'Transport Members',  'url'=>'/reports/transport-members'],
        ],
    ],
    [
        'label'=>'Communicate',  'icon'=>'📢',
        'sub' => [
            ['label'=>'Send Email',         'url'=>'/communicate/send-email'],
            ['label'=>'Send SMS',           'url'=>'/communicate/send-sms'],
            ['label'=>'Event List',         'url'=>'/communicate/event-list'],
            ['label'=>'Calendar',           'url'=>'/communicate/calendar'],
            ['label'=>'Notice List',        'url'=>'/communicate/notice-list'],
            ['label'=>'Notice Categories',  'url'=>'/communicate/notice-categories'],
        ],
    ],
    [
        'label'=>'Front Web',    'icon'=>'🌐',
        'sub' => [
            ['label'=>'Contact Setting',    'url'=>'/frontweb/contact-setting'],
            ['label'=>'Social Setting',     'url'=>'/frontweb/social-setting'],
            ['label'=>'Sliders',            'url'=>'/frontweb/sliders'],
            ['label'=>'About Us',           'url'=>'/frontweb/about-us'],
            ['label'=>'Features',           'url'=>'/frontweb/features'],
            ['label'=>'Courses',            'url'=>'/frontweb/courses'],
            ['label'=>'Event',              'url'=>'/frontweb/event'],
            ['label'=>'News',               'url'=>'/frontweb/news'],
            ['label'=>'Faqs',               'url'=>'/frontweb/faqs'],
            ['label'=>'Gallery',            'url'=>'/frontweb/gallery'],
            ['label'=>'Testimonials',       'url'=>'/frontweb/testimonials'],
            ['label'=>'Footer Pages',       'url'=>'/frontweb/footer-pages'],
            ['label'=>'Call To Action',     'url'=>'/frontweb/call-to-action'],
        ],
    ],
    [
        'label'=>'Settings',     'icon'=>'⚙️',
        'sub' => [
            ['label'=>'General',            'url'=>'/settings/general'],
            ['label'=>'States/Provinces',   'url'=>'/settings/states-provinces'],
            ['label'=>'Districts/Cities',   'url'=>'/settings/districts-cities'],
            ['label'=>'Languages',          'url'=>'/settings/languages'],
            ['label'=>'Mail Setting',       'url'=>'/settings/mail-setting'],
            ['label'=>'SMS Getaways',       'url'=>'/settings/sms-getaways'],
            ['label'=>'Payment Getaways',   'url'=>'/settings/payment-getaways'],
            ['label'=>'Online Application', 'url'=>'/settings/online-application'],
            ['label'=>'Roles & Permissions','url'=>'/settings/roles-permissions'],
            ['label'=>'Staffs Fields',      'url'=>'/settings/staffs-fields'],
            ['label'=>'Students Fields',    'url'=>'/settings/students-fields'],
            ['label'=>'Applications Fields','url'=>'/settings/applications-fields'],
            ['label'=>'Student Panel',      'url'=>'/settings/student-panel'],
        ],
    ],

    // ── 🟡 STAFF / TEACHER ──────────────────────────────
    ['role_divider'=>true, 'label'=>'Staff / Teacher', 'color'=>'#fbbf24', 'line'=>'rgba(251,191,36,.25)'],

    // ── 🟢 STUDENT ────────────────────────────────────
    ['role_divider'=>true, 'label'=>'Student', 'color'=>'#34d399', 'line'=>'rgba(52,211,153,.25)'],

    [
        'label'=>'Student Panel','icon'=>'🎓',
        'sub' => [
            ['label'=>'Dashboard',          'url'=>'/student/dashboard'],
            ['label'=>'Class Schedules',    'url'=>'/student/class-schedules'],
            ['label'=>'Exam Schedules',     'url'=>'/student/exam-schedules'],
            ['label'=>'Apply Leaves',       'url'=>'/student/apply-leaves'],
            ['label'=>'Notices',            'url'=>'/student/notices'],
            ['label'=>'Transcript',         'url'=>'/student/transcript'],
            ['label'=>'My Profile',         'url'=>'/student/my-profile'],
        ],
    ],
];


// count only non-sep leaves
$totalPages = 2;
foreach ($mergedNav as $g) {
    if (isset($g['role_divider'])) continue;
    foreach ($g['sub'] as $s) {
        if (!isset($s['sep'])) $totalPages++;
    }
}
@endphp

<div style="display:flex; height:100vh; overflow:hidden;">
    <aside style="width:260px; height:100vh; background:linear-gradient(180deg,#0f0c29 0%,#1e1b4b 40%,#1a1040 100%); color:#fff; display:flex; flex-direction:column; flex-shrink:0; box-shadow:3px 0 16px rgba(0,0,0,.35); overflow:hidden;">
        <div style="padding:18px 20px 14px; border-bottom:1px solid rgba(255,255,255,.1);">
            <div style="font-size:16px; font-weight:800; color:#fff; letter-spacing:.01em;">🎓 Academy</div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:3px;">
                <div style="font-size:10px; font-weight:600; letter-spacing:.08em; color:#a5b4fc; text-transform:uppercase;">Admin Dashboard</div>
                <span style="font-size:10px;font-weight:700;background:rgba(99,102,241,.4);color:#c7d2fe;padding:2px 7px;border-radius:9px;">{{ $totalPages }} pages</span>
            </div>
        </div>
        <nav style="flex:1; min-height:0; padding:8px 8px; overflow-y:auto; scrollbar-width:thin; scrollbar-color:rgba(255,255,255,.15) transparent;">

            {{-- Role: Admin --}}
            <div style="display:flex;align-items:center;gap:6px;padding:10px 10px 4px;">
                <span style="font-size:9px;font-weight:800;letter-spacing:.1em;color:#a5b4fc;text-transform:uppercase;">🔴 Admin Only</span>
                <div style="flex:1;height:1px;background:rgba(165,180,252,.2);"></div>
            </div>

            @php $ovActive = str_starts_with($path, '/academic/overview'); @endphp
            <a href="/academic/overview" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:14px;text-decoration:none;
                {{ $ovActive ? 'background:#4f46e5;color:#fff;font-weight:600;' : 'color:#c7d2fe;' }}"
               onmouseover="{{ $ovActive ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
               onmouseout="{{ $ovActive ? '' : "this.style.background=''" }}">
                <span>📊</span><span style="flex:1;">Overview</span>
            </a>
            @php $treeActive = str_starts_with($path, '/academic/tree'); @endphp
            <a href="/academic/tree" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:14px;text-decoration:none;margin-bottom:2px;
                {{ $treeActive ? 'background:#4f46e5;color:#fff;font-weight:600;' : 'color:#c7d2fe;' }}"
               onmouseover="{{ $treeActive ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
               onmouseout="{{ $treeActive ? '' : "this.style.background=''" }}">
                <span>🌳</span><span style="flex:1;">Nav Tree</span>
            </a>

            @foreach($mergedNav as $mi => $m)
                @if(isset($m['role_divider']))
                    <div style="display:flex;align-items:center;gap:6px;padding:12px 10px 4px;">
                        <span style="font-size:9px;font-weight:800;letter-spacing:.12em;color:{{ $m['color'] }};text-transform:uppercase;white-space:nowrap;">{{ $m['label'] }}</span>
                        <div style="flex:1;height:1px;background:{{ $m['line'] }};"></div>
                    </div>
                @else
                @php
                    $count = collect($m['sub'])->filter(fn($s) => !isset($s['sep']))->count();
                    $mActive = false;
                    foreach ($m['sub'] as $s) {
                        if (!isset($s['sep']) && $s['url'] !== '#' && str_starts_with($path, $s['url'])) {
                            $mActive = true; break;
                        }
                    }
                @endphp
                <div style="margin-bottom:1px;">
                    <button onclick="navToggle('nm{{ $mi }}','na{{ $mi }}')"
                        style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:14px;width:100%;border:none;cursor:pointer;
                            {{ $mActive ? 'background:rgba(79,70,229,.4);color:#fff;font-weight:600;' : 'background:none;color:#c7d2fe;' }}"
                        onmouseover="{{ $mActive ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
                        onmouseout="{{ $mActive ? '' : "this.style.background=''" }}">
                        <span>{{ $m['icon'] }}</span>
                        <span style="flex:1;text-align:left;">{{ $m['label'] }}</span>
                        <span class="nc">{{ $count }}</span>
                        <span id="na{{ $mi }}" style="font-size:9px;transition:transform .2s;margin-left:2px;{{ $mActive ? 'transform:rotate(90deg)' : '' }}">▶</span>
                    </button>
                    <div id="nm{{ $mi }}" style="{{ $mActive ? '' : 'display:none;' }}padding-left:10px;margin-top:1px;">
                        @foreach($m['sub'] as $s)
                            @if(isset($s['sep']))
                                <div style="display:flex;align-items:center;gap:6px;margin:8px 4px 4px;">
                                    <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(99,102,241,.5),transparent);"></div>
                                    <span style="font-size:10px;font-weight:700;letter-spacing:.1em;color:#818cf8;text-transform:uppercase;white-space:nowrap;">{{ $s['label'] }}</span>
                                    <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(99,102,241,.5));"></div>
                                </div>
                            @else
                                @php $sActive = $s['url'] !== '#' && str_starts_with($path, $s['url']); @endphp
                                <a href="{{ $s['url'] }}" style="display:block;padding:7px 10px;border-radius:5px;font-size:14px;text-decoration:none;
                                    {{ $sActive ? 'color:#a5b4fc;font-weight:600;background:rgba(99,102,241,.2);border-left:2px solid #6366f1;' : 'color:#94a3b8;border-left:2px solid transparent;' }}"
                                   onmouseover="{{ $sActive ? '' : "this.style.color='#e0e7ff';this.style.background='rgba(255,255,255,.07)'" }}"
                                   onmouseout="{{ $sActive ? '' : "this.style.color='#94a3b8';this.style.background=''" }}">
                                    {{ $s['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </nav>
        <div style="padding:12px 20px; border-top:1px solid rgba(255,255,255,.1); font-size:12px; color:#a5b4fc; display:flex; flex-direction:column; gap:6px;">
            <span>{{ Auth::user()->name ?? 'Guest' }}</span>
            <a href="/dashboard" style="color:#818cf8; text-decoration:none;">← Dashboard</a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" style="background:none; border:none; color:#f87171; font-size:12px; cursor:pointer; padding:0;">Logout</button>
            </form>
            <a href="/university" target="_blank" style="display:flex; align-items:center; gap:6px; margin-top:4px; padding:8px 10px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-radius:7px; text-decoration:none; font-size:12px; font-weight:700;">
                🌐 University Website
            </a>
        </div>
    </aside>

    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden;">
        <header style="background:#fff; border-bottom:1px solid #e5e7eb; padding:12px 24px; display:flex; align-items:center; justify-content:space-between;">
            <h1 style="font-size:16px; font-weight:700; color:#1e1b4b; margin:0;">@yield('heading')</h1>
            <div style="display:flex; align-items:center; gap:10px;">
                @yield('header-actions')
            </div>
        </header>
        <main style="flex:1; padding:24px; overflow-y:auto;">
            @yield('content')
        </main>
    </div>
</div>

<div id="modal-backdrop" onclick="closeModal()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:40;"></div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.getElementById('modal-backdrop').style.display = 'block';
}
function closeModal() {
    document.querySelectorAll('[data-modal]').forEach(m => m.style.display = 'none');
    document.getElementById('modal-backdrop').style.display = 'none';
}
function navToggle(treeId, arrowId) {
    const el = document.getElementById(treeId);
    const ar = document.getElementById(arrowId);
    const isOpen = el.style.display !== 'none';

    // close all other open menus
    document.querySelectorAll('[id^="nm"]').forEach(menu => {
        if (menu.id !== treeId && menu.style.display !== 'none') {
            menu.style.display = 'none';
            const idx = menu.id.replace('nm', '');
            const arrow = document.getElementById('na' + idx);
            if (arrow) arrow.style.transform = '';
        }
    });

    // toggle clicked menu
    el.style.display = isOpen ? 'none' : 'block';
    if (ar) ar.style.transform = isOpen ? '' : 'rotate(90deg)';
}
</script>
</body>
</html>
