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
        .nav-count { font-size:10px; font-weight:700; background:rgba(99,102,241,.35); color:#c7d2fe; padding:1px 6px; border-radius:9px; margin-right:4px; flex-shrink:0; }
        .nav-count-green { font-size:10px; font-weight:700; background:rgba(52,211,153,.2); color:#6ee7b7; padding:1px 5px; border-radius:9px; margin-right:4px; flex-shrink:0; }
    </style>
</head>
<body style="background:#f1f5f9; min-height:100vh;">

@php
if (!function_exists('countLeaves')) {
    function countLeaves(array $items): int {
        $n = 0;
        foreach ($items as $item) {
            if (isset($item['children'])) {
                $n += countLeaves($item['children']);
            } else {
                $n++;
            }
        }
        return $n;
    }
}

$advMenu = [
    ['label'=>'Dashboard','icon'=>'🏠','url'=>'/dashboard'],
    ['label'=>'Admission','icon'=>'📋','children'=>[
        ['label'=>'Applications'],['label'=>'New Registration'],['label'=>'Student List'],
        ['label'=>'Transfers','children'=>[['label'=>'Transfer In'],['label'=>'Transfer Out']]],
        ['label'=>'Status Types'],['label'=>'ID Cards'],
        ['label'=>'Settings','children'=>[['label'=>'ID Card Setting']]],
    ]],
    ['label'=>'Students','icon'=>'🧑‍🎓','children'=>[
        ['label'=>'Attendances','children'=>[['label'=>'Subject Attendances'],['label'=>'Attendance Reports']]],
        ['label'=>'Manage Leave'],['label'=>'Student Notes'],
        ['label'=>'Enrollments','children'=>[['label'=>'Single Enroll'],['label'=>'Group Enrolls'],['label'=>'Course Add Drop'],['label'=>'Course Graduation']]],
        ['label'=>'Alumni List'],
    ]],
    ['label'=>'Academic','icon'=>'🏛️','children'=>[
        ['label'=>'Faculties'],['label'=>'Programs'],['label'=>'Batches'],['label'=>'Sessions'],
        ['label'=>'Semesters'],['label'=>'Sections'],['label'=>'Class Rooms'],['label'=>'Courses'],['label'=>'Enroll Courses'],
    ]],
    ['label'=>'Routines','icon'=>'📆','children'=>[
        ['label'=>'Manage Classes'],['label'=>'Class Schedules'],['label'=>'Manage Exams'],['label'=>'Exam Schedules'],['label'=>'Teacher Routines'],
        ['label'=>'Settings','children'=>[['label'=>'Class Schedule'],['label'=>'Exam Schedule']]],
    ]],
    ['label'=>'Examinations','icon'=>'📝','children'=>[
        ['label'=>'Exam Attendances'],['label'=>'Exam Mark Ledger'],['label'=>'Exam Results'],
        ['label'=>'Course Mark Ledger'],['label'=>'Course Results'],['label'=>'Grading Systems'],
        ['label'=>'Exam Types'],['label'=>'Admit Cards'],
        ['label'=>'Settings','children'=>[['label'=>'Admit Setting'],['label'=>'Mark Distribution']]],
    ]],
    ['label'=>'Study Materials','icon'=>'📚','children'=>[
        ['label'=>'Assignments'],['label'=>'Content List'],['label'=>'Content Types'],
    ]],
    ['label'=>'Fees Collection','icon'=>'💳','children'=>[
        ['label'=>'Student Fees','children'=>[['label'=>'Fees Due'],['label'=>'Quick Assign'],['label'=>'Quick Received'],['label'=>'Fees Reports']]],
        ['label'=>'Assign Group Fees'],['label'=>'Assigned History'],['label'=>'Fees Types'],['label'=>'Fees Discounts'],['label'=>'Fees Fines'],
        ['label'=>'Settings','children'=>[['label'=>'Receipt Setting']]],
    ]],
    ['label'=>'Human Resources','icon'=>'👥','children'=>[
        ['label'=>'Staff List'],['label'=>'Staff Notes'],['label'=>'Payrolls'],['label'=>'Payroll Reports'],
        ['label'=>'Work Shift Types'],['label'=>'Designations'],['label'=>'Departments'],
        ['label'=>'Settings','children'=>[['label'=>'Tax Settings'],['label'=>'Pay Slip Setting']]],
    ]],
    ['label'=>'Staff Attendances','icon'=>'✅','children'=>[
        ['label'=>'Daily Attendances'],['label'=>'Daily Reports'],['label'=>'Hourly Attendances'],['label'=>'Hourly Reports'],
    ]],
    ['label'=>'Leave Manager','icon'=>'🏖️','children'=>[
        ['label'=>'Apply Leave'],['label'=>'My Leaves'],['label'=>'Leave Types'],['label'=>'Manage Leave'],
    ]],
    ['label'=>'Accounts','icon'=>'💰','children'=>[
        ['label'=>'Income List'],['label'=>'Income Categories'],['label'=>'Expense List'],['label'=>'Expense Categories'],['label'=>'Outcome Overview'],
    ]],
    ['label'=>'Communicates','icon'=>'📢','children'=>[
        ['label'=>'Send Email'],['label'=>'Send SMS'],['label'=>'Event List'],['label'=>'Calendar'],['label'=>'Notice List'],['label'=>'Notice Categories'],
    ]],
    ['label'=>'Library','icon'=>'📖','children'=>[
        ['label'=>'Issue Book'],['label'=>'Issue & Return'],
        ['label'=>'Members','children'=>[['label'=>'Student List'],['label'=>'Staff List'],['label'=>'Outsider List']]],
        ['label'=>'Book List'],['label'=>'Book Requests'],['label'=>'Book Categories'],
        ['label'=>'Settings','children'=>[['label'=>'Card Setting']]],
    ]],
    ['label'=>'Inventory','icon'=>'📦','children'=>[
        ['label'=>'Issue Item'],['label'=>'Issue & Return'],['label'=>'Item Stocks'],
        ['label'=>'Item List'],['label'=>'Stores'],['label'=>'Suppliers'],['label'=>'Categories'],
    ]],
    ['label'=>'Hostels','icon'=>'🏠','children'=>[
        ['label'=>'Members','children'=>[['label'=>'Student List'],['label'=>'Staff List']]],
        ['label'=>'Hostel Rooms'],['label'=>'Hostel List'],['label'=>'Room Types'],
    ]],
    ['label'=>'Transports','icon'=>'🚌','children'=>[
        ['label'=>'Members','children'=>[['label'=>'Student List'],['label'=>'Staff List']]],
        ['label'=>'Vehicles'],['label'=>'Routes'],
    ]],
    ['label'=>'Front Desk','icon'=>'🖥️','children'=>[
        ['label'=>'Visitor Logs'],['label'=>'Phone Logs'],['label'=>'Enquiry List'],['label'=>'Complain List'],['label'=>'Postal Exchanges'],['label'=>'Meeting Schedules'],
        ['label'=>'Settings','children'=>[['label'=>'Visit Purposes'],['label'=>'Token Settings'],['label'=>'Enquiry Sources'],['label'=>'Enquiry References'],['label'=>'Complain Types'],['label'=>'Complain Sources'],['label'=>'Postal Types'],['label'=>'Meeting Types']]],
    ]],
    ['label'=>'Transcripts','icon'=>'🎖️','children'=>[
        ['label'=>'Semester Marksheets'],['label'=>'Total Marksheets'],['label'=>'Marksheet Setting'],['label'=>'Certificates'],['label'=>'Certificate Templates'],
    ]],
    ['label'=>'Reports','icon'=>'📊','children'=>[
        ['label'=>'Student Progress'],['label'=>'Course Students'],['label'=>'Student Attendance'],['label'=>'Subject Attendance'],
        ['label'=>'Collected Fees'],['label'=>'Student Fees'],['label'=>'Salary Paid'],['label'=>'Staff Leaves'],
        ['label'=>'Total Income'],['label'=>'Total Expense'],['label'=>'Library History'],['label'=>'Book Return Due'],
        ['label'=>'Inventory History'],['label'=>'Hostel Members'],['label'=>'Transport Members'],
    ]],
    ['label'=>'Front Web','icon'=>'🌐','children'=>[
        ['label'=>'Contact Setting'],['label'=>'Social Setting'],['label'=>'Sliders'],['label'=>'About Us'],
        ['label'=>'Features'],['label'=>'Courses'],['label'=>'Event'],['label'=>'News'],['label'=>'Faqs'],
        ['label'=>'Gallery'],['label'=>'Testimonials'],['label'=>'Footer Pages'],['label'=>'Call To Action'],
    ]],
    ['label'=>'Settings','icon'=>'⚙️','children'=>[
        ['label'=>'General'],['label'=>'States/Provinces'],['label'=>'Districts/Cities'],['label'=>'Languages'],
        ['label'=>'Mail Setting'],['label'=>'SMS Getaways'],['label'=>'Payment Getaways'],['label'=>'Online Application'],['label'=>'Roles and Permissions'],
        ['label'=>'Field Settings','children'=>[['label'=>'Staffs'],['label'=>'Students'],['label'=>'Applications']]],
        ['label'=>'Student Panel'],
    ]],
    ['label'=>'My Profile','icon'=>'👤','url'=>'/profile'],
];

$advTotal = countLeaves($advMenu);
$path = request()->getPathInfo();
@endphp

<div style="display:flex; min-height:100vh;">
    {{-- Sidebar --}}
    <aside style="width:220px; background:#1e1b4b; color:#fff; display:flex; flex-direction:column; flex-shrink:0;">
        <div style="padding:18px 20px 14px; border-bottom:1px solid rgba(255,255,255,.1);">
            <div style="font-size:15px; font-weight:800; color:#fff; letter-spacing:.01em;">🎓 Academy</div>
            <div style="font-size:10px; font-weight:600; letter-spacing:.08em; color:#a5b4fc; text-transform:uppercase; margin-top:2px;">Admin Dashboard</div>
        </div>
        <nav style="flex:1; padding:12px 10px; display:flex; flex-direction:column; gap:2px; overflow-y:auto;">
            {{-- Academy Dashboard section --}}
            <div style="font-size:10px; font-weight:700; letter-spacing:.1em; color:#6366f1; text-transform:uppercase; padding:8px 12px 4px;">Academy Dashboard</div>
            @php
                $navItems = [
                    ['label'=>'Departments', 'icon'=>'🏛️', 'url'=>'/academic/departments'],
                    ['label'=>'Courses',     'icon'=>'🎓', 'url'=>'/academic/courses'],
                    ['label'=>'Subjects',    'icon'=>'📖', 'url'=>'/academic/subjects'],
                    ['label'=>'Semesters',   'icon'=>'📅', 'url'=>'/academic/semesters'],
                    ['label'=>'Buildings',   'icon'=>'🏢', 'url'=>'/academic/buildings'],
                    ['label'=>'Rooms',       'icon'=>'🏫', 'url'=>'/academic/rooms'],
                    ['label'=>'Staff',       'icon'=>'👤', 'url'=>'/academic/staff'],
                    ['label'=>'Timetable',   'icon'=>'🗓️', 'url'=>'/academic/timetable'],
                    ['label'=>'Overview',    'icon'=>'📊', 'url'=>'/academic/overview'],
                    ['label'=>'Nav Tree',     'icon'=>'🌳', 'url'=>'/academic/tree'],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $active = str_starts_with($path, $item['url']); @endphp
                <a href="{{ $item['url'] }}" style="display:flex; align-items:center; gap:9px; padding:9px 12px; border-radius:7px; font-size:13px; text-decoration:none; transition:background .15s;
                    {{ $active ? 'background:#4f46e5; color:#fff; font-weight:600;' : 'color:#c7d2fe;' }}"
                   onmouseover="{{ $active ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
                   onmouseout="{{ $active ? '' : "this.style.background=''" }}">
                    <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
                </a>
            @endforeach

            {{-- Advanced Nav toggle --}}
            <button onclick="toggleAdvNav()" id="adv-nav-btn"
                style="display:flex; align-items:center; gap:9px; padding:9px 12px; border-radius:7px; font-size:13px; width:100%; background:rgba(99,102,241,.15); border:1px dashed rgba(99,102,241,.4); color:#a5b4fc; cursor:pointer; margin-top:4px; transition:background .15s;">
                <span>🗂️</span>
                <span style="flex:1; text-align:left;">Advanced Nav</span>
                <span class="nav-count">{{ $advTotal }}</span>
                <span id="adv-nav-arrow" style="font-size:10px; transition:transform .2s;">▶</span>
            </button>

            {{-- Advanced Nav tree --}}
            <div id="adv-nav-tree" style="display:none; margin-top:2px;">
            @foreach($advMenu as $gi => $g)
                @if(isset($g['url']))
                    <a href="{{ $g['url'] }}" style="display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:6px;font-size:12px;color:#c7d2fe;text-decoration:none;"
                       onmouseover="this.style.background='rgba(255,255,255,.07)'" onmouseout="this.style.background=''">
                        <span>{{ $g['icon'] ?? '' }}</span><span>{{ $g['label'] }}</span>
                    </a>
                @elseif(isset($g['children']))
                    @php $gCount = countLeaves($g['children']); @endphp
                    <div>
                        <button onclick="advToggle('at{{ $gi }}','aa{{ $gi }}')"
                            style="display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:6px;font-size:12px;color:#c7d2fe;background:none;border:none;width:100%;cursor:pointer;"
                            onmouseover="this.style.background='rgba(255,255,255,.07)'" onmouseout="this.style.background=''">
                            <span>{{ $g['icon'] ?? '•' }}</span>
                            <span style="flex:1;text-align:left;">{{ $g['label'] }}</span>
                            <span class="nav-count">{{ $gCount }}</span>
                            <span id="aa{{ $gi }}" style="font-size:9px;transition:transform .2s;">▶</span>
                        </button>
                        <div id="at{{ $gi }}" style="display:none;">
                            @foreach($g['children'] as $ci => $c)
                                @if(isset($c['children']))
                                    @php $cCount = countLeaves($c['children']); @endphp
                                    <div>
                                        <button onclick="advToggle('at{{ $gi }}_{{ $ci }}','aa{{ $gi }}_{{ $ci }}')"
                                            style="display:flex;align-items:center;gap:8px;padding:6px 10px 6px 26px;border-radius:6px;font-size:11.5px;color:#94a3b8;background:none;border:none;width:100%;cursor:pointer;"
                                            onmouseover="this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.background=''">
                                            <span style="flex:1;text-align:left;">{{ $c['label'] }}</span>
                                            <span class="nav-count-green">{{ $cCount }}</span>
                                            <span id="aa{{ $gi }}_{{ $ci }}" style="font-size:9px;transition:transform .2s;">▶</span>
                                        </button>
                                        <div id="at{{ $gi }}_{{ $ci }}" style="display:none;">
                                            @foreach($c['children'] as $leaf)
                                                <a href="#" style="display:block;padding:5px 10px 5px 42px;font-size:11px;color:#64748b;text-decoration:none;border-radius:5px;"
                                                   onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'">{{ $leaf['label'] }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="#" style="display:block;padding:6px 10px 6px 26px;font-size:11.5px;color:#94a3b8;text-decoration:none;border-radius:5px;"
                                       onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.color='#94a3b8';this.style.background=''">{{ $c['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
            </div>

            {{-- Student section --}}
            <div style="margin-top:16px; border-top:1px solid rgba(255,255,255,.08); padding-top:12px;">
                <div style="font-size:10px; font-weight:700; letter-spacing:.1em; color:#34d399; text-transform:uppercase; padding:0 12px 6px;">Student</div>
                @php
                    $studentItems = [
                        ['label'=>'Dashboard',       'icon'=>'🏠', 'url'=>'/student/dashboard'],
                        ['label'=>'Class Schedules', 'icon'=>'📆', 'url'=>'/student/class-schedules'],
                        ['label'=>'Exam Schedules',  'icon'=>'📝', 'url'=>'/student/exam-schedules'],
                        ['label'=>'Attendances',     'icon'=>'✅', 'url'=>'/student/attendances'],
                        ['label'=>'Apply Leaves',    'icon'=>'🏖️', 'url'=>'/student/apply-leaves'],
                        ['label'=>'Fees Reports',    'icon'=>'💳', 'url'=>'/student/fees-reports'],
                        ['label'=>'Library',         'icon'=>'📚', 'url'=>'/student/library'],
                        ['label'=>'Notices',         'icon'=>'📢', 'url'=>'/student/notices'],
                        ['label'=>'Assignments',     'icon'=>'📋', 'url'=>'/student/assignments'],
                        ['label'=>'Downloads',       'icon'=>'⬇️', 'url'=>'/student/downloads'],
                        ['label'=>'Transcript',      'icon'=>'🎖️', 'url'=>'/student/transcript'],
                        ['label'=>'My Profile',      'icon'=>'👤', 'url'=>'/student/my-profile'],
                    ];
                @endphp
                @foreach($studentItems as $item)
                    @php $sActive = str_starts_with($path, $item['url']); @endphp
                    <a href="{{ $item['url'] }}" style="display:flex; align-items:center; gap:9px; padding:8px 12px; border-radius:7px; font-size:13px; text-decoration:none; transition:background .15s;
                        {{ $sActive ? 'background:#059669; color:#fff; font-weight:600;' : 'color:#a7f3d0;' }}"
                       onmouseover="{{ $sActive ? '' : "this.style.background='rgba(52,211,153,.12)'" }}"
                       onmouseout="{{ $sActive ? '' : "this.style.background=''" }}">
                        <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>
        <div style="padding:12px 20px; border-top:1px solid rgba(255,255,255,.1); font-size:11px; color:#a5b4fc; display:flex; flex-direction:column; gap:6px;">
            <span>{{ Auth::user()->name ?? 'Guest' }}</span>
            <a href="/dashboard" style="color:#818cf8; text-decoration:none;">← Dashboard</a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" style="background:none; border:none; color:#f87171; font-size:11px; cursor:pointer; padding:0;">Logout</button>
            </form>
            <a href="/university" target="_blank" style="display:flex; align-items:center; gap:6px; margin-top:6px; padding:8px 10px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-radius:7px; text-decoration:none; font-size:11px; font-weight:700; letter-spacing:.03em;">
                🌐 University Website
            </a>
        </div>
    </aside>

    {{-- Content --}}
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

{{-- Modal backdrop --}}
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
function toggleAdvNav() {
    const tree = document.getElementById('adv-nav-tree');
    const arrow = document.getElementById('adv-nav-arrow');
    const open = tree.style.display === 'none';
    tree.style.display = open ? 'block' : 'none';
    arrow.style.transform = open ? 'rotate(90deg)' : '';
}
function advToggle(treeId, arrowId) {
    const el = document.getElementById(treeId);
    const ar = document.getElementById(arrowId);
    const open = el.style.display === 'none';
    el.style.display = open ? 'block' : 'none';
    if (ar) ar.style.transform = open ? 'rotate(90deg)' : '';
}
</script>
</body>
</html>
