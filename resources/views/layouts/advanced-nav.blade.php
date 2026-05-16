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
                ['label'=>'Applications'],
                ['label'=>'New Registration'],
                ['label'=>'Student List'],
                ['label'=>'Transfers','children'=>[
                    ['label'=>'Transfer In'],
                    ['label'=>'Transfer Out'],
                ]],
                ['label'=>'Status Types'],
                ['label'=>'ID Cards'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'ID Card Setting'],
                ]],
            ]],
            ['label'=>'Students','icon'=>'🧑‍🎓','children'=>[
                ['label'=>'Attendances','children'=>[
                    ['label'=>'Subject Attendances'],
                    ['label'=>'Attendance Reports'],
                ]],
                ['label'=>'Manage Leave'],
                ['label'=>'Student Notes'],
                ['label'=>'Enrollments','children'=>[
                    ['label'=>'Single Enroll'],
                    ['label'=>'Group Enrolls'],
                    ['label'=>'Course Add Drop'],
                    ['label'=>'Course Graduation'],
                ]],
                ['label'=>'Alumni List'],
            ]],
            ['label'=>'Academic','icon'=>'🏛️','children'=>[
                ['label'=>'Faculties'],['label'=>'Programs'],['label'=>'Batches'],
                ['label'=>'Sessions'],['label'=>'Semesters'],['label'=>'Sections'],
                ['label'=>'Class Rooms'],['label'=>'Courses'],['label'=>'Enroll Courses'],
            ]],
            ['label'=>'Routines','icon'=>'📆','children'=>[
                ['label'=>'Manage Classes'],['label'=>'Class Schedules'],
                ['label'=>'Manage Exams'],['label'=>'Exam Schedules'],
                ['label'=>'Teacher Routines'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Class Schedule'],['label'=>'Exam Schedule'],
                ]],
            ]],
            ['label'=>'Examinations','icon'=>'📝','children'=>[
                ['label'=>'Exam Attendances'],['label'=>'Exam Mark Ledger'],
                ['label'=>'Exam Results'],['label'=>'Course Mark Ledger'],
                ['label'=>'Course Results'],['label'=>'Grading Systems'],
                ['label'=>'Exam Types'],['label'=>'Admit Cards'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Admit Setting'],['label'=>'Mark Distribution'],
                ]],
            ]],
            ['label'=>'Study Materials','icon'=>'📚','children'=>[
                ['label'=>'Assignments'],['label'=>'Content List'],['label'=>'Content Types'],
            ]],
            ['label'=>'Fees Collection','icon'=>'💳','children'=>[
                ['label'=>'Student Fees','children'=>[
                    ['label'=>'Fees Due'],['label'=>'Quick Assign'],
                    ['label'=>'Quick Received'],['label'=>'Fees Reports'],
                ]],
                ['label'=>'Assign Group Fees'],['label'=>'Assigned History'],
                ['label'=>'Fees Types'],['label'=>'Fees Discounts'],['label'=>'Fees Fines'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Receipt Setting'],
                ]],
            ]],
            ['label'=>'Human Resources','icon'=>'👥','children'=>[
                ['label'=>'Staff List'],['label'=>'Staff Notes'],
                ['label'=>'Payrolls'],['label'=>'Payroll Reports'],
                ['label'=>'Work Shift Types'],['label'=>'Designations'],['label'=>'Departments'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Tax Settings'],['label'=>'Pay Slip Setting'],
                ]],
            ]],
            ['label'=>'Staff Attendances','icon'=>'✅','children'=>[
                ['label'=>'Daily Attendances'],['label'=>'Daily Reports'],
                ['label'=>'Hourly Attendances'],['label'=>'Hourly Reports'],
            ]],
            ['label'=>'Leave Manager','icon'=>'🏖️','children'=>[
                ['label'=>'Apply Leave'],['label'=>'My Leaves'],
                ['label'=>'Leave Types'],['label'=>'Manage Leave'],
            ]],
            ['label'=>'Accounts','icon'=>'💰','children'=>[
                ['label'=>'Income List'],['label'=>'Income Categories'],
                ['label'=>'Expense List'],['label'=>'Expense Categories'],['label'=>'Outcome Overview'],
            ]],
            ['label'=>'Communicates','icon'=>'📢','children'=>[
                ['label'=>'Send Email'],['label'=>'Send SMS'],['label'=>'Event List'],
                ['label'=>'Calendar'],['label'=>'Notice List'],['label'=>'Notice Categories'],
            ]],
            ['label'=>'Library','icon'=>'📖','children'=>[
                ['label'=>'Issue Book'],['label'=>'Issue & Return'],
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List'],['label'=>'Staff List'],['label'=>'Outsider List'],
                ]],
                ['label'=>'Book List'],['label'=>'Book Requests'],['label'=>'Book Categories'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Card Setting'],
                ]],
            ]],
            ['label'=>'Inventory','icon'=>'📦','children'=>[
                ['label'=>'Issue Item'],['label'=>'Issue & Return'],['label'=>'Item Stocks'],
                ['label'=>'Item List'],['label'=>'Stores'],['label'=>'Suppliers'],['label'=>'Categories'],
            ]],
            ['label'=>'Hostels','icon'=>'🏠','children'=>[
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List'],['label'=>'Staff List'],
                ]],
                ['label'=>'Hostel Rooms'],['label'=>'Hostel List'],['label'=>'Room Types'],
            ]],
            ['label'=>'Transports','icon'=>'🚌','children'=>[
                ['label'=>'Members','children'=>[
                    ['label'=>'Student List'],['label'=>'Staff List'],
                ]],
                ['label'=>'Vehicles'],['label'=>'Routes'],
            ]],
            ['label'=>'Front Desk','icon'=>'🖥️','children'=>[
                ['label'=>'Visitor Logs'],['label'=>'Phone Logs'],['label'=>'Enquiry List'],
                ['label'=>'Complain List'],['label'=>'Postal Exchanges'],['label'=>'Meeting Schedules'],
                ['label'=>'Settings','children'=>[
                    ['label'=>'Visit Purposes'],['label'=>'Token Settings'],
                    ['label'=>'Enquiry Sources'],['label'=>'Enquiry References'],
                    ['label'=>'Complain Types'],['label'=>'Complain Sources'],
                    ['label'=>'Postal Types'],['label'=>'Meeting Types'],
                ]],
            ]],
            ['label'=>'Transcripts','icon'=>'🎖️','children'=>[
                ['label'=>'Semester Marksheets'],['label'=>'Total Marksheets'],
                ['label'=>'Marksheet Setting'],['label'=>'Certificates'],['label'=>'Certificate Templates'],
            ]],
            ['label'=>'Reports','icon'=>'📊','children'=>[
                ['label'=>'Student Progress'],['label'=>'Course Students'],
                ['label'=>'Student Attendance'],['label'=>'Subject Attendance'],
                ['label'=>'Collected Fees'],['label'=>'Student Fees'],['label'=>'Salary Paid'],
                ['label'=>'Staff Leaves'],['label'=>'Total Income'],['label'=>'Total Expense'],
                ['label'=>'Library History'],['label'=>'Book Return Due'],
                ['label'=>'Inventory History'],['label'=>'Hostel Members'],['label'=>'Transport Members'],
            ]],
            ['label'=>'Front Web','icon'=>'🌐','children'=>[
                ['label'=>'Contact Setting'],['label'=>'Social Setting'],['label'=>'Sliders'],
                ['label'=>'About Us'],['label'=>'Features'],['label'=>'Courses'],
                ['label'=>'Event'],['label'=>'News'],['label'=>'Faqs'],
                ['label'=>'Gallery'],['label'=>'Testimonials'],['label'=>'Footer Pages'],['label'=>'Call To Action'],
            ]],
            ['label'=>'Settings','icon'=>'⚙️','children'=>[
                ['label'=>'General'],['label'=>'States/Provinces'],['label'=>'Districts/Cities'],
                ['label'=>'Languages'],['label'=>'Mail Setting'],['label'=>'SMS Getaways'],
                ['label'=>'Payment Getaways'],['label'=>'Online Application'],['label'=>'Roles and Permissions'],
                ['label'=>'Field Settings','children'=>[
                    ['label'=>'Staffs'],['label'=>'Students'],['label'=>'Applications'],
                ]],
                ['label'=>'Student Panel'],
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
                                            <a href="#" class="adv-item">
                                                <span class="adv-item-label">{{ $leaf['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="#" class="adv-item">
                                    <span class="adv-item-label">{{ $child['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <a href="#" class="adv-item">
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
