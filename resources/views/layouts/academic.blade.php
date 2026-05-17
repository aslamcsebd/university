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
<body style="background:#f1f5f9; min-height:100vh;">

@php
$path = request()->getPathInfo();

$mergedNav = [
    [
        'label'=>'Academic',     'icon'=>'🏛️',
        'sub' => [
            ['label'=>'Departments',      'url'=>'/academic/departments'],
            ['label'=>'Courses',          'url'=>'/academic/courses'],
            ['label'=>'Subjects',         'url'=>'/academic/subjects'],
            ['label'=>'Semesters',        'url'=>'/academic/semesters'],
            ['sep'=>true,'label'=>'Extended'],
            ['label'=>'Faculties',        'url'=>'#'],
            ['label'=>'Programs',         'url'=>'#'],
            ['label'=>'Batches',          'url'=>'#'],
            ['label'=>'Sessions',         'url'=>'#'],
            ['label'=>'Sections',         'url'=>'#'],
            ['label'=>'Class Rooms',      'url'=>'#'],
            ['label'=>'Enroll Courses',   'url'=>'#'],
        ],
    ],
    [
        'label'=>'Timetable',    'icon'=>'🗓️',
        'sub' => [
            ['label'=>'Timetable',        'url'=>'/academic/timetable'],
            ['sep'=>true,'label'=>'Routines'],
            ['label'=>'Manage Classes',   'url'=>'#'],
            ['label'=>'Class Schedules',  'url'=>'#'],
            ['label'=>'Manage Exams',     'url'=>'#'],
            ['label'=>'Exam Schedules',   'url'=>'#'],
            ['label'=>'Teacher Routines', 'url'=>'#'],
            ['sep'=>true,'label'=>'Schedule Settings'],
            ['label'=>'Class Schedule',   'url'=>'#'],
            ['label'=>'Exam Schedule',    'url'=>'#'],
        ],
    ],
    [
        'label'=>'Examinations', 'icon'=>'📝',
        'sub' => [
            ['label'=>'Exam Attendances',  'url'=>'#'],
            ['label'=>'Exam Mark Ledger',  'url'=>'#'],
            ['label'=>'Exam Results',      'url'=>'#'],
            ['label'=>'Course Mark Ledger','url'=>'#'],
            ['label'=>'Course Results',    'url'=>'#'],
            ['label'=>'Grading Systems',   'url'=>'#'],
            ['label'=>'Exam Types',        'url'=>'#'],
            ['label'=>'Admit Cards',       'url'=>'#'],
            ['sep'=>true,'label'=>'Settings'],
            ['label'=>'Admit Setting',     'url'=>'#'],
            ['label'=>'Mark Distribution', 'url'=>'#'],
        ],
    ],
    [
        'label'=>'Students',     'icon'=>'🧑🎓',
        'sub' => [
            ['sep'=>true,'label'=>'Admission'],
            ['label'=>'Applications',      'url'=>'#'],
            ['label'=>'New Registration',  'url'=>'#'],
            ['label'=>'Student List',      'url'=>'#'],
            ['label'=>'Transfer In',       'url'=>'#'],
            ['label'=>'Transfer Out',      'url'=>'#'],
            ['label'=>'Status Types',      'url'=>'#'],
            ['label'=>'ID Cards',          'url'=>'#'],
            ['label'=>'ID Card Setting',   'url'=>'#'],
            ['sep'=>true,'label'=>'Manage'],
            ['label'=>'Attendances',       'url'=>'/student/attendances'],
            ['label'=>'Subject Attendances','url'=>'#'],
            ['label'=>'Attendance Reports','url'=>'#'],
            ['label'=>'Manage Leave',      'url'=>'#'],
            ['label'=>'Student Notes',     'url'=>'#'],
            ['label'=>'Alumni List',       'url'=>'#'],
            ['sep'=>true,'label'=>'Enrollments'],
            ['label'=>'Single Enroll',     'url'=>'#'],
            ['label'=>'Group Enrolls',     'url'=>'#'],
            ['label'=>'Course Add Drop',   'url'=>'#'],
            ['label'=>'Course Graduation', 'url'=>'#'],
        ],
    ],
    [
        'label'=>'Study Materials','icon'=>'📖',
        'sub' => [
            ['label'=>'Assignments',       'url'=>'/student/assignments'],
            ['label'=>'Content List',      'url'=>'#'],
            ['label'=>'Content Types',     'url'=>'#'],
            ['label'=>'Downloads',         'url'=>'/student/downloads'],
        ],
    ],
    [
        'label'=>'Staff',        'icon'=>'👥',
        'sub' => [
            ['label'=>'Staff',              'url'=>'/academic/staff'],
            ['sep'=>true,'label'=>'HR'],
            ['label'=>'Staff List',         'url'=>'#'],
            ['label'=>'Staff Notes',        'url'=>'#'],
            ['label'=>'Payrolls',           'url'=>'#'],
            ['label'=>'Payroll Reports',    'url'=>'#'],
            ['label'=>'Work Shift Types',   'url'=>'#'],
            ['label'=>'Designations',       'url'=>'#'],
            ['label'=>'Departments',        'url'=>'#'],
            ['label'=>'Tax Settings',       'url'=>'#'],
            ['label'=>'Pay Slip Setting',   'url'=>'#'],
            ['sep'=>true,'label'=>'Attendance'],
            ['label'=>'Daily Attendances',  'url'=>'#'],
            ['label'=>'Daily Reports',      'url'=>'#'],
            ['label'=>'Hourly Attendances', 'url'=>'#'],
            ['label'=>'Hourly Reports',     'url'=>'#'],
            ['sep'=>true,'label'=>'Leave'],
            ['label'=>'Apply Leave',        'url'=>'#'],
            ['label'=>'My Leaves',          'url'=>'#'],
            ['label'=>'Leave Types',        'url'=>'#'],
            ['label'=>'Manage Leave',       'url'=>'#'],
        ],
    ],
    [
        'label'=>'Facilities',   'icon'=>'🏢',
        'sub' => [
            ['label'=>'Buildings',          'url'=>'/academic/buildings'],
            ['label'=>'Rooms',              'url'=>'/academic/rooms'],
            ['sep'=>true,'label'=>'Hostels'],
            ['label'=>'Hostel List',        'url'=>'#'],
            ['label'=>'Hostel Rooms',       'url'=>'#'],
            ['label'=>'Room Types',         'url'=>'#'],
            ['label'=>'Hostel Students',    'url'=>'#'],
            ['label'=>'Hostel Staff',       'url'=>'#'],
            ['sep'=>true,'label'=>'Transport'],
            ['label'=>'Vehicles',           'url'=>'#'],
            ['label'=>'Routes',             'url'=>'#'],
            ['label'=>'Transport Students', 'url'=>'#'],
            ['label'=>'Transport Staff',    'url'=>'#'],
        ],
    ],
    [
        'label'=>'Finance',      'icon'=>'💳',
        'sub' => [
            ['sep'=>true,'label'=>'Fees'],
            ['label'=>'Fees Due',           'url'=>'#'],
            ['label'=>'Quick Assign',       'url'=>'#'],
            ['label'=>'Quick Received',     'url'=>'#'],
            ['label'=>'Fees Reports',       'url'=>'/student/fees-reports'],
            ['label'=>'Assign Group Fees',  'url'=>'#'],
            ['label'=>'Assigned History',   'url'=>'#'],
            ['label'=>'Fees Types',         'url'=>'#'],
            ['label'=>'Fees Discounts',     'url'=>'#'],
            ['label'=>'Fees Fines',         'url'=>'#'],
            ['label'=>'Receipt Setting',    'url'=>'#'],
            ['sep'=>true,'label'=>'Accounts'],
            ['label'=>'Income List',        'url'=>'#'],
            ['label'=>'Income Categories',  'url'=>'#'],
            ['label'=>'Expense List',       'url'=>'#'],
            ['label'=>'Expense Categories', 'url'=>'#'],
            ['label'=>'Outcome Overview',   'url'=>'#'],
        ],
    ],
    [
        'label'=>'Library',      'icon'=>'📚',
        'sub' => [
            ['label'=>'Library',            'url'=>'/student/library'],
            ['label'=>'Issue Book',         'url'=>'#'],
            ['label'=>'Issue & Return',     'url'=>'#'],
            ['label'=>'Book List',          'url'=>'#'],
            ['label'=>'Book Requests',      'url'=>'#'],
            ['label'=>'Book Categories',    'url'=>'#'],
            ['label'=>'Book Return Due',    'url'=>'#'],
            ['sep'=>true,'label'=>'Members'],
            ['label'=>'Student Members',    'url'=>'#'],
            ['label'=>'Staff Members',      'url'=>'#'],
            ['label'=>'Outsider Members',   'url'=>'#'],
            ['label'=>'Card Setting',       'url'=>'#'],
        ],
    ],
    [
        'label'=>'Inventory',    'icon'=>'📦',
        'sub' => [
            ['label'=>'Issue Item',         'url'=>'#'],
            ['label'=>'Issue & Return',     'url'=>'#'],
            ['label'=>'Item Stocks',        'url'=>'#'],
            ['label'=>'Item List',          'url'=>'#'],
            ['label'=>'Stores',             'url'=>'#'],
            ['label'=>'Suppliers',          'url'=>'#'],
            ['label'=>'Categories',         'url'=>'#'],
        ],
    ],
    [
        'label'=>'Front Desk',   'icon'=>'🖥️',
        'sub' => [
            ['label'=>'Visitor Logs',       'url'=>'#'],
            ['label'=>'Phone Logs',         'url'=>'#'],
            ['label'=>'Enquiry List',       'url'=>'#'],
            ['label'=>'Complain List',      'url'=>'#'],
            ['label'=>'Postal Exchanges',   'url'=>'#'],
            ['label'=>'Meeting Schedules',  'url'=>'#'],
            ['sep'=>true,'label'=>'Settings'],
            ['label'=>'Visit Purposes',     'url'=>'#'],
            ['label'=>'Token Settings',     'url'=>'#'],
            ['label'=>'Enquiry Sources',    'url'=>'#'],
            ['label'=>'Enquiry References', 'url'=>'#'],
            ['label'=>'Complain Types',     'url'=>'#'],
            ['label'=>'Complain Sources',   'url'=>'#'],
            ['label'=>'Postal Types',       'url'=>'#'],
            ['label'=>'Meeting Types',      'url'=>'#'],
        ],
    ],
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
    [
        'label'=>'Transcripts',  'icon'=>'🎖️',
        'sub' => [
            ['label'=>'Semester Marksheets','url'=>'#'],
            ['label'=>'Total Marksheets',   'url'=>'#'],
            ['label'=>'Marksheet Setting',  'url'=>'#'],
            ['label'=>'Certificates',       'url'=>'#'],
            ['label'=>'Certificate Templates','url'=>'#'],
        ],
    ],
    [
        'label'=>'Reports',      'icon'=>'📊',
        'sub' => [
            ['label'=>'Student Progress',   'url'=>'#'],
            ['label'=>'Course Students',    'url'=>'#'],
            ['label'=>'Student Attendance', 'url'=>'#'],
            ['label'=>'Subject Attendance', 'url'=>'#'],
            ['label'=>'Collected Fees',     'url'=>'#'],
            ['label'=>'Student Fees',       'url'=>'#'],
            ['label'=>'Salary Paid',        'url'=>'#'],
            ['label'=>'Staff Leaves',       'url'=>'#'],
            ['label'=>'Total Income',       'url'=>'#'],
            ['label'=>'Total Expense',      'url'=>'#'],
            ['label'=>'Library History',    'url'=>'#'],
            ['label'=>'Book Return Due',    'url'=>'#'],
            ['label'=>'Inventory History',  'url'=>'#'],
            ['label'=>'Hostel Members',     'url'=>'#'],
            ['label'=>'Transport Members',  'url'=>'#'],
        ],
    ],
    [
        'label'=>'Communicate',  'icon'=>'📢',
        'sub' => [
            ['label'=>'Send Email',         'url'=>'#'],
            ['label'=>'Send SMS',           'url'=>'#'],
            ['label'=>'Event List',         'url'=>'#'],
            ['label'=>'Calendar',           'url'=>'#'],
            ['label'=>'Notice List',        'url'=>'#'],
            ['label'=>'Notice Categories',  'url'=>'#'],
        ],
    ],
    [
        'label'=>'Front Web',    'icon'=>'🌐',
        'sub' => [
            ['label'=>'Contact Setting',    'url'=>'#'],
            ['label'=>'Social Setting',     'url'=>'#'],
            ['label'=>'Sliders',            'url'=>'#'],
            ['label'=>'About Us',           'url'=>'#'],
            ['label'=>'Features',           'url'=>'#'],
            ['label'=>'Courses',            'url'=>'#'],
            ['label'=>'Event',              'url'=>'#'],
            ['label'=>'News',               'url'=>'#'],
            ['label'=>'Faqs',               'url'=>'#'],
            ['label'=>'Gallery',            'url'=>'#'],
            ['label'=>'Testimonials',       'url'=>'#'],
            ['label'=>'Footer Pages',       'url'=>'#'],
            ['label'=>'Call To Action',     'url'=>'#'],
        ],
    ],
    [
        'label'=>'Settings',     'icon'=>'⚙️',
        'sub' => [
            ['label'=>'General',            'url'=>'#'],
            ['label'=>'States/Provinces',   'url'=>'#'],
            ['label'=>'Districts/Cities',   'url'=>'#'],
            ['label'=>'Languages',          'url'=>'#'],
            ['label'=>'Mail Setting',       'url'=>'#'],
            ['label'=>'SMS Getaways',       'url'=>'#'],
            ['label'=>'Payment Getaways',   'url'=>'#'],
            ['label'=>'Online Application', 'url'=>'#'],
            ['label'=>'Roles & Permissions','url'=>'#'],
            ['label'=>'Staffs Fields',      'url'=>'#'],
            ['label'=>'Students Fields',    'url'=>'#'],
            ['label'=>'Applications Fields','url'=>'#'],
            ['label'=>'Student Panel',      'url'=>'#'],
        ],
    ],
];

// count only non-sep leaves
$totalPages = 2; // Overview + Nav Tree
foreach ($mergedNav as $g) {
    foreach ($g['sub'] as $s) {
        if (!isset($s['sep'])) $totalPages++;
    }
}
@endphp

<div style="display:flex; min-height:100vh;">
    <aside style="width:260px; background:#1e1b4b; color:#fff; display:flex; flex-direction:column; flex-shrink:0;">
        <div style="padding:18px 20px 14px; border-bottom:1px solid rgba(255,255,255,.1);">
            <div style="font-size:16px; font-weight:800; color:#fff; letter-spacing:.01em;">🎓 Academy</div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:3px;">
                <div style="font-size:10px; font-weight:600; letter-spacing:.08em; color:#a5b4fc; text-transform:uppercase;">Admin Dashboard</div>
                <span style="font-size:10px;font-weight:700;background:rgba(99,102,241,.4);color:#c7d2fe;padding:2px 7px;border-radius:9px;">{{ $totalPages }} pages</span>
            </div>
        </div>
        <nav style="flex:1; padding:8px 8px; overflow-y:auto;">
            <div style="font-size:10px;font-weight:700;letter-spacing:.1em;color:#6366f1;text-transform:uppercase;padding:6px 10px 4px;">Academic Dashboard</div>

            @php $ovActive = str_starts_with($path, '/academic/overview'); @endphp
            <a href="/academic/overview" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:14px;text-decoration:none;
                {{ $ovActive ? 'background:#4f46e5;color:#fff;font-weight:600;' : 'color:#c7d2fe;' }}"
               onmouseover="{{ $ovActive ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
               onmouseout="{{ $ovActive ? '' : "this.style.background=''" }}">
                <span>📊</span><span style="flex:1;">Overview</span>
            </a>
            @php $treeActive = str_starts_with($path, '/academic/tree'); @endphp
            <a href="/academic/tree" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:14px;text-decoration:none;margin-bottom:4px;
                {{ $treeActive ? 'background:#4f46e5;color:#fff;font-weight:600;' : 'color:#c7d2fe;' }}"
               onmouseover="{{ $treeActive ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
               onmouseout="{{ $treeActive ? '' : "this.style.background=''" }}">
                <span>🌳</span><span style="flex:1;">Nav Tree</span>
            </a>

            @foreach($mergedNav as $mi => $m)
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
                                <div style="font-size:9px;font-weight:700;letter-spacing:.08em;color:#475569;text-transform:uppercase;padding:6px 8px 2px;">{{ $s['label'] }}</div>
                            @else
                                @php $sActive = $s['url'] !== '#' && str_starts_with($path, $s['url']); @endphp
                                <a href="{{ $s['url'] }}" style="display:block;padding:6px 8px;border-radius:5px;font-size:13px;text-decoration:none;
                                    {{ $sActive ? 'color:#a5b4fc;font-weight:600;background:rgba(99,102,241,.15);' : 'color:#64748b;' }}"
                                   onmouseover="{{ $sActive ? '' : "this.style.color='#c7d2fe';this.style.background='rgba(255,255,255,.05)'" }}"
                                   onmouseout="{{ $sActive ? '' : "this.style.color='#64748b';this.style.background=''" }}">
                                    {{ $s['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
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
    const open = el.style.display === 'none';
    el.style.display = open ? 'block' : 'none';
    if (ar) ar.style.transform = open ? 'rotate(90deg)' : '';
}
</script>
</body>
</html>
