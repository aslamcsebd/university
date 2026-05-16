@extends('layouts.academic')

@section('title', 'Navigation Tree')
@section('heading', '🗂️ Full Navigation Tree')

@section('content')
@php
if (!function_exists('countLeaves')) {
    function countLeaves(array $items): int {
        $n = 0;
        foreach ($items as $item) {
            isset($item['children']) ? $n += countLeaves($item['children']) : $n++;
        }
        return $n;
    }
}

$sections = [
    [
        'title' => 'Academy Dashboard',
        'color' => '#6366f1',
        'bg'    => 'rgba(99,102,241,.08)',
        'items' => [
            ['label'=>'Departments', 'icon'=>'🏛️', 'url'=>'/academic/departments'],
            ['label'=>'Courses',     'icon'=>'🎓', 'url'=>'/academic/courses'],
            ['label'=>'Subjects',    'icon'=>'📖', 'url'=>'/academic/subjects'],
            ['label'=>'Semesters',   'icon'=>'📅', 'url'=>'/academic/semesters'],
            ['label'=>'Buildings',   'icon'=>'🏢', 'url'=>'/academic/buildings'],
            ['label'=>'Rooms',       'icon'=>'🏫', 'url'=>'/academic/rooms'],
            ['label'=>'Staff',       'icon'=>'👤', 'url'=>'/academic/staff'],
            ['label'=>'Timetable',   'icon'=>'🗓️', 'url'=>'/academic/timetable'],
            ['label'=>'Overview',    'icon'=>'📊', 'url'=>'/academic/overview'],
        ],
    ],
    [
        'title' => 'Student Panel',
        'color' => '#10b981',
        'bg'    => 'rgba(16,185,129,.08)',
        'items' => [
            ['label'=>'Dashboard',       'icon'=>'🏠'],
            ['label'=>'Class Schedules', 'icon'=>'📆'],
            ['label'=>'Exam Schedules',  'icon'=>'📝'],
            ['label'=>'Attendances',     'icon'=>'✅'],
            ['label'=>'Apply Leaves',    'icon'=>'🏖️'],
            ['label'=>'Fees Reports',    'icon'=>'💳'],
            ['label'=>'Library',         'icon'=>'📚'],
            ['label'=>'Notices',         'icon'=>'📢'],
            ['label'=>'Assignments',     'icon'=>'📋'],
            ['label'=>'Downloads',       'icon'=>'⬇️'],
            ['label'=>'Transcript',      'icon'=>'🎖️'],
            ['label'=>'My Profile',      'icon'=>'👤'],
        ],
    ],
    [
        'title' => 'Advanced Navigation',
        'color' => '#f59e0b',
        'bg'    => 'rgba(245,158,11,.06)',
        'items' => [
            ['label'=>'Dashboard','icon'=>'🏠'],
            ['label'=>'Admission','icon'=>'📋','children'=>[
                ['label'=>'Applications'],['label'=>'New Registration'],['label'=>'Student List'],
                ['label'=>'Transfers','children'=>[['label'=>'Transfer In'],['label'=>'Transfer Out']]],
                ['label'=>'Status Types'],['label'=>'ID Cards'],
                ['label'=>'Settings','children'=>[['label'=>'ID Card Setting']]],
            ]],
            ['label'=>'Students','icon'=>'🧑🎓','children'=>[
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
            ['label'=>'My Profile','icon'=>'👤'],
        ],
    ],
];

// Grand total of all leaf items across all sections
$grandTotal = 0;
foreach ($sections as $sec) {
    $grandTotal += countLeaves($sec['items']);
}
@endphp

<style>
    .tree-page { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }

    /* KPI bar */
    .kpi-bar { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:24px; }
    .kpi-card { background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:14px 20px; display:flex; align-items:center; gap:12px; flex:1; min-width:160px; }
    .kpi-icon { font-size:22px; }
    .kpi-val  { font-size:22px; font-weight:800; color:#1e1b4b; line-height:1; }
    .kpi-lbl  { font-size:11px; color:#6b7280; margin-top:2px; }

    /* Section card */
    .sec-card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:20px; overflow:hidden; }
    .sec-header { display:flex; align-items:center; gap:10px; padding:14px 20px; border-bottom:1px solid #f3f4f6; cursor:pointer; user-select:none; }
    .sec-header:hover { background:#fafafa; }
    .sec-title { font-size:14px; font-weight:700; flex:1; }
    .sec-badge { font-size:11px; font-weight:700; padding:2px 9px; border-radius:9px; }
    .sec-arrow { font-size:11px; color:#9ca3af; transition:transform .2s; }
    .sec-body  { padding:16px 20px; }

    /* Tree lines */
    .tree-root { list-style:none; margin:0; padding:0; }
    .tree-root > li { margin-bottom:6px; }

    /* Level-1 item (top of section) */
    .t1 { display:flex; align-items:center; gap:8px; padding:6px 10px; border-radius:7px; font-size:13px; font-weight:600; color:#1e1b4b; background:#f8fafc; border:1px solid #e5e7eb; cursor:pointer; }
    .t1:hover { background:#f1f5f9; }
    .t1-link { text-decoration:none; color:inherit; }
    .t1-icon { font-size:15px; }
    .t1-label { flex:1; }
    .t1-count { font-size:10px; font-weight:700; background:#e0e7ff; color:#4338ca; padding:1px 7px; border-radius:8px; }
    .t1-arrow { font-size:9px; color:#9ca3af; transition:transform .2s; margin-left:4px; }

    /* Level-2 sub-list */
    .t2-list { list-style:none; margin:4px 0 0 20px; padding:0; border-left:2px solid #e5e7eb; }
    .t2-list > li { position:relative; }
    .t2-list > li::before { content:''; position:absolute; left:-2px; top:50%; width:12px; height:2px; background:#e5e7eb; }

    .t2 { display:flex; align-items:center; gap:7px; padding:5px 8px 5px 14px; border-radius:5px; font-size:12.5px; color:#374151; cursor:pointer; }
    .t2:hover { background:#f1f5f9; color:#1e1b4b; }
    .t2-label { flex:1; }
    .t2-count { font-size:10px; font-weight:700; background:#d1fae5; color:#065f46; padding:1px 6px; border-radius:8px; }
    .t2-arrow { font-size:9px; color:#9ca3af; transition:transform .2s; }

    /* Level-3 sub-sub-list */
    .t3-list { list-style:none; margin:3px 0 0 14px; padding:0; border-left:2px dashed #e5e7eb; }
    .t3-list > li::before { content:'└ '; color:#d1d5db; font-size:10px; }
    .t3 { display:flex; align-items:center; gap:6px; padding:4px 8px 4px 10px; border-radius:4px; font-size:11.5px; color:#6b7280; }
    .t3:hover { background:#f9fafb; color:#374151; }

    /* Leaf dot */
    .leaf-dot { width:5px; height:5px; border-radius:50%; background:#d1d5db; flex-shrink:0; }

    /* Expand/collapse all */
    .ctrl-bar { display:flex; gap:8px; margin-bottom:16px; }
    .ctrl-btn { padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:1px solid #e5e7eb; background:#fff; color:#374151; }
    .ctrl-btn:hover { background:#f3f4f6; }
</style>

<div class="tree-page">

    {{-- KPI bar --}}
    <div class="kpi-bar">
        @php
            $acadCount = countLeaves($sections[0]['items']);
            $studCount = countLeaves($sections[1]['items']);
            $advCount  = countLeaves($sections[2]['items']);
        @endphp
        <div class="kpi-card">
            <span class="kpi-icon">📊</span>
            <div><div class="kpi-val">{{ $grandTotal }}</div><div class="kpi-lbl">Total Menu Items</div></div>
        </div>
        <div class="kpi-card">
            <span class="kpi-icon">🎓</span>
            <div><div class="kpi-val">{{ $acadCount }}</div><div class="kpi-lbl">Academy Dashboard</div></div>
        </div>
        <div class="kpi-card">
            <span class="kpi-icon">🧑‍🎓</span>
            <div><div class="kpi-val">{{ $studCount }}</div><div class="kpi-lbl">Student Panel</div></div>
        </div>
        <div class="kpi-card">
            <span class="kpi-icon">🗂️</span>
            <div><div class="kpi-val">{{ $advCount }}</div><div class="kpi-lbl">Advanced Nav</div></div>
        </div>
    </div>

    {{-- Controls --}}
    <div class="ctrl-bar">
        <button class="ctrl-btn" onclick="expandAll()">＋ Expand All</button>
        <button class="ctrl-btn" onclick="collapseAll()">－ Collapse All</button>
    </div>

    {{-- Sections --}}
    @foreach($sections as $si => $sec)
        @php $secCount = countLeaves($sec['items']); @endphp
        <div class="sec-card">
            <div class="sec-header" onclick="toggleSec('sec-body-{{ $si }}','sec-arr-{{ $si }}')">
                <span style="font-size:18px;">
                    @if($si===0) 🎓 @elseif($si===1) 🧑‍🎓 @else 🗂️ @endif
                </span>
                <span class="sec-title" style="color:{{ $sec['color'] }};">{{ $sec['title'] }}</span>
                <span class="sec-badge" style="background:{{ $sec['bg'] }};color:{{ $sec['color'] }};">{{ $secCount }} items</span>
                <span class="sec-arrow" id="sec-arr-{{ $si }}">▼</span>
            </div>
            <div class="sec-body" id="sec-body-{{ $si }}">
                <ul class="tree-root">
                @foreach($sec['items'] as $i => $item)
                    @php $hasChildren = isset($item['children']); $cnt = $hasChildren ? countLeaves($item['children']) : 0; @endphp
                    <li>
                        @if($hasChildren)
                            <div class="t1" onclick="toggleNode('t2-{{ $si }}-{{ $i }}','t1a-{{ $si }}-{{ $i }}')">
                                <span class="t1-icon">{{ $item['icon'] ?? '•' }}</span>
                                <span class="t1-label">{{ $item['label'] }}</span>
                                <span class="t1-count">{{ $cnt }}</span>
                                <span class="t1-arrow" id="t1a-{{ $si }}-{{ $i }}">▶</span>
                            </div>
                            <ul class="t2-list" id="t2-{{ $si }}-{{ $i }}" style="display:none;">
                                @foreach($item['children'] as $j => $child)
                                    @php $hasSub = isset($child['children']); $cCnt = $hasSub ? countLeaves($child['children']) : 0; @endphp
                                    <li>
                                        @if($hasSub)
                                            <div class="t2" onclick="toggleNode('t3-{{ $si }}-{{ $i }}-{{ $j }}','t2a-{{ $si }}-{{ $i }}-{{ $j }}')">
                                                <span class="t2-label">{{ $child['label'] }}</span>
                                                <span class="t2-count">{{ $cCnt }}</span>
                                                <span class="t2-arrow" id="t2a-{{ $si }}-{{ $i }}-{{ $j }}">▶</span>
                                            </div>
                                            <ul class="t3-list" id="t3-{{ $si }}-{{ $i }}-{{ $j }}" style="display:none;">
                                                @foreach($child['children'] as $leaf)
                                                    <li><div class="t3"><span class="leaf-dot"></span>{{ $leaf['label'] }}</div></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="t2"><span class="leaf-dot" style="background:#c7d2fe;"></span><span class="t2-label">{{ $child['label'] }}</span></div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="t1 t1-link" style="cursor:default; background:#fff; border-color:#f3f4f6;">
                                <span class="t1-icon">{{ $item['icon'] ?? '•' }}</span>
                                <span class="t1-label">{{ $item['label'] }}</span>
                                @if(isset($item['url']))<span style="font-size:10px;color:#9ca3af;">{{ $item['url'] }}</span>@endif
                            </div>
                        @endif
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    @endforeach

</div>

<script>
function toggleSec(bodyId, arrId) {
    const body = document.getElementById(bodyId);
    const arr  = document.getElementById(arrId);
    const open = body.style.display !== 'none';
    body.style.display = open ? 'none' : 'block';
    arr.style.transform = open ? 'rotate(-90deg)' : '';
}
function toggleNode(listId, arrId) {
    const list = document.getElementById(listId);
    const arr  = document.getElementById(arrId);
    const open = list.style.display !== 'none';
    list.style.display = open ? 'none' : 'block';
    if (arr) arr.style.transform = open ? '' : 'rotate(90deg)';
}
function expandAll() {
    document.querySelectorAll('[id^="sec-body-"],[id^="t2-"],[id^="t3-"]').forEach(el => el.style.display = 'block');
    document.querySelectorAll('[id^="sec-arr-"],[id^="t1a-"],[id^="t2a-"]').forEach(el => el.style.transform = 'rotate(90deg)');
}
function collapseAll() {
    document.querySelectorAll('[id^="t2-"],[id^="t3-"]').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="t1a-"],[id^="t2a-"]').forEach(el => el.style.transform = '');
    document.querySelectorAll('[id^="sec-arr-"]').forEach(el => el.style.transform = '');
}
</script>
@endsection
