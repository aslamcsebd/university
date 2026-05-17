<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Advanced Nav') — Timetable Module</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; margin:0; }

        /* Sidebar */
        #adv-sidebar {
            width: 260px; min-height: 100vh; background: #0f172a; color: #fff;
            display: flex; flex-direction: column; flex-shrink: 0;
            transition: width .25s ease;
            overflow: hidden;
        }
        #adv-sidebar.collapsed { width: 56px; }

        /* Logo bar */
        .adv-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 16px 14px; border-bottom: 1px solid rgba(255,255,255,.08);
            white-space: nowrap; overflow: hidden;
        }
        .adv-logo-icon { font-size: 20px; flex-shrink: 0; }
        .adv-logo-text { font-size: 14px; font-weight: 800; color: #fff; }
        .adv-logo-sub  { font-size: 10px; color: #94a3b8; letter-spacing: .06em; text-transform: uppercase; }

        /* Toggle button */
        #sidebar-toggle {
            position: absolute; top: 14px; left: 224px;
            width: 28px; height: 28px; border-radius: 50%;
            background: #4f46e5; border: none; color: #fff;
            cursor: pointer; font-size: 14px; display: flex;
            align-items: center; justify-content: center;
            transition: left .25s ease; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,.3);
        }
        #sidebar-toggle.collapsed-btn { left: 40px; }

        /* Nav scroll area */
        .adv-nav { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 8px 0; }
        .adv-nav::-webkit-scrollbar { width: 4px; }
        .adv-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        /* Top-level item (no children) */
        .adv-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; font-size: 13px; color: #cbd5e1;
            cursor: pointer; white-space: nowrap; overflow: hidden;
            text-decoration: none; transition: background .15s;
            border-radius: 0;
        }
        .adv-item:hover, .adv-item.active { background: rgba(99,102,241,.25); color: #fff; }
        .adv-item.active { border-left: 3px solid #6366f1; }
        .adv-item-icon { font-size: 15px; flex-shrink: 0; width: 20px; text-align: center; }
        .adv-item-label { flex: 1; }
        .adv-item-arrow {
            font-size: 10px; color: #64748b; transition: transform .2s;
            flex-shrink: 0;
        }
        .adv-item-arrow.open { transform: rotate(90deg); }

        /* Group */
        .adv-group { overflow: hidden; }
        .adv-group-header {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; font-size: 13px; color: #cbd5e1;
            cursor: pointer; white-space: nowrap; overflow: hidden;
            transition: background .15s; user-select: none;
        }
        .adv-group-header:hover { background: rgba(255,255,255,.06); color: #fff; }
        .adv-group-header.open { color: #fff; }

        /* Sub-menu */
        .adv-sub { display: none; background: rgba(0,0,0,.2); }
        .adv-sub.open { display: block; }
        .adv-sub .adv-item { padding-left: 44px; font-size: 12.5px; color: #94a3b8; }
        .adv-sub .adv-item:hover { color: #fff; background: rgba(99,102,241,.18); }

        /* Nested sub-sub */
        .adv-sub2 { display: none; background: rgba(0,0,0,.15); }
        .adv-sub2.open { display: block; }
        .adv-sub2 .adv-item { padding-left: 62px; font-size: 12px; color: #64748b; }
        .adv-sub2 .adv-item:hover { color: #e2e8f0; background: rgba(99,102,241,.12); }

        /* Section label */
        .adv-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: .1em;
            color: #475569; text-transform: uppercase;
            padding: 12px 14px 4px; white-space: nowrap; overflow: hidden;
        }

        /* Collapsed: hide labels */
        #adv-sidebar.collapsed .adv-item-label,
        #adv-sidebar.collapsed .adv-item-arrow,
        #adv-sidebar.collapsed .adv-logo-text,
        #adv-sidebar.collapsed .adv-logo-sub,
        #adv-sidebar.collapsed .adv-section-label,
        #adv-sidebar.collapsed .adv-group-header span:not(.adv-item-icon) { display: none; }
        #adv-sidebar.collapsed .adv-sub,
        #adv-sidebar.collapsed .adv-sub2 { display: none !important; }
        #adv-sidebar.collapsed .adv-item,
        #adv-sidebar.collapsed .adv-group-header { justify-content: center; padding: 10px 0; }

        /* Footer */
        .adv-footer {
            padding: 12px 14px; border-top: 1px solid rgba(255,255,255,.08);
            font-size: 11px; color: #64748b; white-space: nowrap; overflow: hidden;
        }
        .adv-footer a { color: #818cf8; text-decoration: none; display: block; margin-top: 4px; }
        .adv-footer button {
            background: none; border: none; color: #f87171;
            font-size: 11px; cursor: pointer; padding: 0; margin-top: 4px; display: block;
        }

        /* Main content */
        #adv-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        #adv-topbar {
            background: #fff; border-bottom: 1px solid #e5e7eb;
            padding: 12px 24px; display: flex; align-items: center;
            justify-content: space-between;
        }
        #adv-topbar h1 { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; }
        #adv-content { flex: 1; padding: 24px; overflow-y: auto; background: #f1f5f9; }
    </style>
</head>
<body style="display:flex; min-height:100vh; position:relative;">

{{-- Toggle button (outside sidebar so it stays visible) --}}
<button id="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">&#9776;</button>

{{-- Sidebar --}}
<aside id="adv-sidebar">
    <div class="adv-logo">
        <span class="adv-logo-icon">🎓</span>
        <div>
            <div class="adv-logo-text">Academy</div>
            <div class="adv-logo-sub">Admin Panel</div>
        </div>
    </div>

    <nav class="adv-nav" id="adv-nav">

        {{-- Dashboard --}}
        <a href="/dashboard" class="adv-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="adv-item-icon">🏠</span>
            <span class="adv-item-label">Dashboard</span>
        </a>

        @php
        $menu = [
            ['label'=>'Admission','icon'=>'📋','children'=>[
                ['label'=>'Applications',    'url'=>'/admission/applications'],
                ['label'=>'New Registration','url'=>'/admission/new-registration'],
                ['label'=>'Student List',    'url'=>'/admission/student-list'],
                ['label'=>'Transfers','children'=>[
                    ['label'=>'Transfer In', 'url'=>'/admission/transfer-in'],
                    ['label'=>'Transfer Out','url'=>'/admission/transfer-out'],
                ]],
                ['label'=>'Status Types',   'url'=>'/admission/status-types'],
                ['label'=>'ID Cards',        'url'=>'/admission/id-cards'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'ID Card Setting','url'=>'/admission/id-card-setting'],
                ]],
            ]],
            ['label'=>'Students','icon'=>'🧑🎓','children'=>[
                ['label'=>'Attendances','children'=>[
                    ['label'=>'Subject Attendances','url'=>'/students/subject-attendances'],
                    ['label'=>'Attendance Reports', 'url'=>'/students/attendance-reports'],
                ]],
                ['label'=>'Manage Leave', 'url'=>'/students/manage-leave'],
                ['label'=>'Student Notes','url'=>'/students/student-notes'],
                ['label'=>'Enrollments','children'=>[
                    ['label'=>'Single Enroll',    'url'=>'/students/single-enroll'],
                    ['label'=>'Group Enrolls',    'url'=>'/students/group-enrolls'],
                    ['label'=>'Course Add Drop',  'url'=>'/students/course-add-drop'],
                    ['label'=>'Course Graduation','url'=>'/students/course-graduation'],
                ]],
                ['label'=>'Alumni List','url'=>'/students/alumni-list'],
            ]],
            ['label'=>'Academic','icon'=>'🏛️','children'=>[
                ['label'=>'Faculties',    'url'=>'/academic-ext/faculties'],
                ['label'=>'Programs',     'url'=>'/academic-ext/programs'],
                ['label'=>'Batches',      'url'=>'/academic-ext/batches'],
                ['label'=>'Sessions',     'url'=>'/academic-ext/sessions'],
                ['label'=>'Semesters',    'url'=>'/academic/semesters'],
                ['label'=>'Sections',     'url'=>'/academic-ext/sections'],
                ['label'=>'Class Rooms',  'url'=>'/academic-ext/class-rooms'],
                ['label'=>'Courses',      'url'=>'/academic/courses'],
                ['label'=>'Enroll Courses','url'=>'/academic-ext/enroll-courses'],
            ]],
            ['label'=>'Routines','icon'=>'📆','children'=>[
                ['label'=>'Manage Classes',  'url'=>'/routines/manage-classes'],
                ['label'=>'Class Schedules', 'url'=>'/routines/class-schedules'],
                ['label'=>'Manage Exams',    'url'=>'/routines/manage-exams'],
                ['label'=>'Exam Schedules',  'url'=>'/routines/exam-schedules'],
                ['label'=>'Teacher Routines','url'=>'/routines/teacher-routines'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Class Schedule','url'=>'/routines/class-schedule-setting'],
                    ['label'=>'Exam Schedule', 'url'=>'/routines/exam-schedule-setting'],
                ]],
            ]],
            ['label'=>'Examinations','icon'=>'📝','children'=>[
                ['label'=>'Exam Attendances', 'url'=>'/examinations/exam-attendances'],
                ['label'=>'Exam Mark Ledger', 'url'=>'/examinations/exam-mark-ledger'],
                ['label'=>'Exam Results',     'url'=>'/examinations/exam-results'],
                ['label'=>'Course Mark Ledger','url'=>'/examinations/course-mark-ledger'],
                ['label'=>'Course Results',   'url'=>'/examinations/course-results'],
                ['label'=>'Grading Systems',  'url'=>'/examinations/grading-systems'],
                ['label'=>'Exam Types',       'url'=>'/examinations/exam-types'],
                ['label'=>'Admit Cards',      'url'=>'/examinations/admit-cards'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Admit Setting',    'url'=>'/examinations/admit-setting'],
                    ['label'=>'Mark Distribution','url'=>'/examinations/mark-distribution'],
                ]],
            ]],
            ['label'=>'Study Materials','icon'=>'📚','children'=>[
                ['label'=>'Assignments',  'url'=>'/study/assignments'],
                ['label'=>'Content List', 'url'=>'/study/content-list'],
                ['label'=>'Content Types','url'=>'/study/content-types'],
            ]],
            ['label'=>'Fees Collection','icon'=>'💳','children'=>[
                ['label'=>'Student Fees','children'=>[
                    ['label'=>'Fees Due',      'url'=>'/finance/fees-due'],
                    ['label'=>'Quick Assign',  'url'=>'/finance/quick-assign'],
                    ['label'=>'Quick Received','url'=>'/finance/quick-received'],
                    ['label'=>'Fees Reports',  'url'=>'/finance/fees-reports'],
                ]],
                ['label'=>'Assign Group Fees','url'=>'/finance/assign-group-fees'],
                ['label'=>'Assigned History', 'url'=>'/finance/assigned-history'],
                ['label'=>'Fees Types',       'url'=>'/finance/fees-types'],
                ['label'=>'Fees Discounts',   'url'=>'/finance/fees-discounts'],
                ['label'=>'Fees Fines',       'url'=>'/finance/fees-fines'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Receipt Setting','url'=>'/finance/receipt-setting'],
                ]],
            ]],
            ['label'=>'Human Resources','icon'=>'👥','children'=>[
                ['label'=>'Staff List',      'url'=>'/staff/staff-list'],
                ['label'=>'Staff Notes',     'url'=>'/staff/staff-notes'],
                ['label'=>'Payrolls',        'url'=>'/staff/payrolls'],
                ['label'=>'Payroll Reports', 'url'=>'/staff/payroll-reports'],
                ['label'=>'Work Shift Types','url'=>'/staff/work-shift-types'],
                ['label'=>'Designations',    'url'=>'/staff/designations'],
                ['label'=>'Departments',     'url'=>'/staff/departments'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Tax Settings',    'url'=>'/staff/tax-settings'],
                    ['label'=>'Pay Slip Setting','url'=>'/staff/pay-slip-setting'],
                ]],
            ]],
            ['label'=>'Staff Attendances','icon'=>'✅','children'=>[
                ['label'=>'Daily Attendances', 'url'=>'/staff/daily-attendances'],
                ['label'=>'Daily Reports',     'url'=>'/staff/daily-reports'],
                ['label'=>'Hourly Attendances','url'=>'/staff/hourly-attendances'],
                ['label'=>'Hourly Reports',    'url'=>'/staff/hourly-reports'],
            ]],
            ['label'=>'Leave Manager','icon'=>'🏖️','children'=>[
                ['label'=>'Apply Leave','url'=>'/staff/apply-leave'],
                ['label'=>'My Leaves',  'url'=>'/staff/my-leaves'],
                ['label'=>'Leave Types','url'=>'/staff/leave-types'],
                ['label'=>'Manage Leave','url'=>'/staff/manage-leave'],
            ]],
            ['label'=>'Accounts','icon'=>'💰','children'=>[
                ['label'=>'Income List',       'url'=>'/finance/income-list'],
                ['label'=>'Income Categories', 'url'=>'/finance/income-categories'],
                ['label'=>'Expense List',      'url'=>'/finance/expense-list'],
                ['label'=>'Expense Categories','url'=>'/finance/expense-categories'],
                ['label'=>'Outcome Overview',  'url'=>'/finance/outcome-overview'],
            ]],
            ['label'=>'Communicates','icon'=>'📢','children'=>[
                ['label'=>'Send Email',       'url'=>'/communicate/send-email'],
                ['label'=>'Send SMS',         'url'=>'/communicate/send-sms'],
                ['label'=>'Event List',       'url'=>'/communicate/event-list'],
                ['label'=>'Calendar',         'url'=>'/communicate/calendar'],
                ['label'=>'Notice List',      'url'=>'/communicate/notice-list'],
                ['label'=>'Notice Categories','url'=>'/communicate/notice-categories'],
            ]],
            ['label'=>'Library','icon'=>'📖','children'=>[
                ['label'=>'Issue Book',   'url'=>'/library-mgmt/issue-book'],
                ['label'=>'Issue & Return','url'=>'/library-mgmt/issue-return'],
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List', 'url'=>'/library-mgmt/student-members'],
                    ['label'=>'Staff List',   'url'=>'/library-mgmt/staff-members'],
                    ['label'=>'Outsider List','url'=>'/library-mgmt/outsider-members'],
                ]],
                ['label'=>'Book List',      'url'=>'/library-mgmt/book-list'],
                ['label'=>'Book Requests',  'url'=>'/library-mgmt/book-requests'],
                ['label'=>'Book Categories','url'=>'/library-mgmt/book-categories'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Card Setting','url'=>'/library-mgmt/card-setting'],
                ]],
            ]],
            ['label'=>'Inventory','icon'=>'📦','children'=>[
                ['label'=>'Issue Item',   'url'=>'/inventory/issue-item'],
                ['label'=>'Issue & Return','url'=>'/inventory/issue-return'],
                ['label'=>'Item Stocks',  'url'=>'/inventory/item-stocks'],
                ['label'=>'Item List',    'url'=>'/inventory/item-list'],
                ['label'=>'Stores',       'url'=>'/inventory/stores'],
                ['label'=>'Suppliers',    'url'=>'/inventory/suppliers'],
                ['label'=>'Categories',   'url'=>'/inventory/categories'],
            ]],
            ['label'=>'Hostels','icon'=>'🏠','children'=>[
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List','url'=>'/facilities/hostel-students'],
                    ['label'=>'Staff List',  'url'=>'/facilities/hostel-staff'],
                ]],
                ['label'=>'Hostel Rooms','url'=>'/facilities/hostel-rooms'],
                ['label'=>'Hostel List', 'url'=>'/facilities/hostel-list'],
                ['label'=>'Room Types',  'url'=>'/facilities/room-types'],
            ]],
            ['label'=>'Transports','icon'=>'🚌','children'=>[
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List','url'=>'/facilities/transport-students'],
                    ['label'=>'Staff List',  'url'=>'/facilities/transport-staff'],
                ]],
                ['label'=>'Vehicles','url'=>'/facilities/vehicles'],
                ['label'=>'Routes',  'url'=>'/facilities/routes'],
            ]],
            ['label'=>'Front Desk','icon'=>'🖥️','children'=>[
                ['label'=>'Visitor Logs',     'url'=>'/frontdesk/visitor-logs'],
                ['label'=>'Phone Logs',       'url'=>'/frontdesk/phone-logs'],
                ['label'=>'Enquiry List',     'url'=>'/frontdesk/enquiry-list'],
                ['label'=>'Complain List',    'url'=>'/frontdesk/complain-list'],
                ['label'=>'Postal Exchanges', 'url'=>'/frontdesk/postal-exchanges'],
                ['label'=>'Meeting Schedules','url'=>'/frontdesk/meeting-schedules'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Visit Purposes',    'url'=>'/frontdesk/visit-purposes'],
                    ['label'=>'Token Settings',    'url'=>'/frontdesk/token-settings'],
                    ['label'=>'Enquiry Sources',   'url'=>'/frontdesk/enquiry-sources'],
                    ['label'=>'Enquiry References','url'=>'/frontdesk/enquiry-references'],
                    ['label'=>'Complain Types',    'url'=>'/frontdesk/complain-types'],
                    ['label'=>'Complain Sources',  'url'=>'/frontdesk/complain-sources'],
                    ['label'=>'Postal Types',      'url'=>'/frontdesk/postal-types'],
                    ['label'=>'Meeting Types',     'url'=>'/frontdesk/meeting-types'],
                ]],
            ]],
            ['label'=>'Transcripts','icon'=>'🎖️','children'=>[
                ['label'=>'Semester Marksheets',  'url'=>'/transcripts/semester-marksheets'],
                ['label'=>'Total Marksheets',     'url'=>'/transcripts/total-marksheets'],
                ['label'=>'Marksheet Setting',    'url'=>'/transcripts/marksheet-setting'],
                ['label'=>'Certificates',         'url'=>'/transcripts/certificates'],
                ['label'=>'Certificate Templates','url'=>'/transcripts/certificate-templates'],
            ]],
            ['label'=>'Reports','icon'=>'📊','children'=>[
                ['label'=>'Student Progress',  'url'=>'/reports/student-progress'],
                ['label'=>'Course Students',   'url'=>'/reports/course-students'],
                ['label'=>'Student Attendance','url'=>'/reports/student-attendance'],
                ['label'=>'Subject Attendance','url'=>'/reports/subject-attendance'],
                ['label'=>'Collected Fees',    'url'=>'/reports/collected-fees'],
                ['label'=>'Student Fees',      'url'=>'/reports/student-fees'],
                ['label'=>'Salary Paid',       'url'=>'/reports/salary-paid'],
                ['label'=>'Staff Leaves',      'url'=>'/reports/staff-leaves'],
                ['label'=>'Total Income',      'url'=>'/reports/total-income'],
                ['label'=>'Total Expense',     'url'=>'/reports/total-expense'],
                ['label'=>'Library History',   'url'=>'/reports/library-history'],
                ['label'=>'Book Return Due',   'url'=>'/reports/book-return-due'],
                ['label'=>'Inventory History', 'url'=>'/reports/inventory-history'],
                ['label'=>'Hostel Members',    'url'=>'/reports/hostel-members'],
                ['label'=>'Transport Members', 'url'=>'/reports/transport-members'],
            ]],
            ['label'=>'Front Web','icon'=>'🌐','children'=>[
                ['label'=>'Contact Setting','url'=>'/frontweb/contact-setting'],
                ['label'=>'Social Setting', 'url'=>'/frontweb/social-setting'],
                ['label'=>'Sliders',        'url'=>'/frontweb/sliders'],
                ['label'=>'About Us',       'url'=>'/frontweb/about-us'],
                ['label'=>'Features',       'url'=>'/frontweb/features'],
                ['label'=>'Courses',        'url'=>'/frontweb/courses'],
                ['label'=>'Event',          'url'=>'/frontweb/event'],
                ['label'=>'News',           'url'=>'/frontweb/news'],
                ['label'=>'Faqs',           'url'=>'/frontweb/faqs'],
                ['label'=>'Gallery',        'url'=>'/frontweb/gallery'],
                ['label'=>'Testimonials',   'url'=>'/frontweb/testimonials'],
                ['label'=>'Footer Pages',   'url'=>'/frontweb/footer-pages'],
                ['label'=>'Call To Action', 'url'=>'/frontweb/call-to-action'],
            ]],
            ['label'=>'Settings','icon'=>'⚙️','children'=>[
                ['label'=>'General',              'url'=>'/settings/general'],
                ['label'=>'States/Provinces',     'url'=>'/settings/states-provinces'],
                ['label'=>'Districts/Cities',     'url'=>'/settings/districts-cities'],
                ['label'=>'Languages',            'url'=>'/settings/languages'],
                ['label'=>'Mail Setting',         'url'=>'/settings/mail-setting'],
                ['label'=>'SMS Getaways',         'url'=>'/settings/sms-getaways'],
                ['label'=>'Payment Getaways',     'url'=>'/settings/payment-getaways'],
                ['label'=>'Online Application',   'url'=>'/settings/online-application'],
                ['label'=>'Roles and Permissions','url'=>'/settings/roles-permissions'],
                ['label'=>'Field Settings','children'=>[
                    ['label'=>'Staffs',      'url'=>'/settings/staffs-fields'],
                    ['label'=>'Students',    'url'=>'/settings/students-fields'],
                    ['label'=>'Applications','url'=>'/settings/applications-fields'],
                ]],
                ['label'=>'Student Panel','url'=>'/settings/student-panel'],
            ]],
        ];
        @endphp

        @foreach($menu as $gi => $group)
            @if(isset($group['children']))
                <div class="adv-group" id="grp-{{ $gi }}">
                    <div class="adv-group-header" onclick="toggleGroup('sub-{{ $gi }}', this)">
                        <span class="adv-item-icon">{{ $group['icon'] ?? '•' }}</span>
                        <span class="adv-item-label" style="flex:1;">{{ $group['label'] }}</span>
                        <span class="adv-item-arrow" id="arr-sub-{{ $gi }}">▶</span>
                    </div>
                    <div class="adv-sub" id="sub-{{ $gi }}">
                        @foreach($group['children'] as $ci => $child)
                            @if(isset($child['children']))
                                <div class="adv-group">
                                    <div class="adv-group-header" style="padding-left:44px; font-size:12.5px; color:#94a3b8;"
                                         onclick="toggleGroup('sub2-{{ $gi }}-{{ $ci }}', this)">
                                        <span class="adv-item-label" style="flex:1;">{{ $child['label'] }}</span>
                                        <span class="adv-item-arrow" id="arr-sub2-{{ $gi }}-{{ $ci }}">▶</span>
                                    </div>
                                    <div class="adv-sub2" id="sub2-{{ $gi }}-{{ $ci }}">
                                        @foreach($child['children'] as $leaf)
                                            <a href="{{ $leaf['url'] ?? '#' }}" class="adv-item">
                                                <span class="adv-item-label">{{ $leaf['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $child['url'] ?? '#' }}" class="adv-item">
                                    <span class="adv-item-label">{{ $child['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $group['url'] ?? '#' }}" class="adv-item">
                    <span class="adv-item-icon">{{ $group['icon'] ?? '•' }}</span>
                    <span class="adv-item-label">{{ $group['label'] }}</span>
                </a>
            @endif
        @endforeach

        {{-- My Profile --}}
        <a href="/profile" class="adv-item" style="margin-top:4px;">
            <span class="adv-item-icon">👤</span>
            <span class="adv-item-label">My Profile</span>
        </a>

    </nav>

    <div class="adv-footer">
        <span>{{ Auth::user()->name ?? 'Guest' }}</span>
        <a href="/academic/overview">← Academic</a>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div id="adv-main">
    <div id="adv-topbar">
        <h1>@yield('heading', 'Advanced Navigation')</h1>
        <div style="display:flex;align-items:center;gap:10px;">@yield('header-actions')</div>
    </div>
    <div id="adv-content">
        @yield('content')
    </div>
</div>

<script>
function toggleGroup(id, header) {
    const sub = document.getElementById(id);
    const arrId = 'arr-' + id;
    const arr = document.getElementById(arrId);
    const isOpen = sub.classList.contains('open');
    sub.classList.toggle('open', !isOpen);
    if (arr) arr.classList.toggle('open', !isOpen);
    header.classList.toggle('open', !isOpen);
}

function toggleSidebar() {
    const sidebar = document.getElementById('adv-sidebar');
    const btn = document.getElementById('sidebar-toggle');
    sidebar.classList.toggle('collapsed');
    btn.classList.toggle('collapsed-btn');
}
</script>
</body>
</html>
