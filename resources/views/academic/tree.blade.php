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

{{-- ═══════════════════════════════════════════════════════════
     SUPER TREE — Interactive Canvas Relationship Map
═══════════════════════════════════════════════════════════ --}}
<div style="margin-top:40px;">

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px;">
        <div style="flex:1;height:2px;background:linear-gradient(90deg,#6366f1,#8b5cf6,#ec4899);"></div>
        <span style="font-size:18px;font-weight:800;color:#1e1b4b;white-space:nowrap;">🕸️ Super Relationship Tree</span>
        <div style="flex:1;height:2px;background:linear-gradient(90deg,#ec4899,#8b5cf6,#6366f1);"></div>
    </div>
    <p style="text-align:center;font-size:12px;color:#9ca3af;margin:0 0 16px;">Drag nodes · Hover to highlight connections · Click to pin/unpin</p>

    <div style="background:#0f0c29;border-radius:16px;border:1px solid rgba(99,102,241,.3);overflow:hidden;position:relative;">
        {{-- toolbar --}}
        <div style="display:flex;align-items:center;gap:8px;padding:10px 16px;border-bottom:1px solid rgba(255,255,255,.07);">
            <button onclick="stReset()" style="padding:4px 12px;border-radius:6px;font-size:11px;font-weight:700;background:rgba(99,102,241,.25);color:#a5b4fc;border:1px solid rgba(99,102,241,.4);cursor:pointer;">⟳ Reset</button>
            <button onclick="stFitAll()" style="padding:4px 12px;border-radius:6px;font-size:11px;font-weight:700;background:rgba(99,102,241,.25);color:#a5b4fc;border:1px solid rgba(99,102,241,.4);cursor:pointer;">⊡ Fit</button>
            <button onclick="stToggleLabels()" style="padding:4px 12px;border-radius:6px;font-size:11px;font-weight:700;background:rgba(99,102,241,.25);color:#a5b4fc;border:1px solid rgba(99,102,241,.4);cursor:pointer;">🏷 Labels</button>
            <div style="flex:1;"></div>
            {{-- legend --}}
            <span style="font-size:10px;color:#6366f1;font-weight:700;">● Academic</span>
            <span style="font-size:10px;color:#10b981;font-weight:700;">● Student</span>
            <span style="font-size:10px;color:#f59e0b;font-weight:700;">● Advanced</span>
            <span style="font-size:10px;color:#ec4899;font-weight:700;">● Shared</span>
        </div>
        <canvas id="superTreeCanvas" style="display:block;width:100%;cursor:grab;"></canvas>
    </div>

    {{-- tooltip --}}
    <div id="stTooltip" style="position:fixed;display:none;background:#1e1b4b;color:#e0e7ff;font-size:12px;font-weight:600;padding:6px 12px;border-radius:8px;border:1px solid rgba(99,102,241,.5);pointer-events:none;z-index:9999;box-shadow:0 4px 20px rgba(0,0,0,.4);"></div>
</div>

<script>
// ─── Super Tree Engine ───────────────────────────────────────
(function(){
'use strict';
const C = document.getElementById('superTreeCanvas');
const TT = document.getElementById('stTooltip');
const ctx = C.getContext('2d');

// ── Node definitions ────────────────────────────────────────
// type: 'root'|'module'|'shared'
// color: node fill
// links: array of node ids this connects TO
const RAW_NODES = [
  // ── SYSTEM ROOT
  {id:'root',      label:'🎓 Academy System', icon:'🎓', type:'root',   color:'#fff',    textColor:'#1e1b4b', size:36},

  // ── ACADEMIC DASHBOARD modules
  {id:'dept',      label:'Departments',    icon:'🏛️', type:'acad',   color:'#6366f1', size:22},
  {id:'courses',   label:'Courses',        icon:'🎓', type:'acad',   color:'#6366f1', size:22},
  {id:'subjects',  label:'Subjects',       icon:'📖', type:'acad',   color:'#6366f1', size:22},
  {id:'semesters', label:'Semesters',      icon:'📅', type:'acad',   color:'#6366f1', size:22},
  {id:'buildings', label:'Buildings',      icon:'🏢', type:'acad',   color:'#6366f1', size:20},
  {id:'rooms',     label:'Rooms',          icon:'🏫', type:'acad',   color:'#6366f1', size:20},
  {id:'staff',     label:'Staff',          icon:'👤', type:'acad',   color:'#6366f1', size:22},
  {id:'timetable', label:'Timetable',      icon:'🗓️', type:'acad',   color:'#6366f1', size:24},

  // ── STUDENT PANEL modules
  {id:'sp_dash',   label:'Student Dashboard', icon:'🏠', type:'stud', color:'#10b981', size:22},
  {id:'sp_cls',    label:'Class Schedules',   icon:'📆', type:'stud', color:'#10b981', size:20},
  {id:'sp_exam',   label:'Exam Schedules',    icon:'📝', type:'stud', color:'#10b981', size:20},
  {id:'sp_att',    label:'Attendances',       icon:'✅', type:'stud', color:'#10b981', size:20},
  {id:'sp_fees',   label:'Fees Reports',      icon:'💳', type:'stud', color:'#10b981', size:20},
  {id:'sp_lib',    label:'Library',           icon:'📚', type:'stud', color:'#10b981', size:20},
  {id:'sp_trans',  label:'Transcript',        icon:'🏅', type:'stud', color:'#10b981', size:20},

  // ── ADVANCED NAV modules
  {id:'admission', label:'Admission',       icon:'📋', type:'adv',   color:'#f59e0b', size:24},
  {id:'students',  label:'Students',        icon:'👨🎓',type:'adv',   color:'#f59e0b', size:24},
  {id:'routines',  label:'Routines',        icon:'📆', type:'adv',   color:'#f59e0b', size:22},
  {id:'exams',     label:'Examinations',    icon:'📝', type:'adv',   color:'#f59e0b', size:22},
  {id:'fees',      label:'Fees Collection', icon:'💳', type:'adv',   color:'#f59e0b', size:22},
  {id:'hr',        label:'Human Resources', icon:'👥', type:'adv',   color:'#f59e0b', size:22},
  {id:'library',   label:'Library Mgmt',   icon:'📖', type:'adv',   color:'#f59e0b', size:22},
  {id:'inventory', label:'Inventory',       icon:'📦', type:'adv',   color:'#f59e0b', size:20},
  {id:'hostels',   label:'Hostels',         icon:'🏠', type:'adv',   color:'#f59e0b', size:20},
  {id:'transport', label:'Transports',      icon:'🚌', type:'adv',   color:'#f59e0b', size:20},
  {id:'frontdesk', label:'Front Desk',      icon:'🖥', type:'adv',   color:'#f59e0b', size:20},
  {id:'reports',   label:'Reports',         icon:'📊', type:'adv',   color:'#f59e0b', size:24},
  {id:'communicate',label:'Communicate',    icon:'📢', type:'adv',   color:'#f59e0b', size:20},
  {id:'settings',  label:'Settings',        icon:'⚙️', type:'adv',   color:'#f59e0b', size:22},
  {id:'transcripts',label:'Transcripts',    icon:'🏅', type:'adv',   color:'#f59e0b', size:20},

  // ── SHARED / CROSS-SECTION nodes
  {id:'x_student', label:'Student (shared)', icon:'👨🎓',type:'shared', color:'#ec4899', size:26},
  {id:'x_staff',   label:'Staff (shared)',   icon:'👥', type:'shared', color:'#ec4899', size:26},
  {id:'x_finance', label:'Finance (shared)', icon:'💰', type:'shared', color:'#ec4899', size:26},
];

const EDGES = [
  // root → section hubs
  ['root','dept'],['root','courses'],['root','staff'],['root','timetable'],
  ['root','sp_dash'],['root','admission'],['root','settings'],['root','reports'],

  // Academic internal
  ['dept','courses'],['courses','subjects'],['subjects','semesters'],
  ['buildings','rooms'],['rooms','timetable'],['timetable','courses'],
  ['staff','timetable'],

  // Student panel internal
  ['sp_dash','sp_cls'],['sp_dash','sp_exam'],['sp_dash','sp_att'],
  ['sp_dash','sp_fees'],['sp_dash','sp_lib'],['sp_dash','sp_trans'],

  // Advanced internal
  ['admission','students'],['students','routines'],['routines','exams'],
  ['exams','transcripts'],['transcripts','reports'],
  ['fees','reports'],['hr','reports'],
  ['library','inventory'],['hostels','transport'],
  ['frontdesk','communicate'],['settings','admission'],

  // Cross-section via shared nodes
  ['x_student','sp_dash'],['x_student','admission'],['x_student','students'],
  ['x_student','sp_att'],['x_student','sp_fees'],['x_student','sp_trans'],
  ['x_staff','staff'],['x_staff','hr'],['x_staff','timetable'],
  ['x_finance','fees'],['x_finance','sp_fees'],['x_finance','reports'],

  // Timetable ↔ Routines
  ['timetable','routines'],['sp_cls','routines'],['sp_exam','exams'],

  // Library cross
  ['sp_lib','library'],

  // Staff cross
  ['staff','hr'],
];

// ── Build node map ───────────────────────────────────────────
const nodeMap = {};
RAW_NODES.forEach(n => { nodeMap[n.id] = n; });

// ── Layout: place nodes in rings ────────────────────────────
function layoutNodes(W, H) {
  const cx = W/2, cy = H/2;
  // root at center
  nodeMap['root'].x = cx; nodeMap['root'].y = cy;

  const rings = [
    { ids:['dept','courses','subjects','semesters','buildings','rooms','staff','timetable'], r:160, startAngle:-Math.PI/2 },
    { ids:['sp_dash','sp_cls','sp_exam','sp_att','sp_fees','sp_lib','sp_trans'], r:260, startAngle: Math.PI/6 },
    { ids:['admission','students','routines','exams','fees','hr','library','inventory','hostels','transport','frontdesk','reports','communicate','settings','transcripts'], r:370, startAngle:-Math.PI/2 },
    { ids:['x_student','x_staff','x_finance'], r:480, startAngle: Math.PI/4 },
  ];
  rings.forEach(ring => {
    ring.ids.forEach((id, i) => {
      const angle = ring.startAngle + (2*Math.PI/ring.ids.length)*i;
      nodeMap[id].x = cx + ring.r * Math.cos(angle);
      nodeMap[id].y = cy + ring.r * Math.sin(angle);
    });
  });
}

// ── State ────────────────────────────────────────────────────
let nodes = [], edges = [], scale = 1, offsetX = 0, offsetY = 0;
let dragging = null, dragOffX = 0, dragOffY = 0;
let hoverId = null, pinnedId = null;
let showLabels = true;
let animFrame = 0;

function init() {
  resize();
  nodes = RAW_NODES.map(n => ({...n}));
  nodes.forEach(n => { nodeMap[n.id] = n; });
  layoutNodes(C.width, C.height);
  edges = EDGES.map(([a,b]) => ({from:a, to:b}));
  draw();
}

function resize() {
  const rect = C.parentElement.getBoundingClientRect();
  C.width  = rect.width  || 900;
  C.height = Math.max(560, rect.width * 0.55);
  C.style.height = C.height + 'px';
}

// ── Draw ─────────────────────────────────────────────────────
function draw() {
  const W = C.width, H = C.height;
  ctx.clearRect(0,0,W,H);

  // background grid
  ctx.save();
  ctx.strokeStyle = 'rgba(99,102,241,.06)';
  ctx.lineWidth = 1;
  for(let x=0;x<W;x+=40){ctx.beginPath();ctx.moveTo(x,0);ctx.lineTo(x,H);ctx.stroke();}
  for(let y=0;y<H;y+=40){ctx.beginPath();ctx.moveTo(0,y);ctx.lineTo(W,y);ctx.stroke();}
  ctx.restore();

  ctx.save();
  ctx.translate(offsetX, offsetY);
  ctx.scale(scale, scale);

  const activeId = pinnedId || hoverId;
  const connectedIds = new Set();
  if (activeId) {
    edges.forEach(e => {
      if (e.from===activeId||e.to===activeId) {
        connectedIds.add(e.from); connectedIds.add(e.to);
      }
    });
  }

  // draw edges
  edges.forEach(e => {
    const a = nodeMap[e.from], b = nodeMap[e.to];
    if (!a||!b) return;
    const isActive = activeId && (e.from===activeId||e.to===activeId);
    const isFaded  = activeId && !isActive;
    ctx.beginPath();
    ctx.moveTo(a.x, a.y);
    // bezier curve
    const mx = (a.x+b.x)/2, my = (a.y+b.y)/2;
    const dx = b.y-a.y, dy = a.x-b.x;
    const len = Math.sqrt(dx*dx+dy*dy)||1;
    const bend = 0.15;
    ctx.quadraticCurveTo(mx+dx*bend, my+dy*bend, b.x, b.y);
    if (isActive) {
      ctx.strokeStyle = '#a5b4fc';
      ctx.lineWidth = 2;
      ctx.globalAlpha = 1;
    } else if (isFaded) {
      ctx.strokeStyle = 'rgba(99,102,241,.08)';
      ctx.lineWidth = 1;
      ctx.globalAlpha = 1;
    } else {
      ctx.strokeStyle = 'rgba(99,102,241,.22)';
      ctx.lineWidth = 1;
      ctx.globalAlpha = 1;
    }
    ctx.stroke();

    // arrowhead on active edges
    if (isActive) {
      const angle = Math.atan2(b.y-a.y, b.x-a.x);
      const ar = b.size + 4;
      const tx = b.x - ar*Math.cos(angle), ty = b.y - ar*Math.sin(angle);
      ctx.beginPath();
      ctx.moveTo(tx, ty);
      ctx.lineTo(tx - 8*Math.cos(angle-0.4), ty - 8*Math.sin(angle-0.4));
      ctx.lineTo(tx - 8*Math.cos(angle+0.4), ty - 8*Math.sin(angle+0.4));
      ctx.closePath();
      ctx.fillStyle = '#a5b4fc';
      ctx.fill();
    }
  });

  // draw nodes
  nodes.forEach(n => {
    const isActive = n.id === activeId;
    const isConn   = connectedIds.has(n.id);
    const isFaded  = activeId && !isActive && !isConn;
    const r = n.size;

    ctx.globalAlpha = isFaded ? 0.25 : 1;

    // glow on active
    if (isActive) {
      ctx.shadowColor = n.color;
      ctx.shadowBlur  = 20;
    } else if (isConn) {
      ctx.shadowColor = n.color;
      ctx.shadowBlur  = 8;
    } else {
      ctx.shadowBlur = 0;
    }

    // node circle
    ctx.beginPath();
    ctx.arc(n.x, n.y, r, 0, Math.PI*2);
    if (n.type==='root') {
      const g = ctx.createRadialGradient(n.x-r*.3,n.y-r*.3,r*.1,n.x,n.y,r);
      g.addColorStop(0,'#fff'); g.addColorStop(1,'#e0e7ff');
      ctx.fillStyle = g;
    } else {
      const g = ctx.createRadialGradient(n.x-r*.3,n.y-r*.3,r*.1,n.x,n.y,r);
      g.addColorStop(0, lighten(n.color, 40));
      g.addColorStop(1, n.color);
      ctx.fillStyle = g;
    }
    ctx.fill();

    // border
    ctx.strokeStyle = isActive ? '#fff' : (isConn ? '#e0e7ff' : 'rgba(255,255,255,.2)');
    ctx.lineWidth   = isActive ? 2.5 : 1;
    ctx.stroke();
    ctx.shadowBlur  = 0;

    // icon
    ctx.font = `${Math.round(r*.9)}px serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.globalAlpha = isFaded ? 0.25 : 1;
    ctx.fillText(n.icon||'', n.x, n.y);

    // label
    if (showLabels || isActive || isConn) {
      ctx.font = `${isActive?700:600} ${isActive?12:10}px ui-sans-serif,system-ui,sans-serif`;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'top';
      ctx.fillStyle = isActive ? '#fff' : (isFaded ? 'rgba(255,255,255,.2)' : 'rgba(255,255,255,.75)');
      ctx.fillText(n.label, n.x, n.y + r + 4);
    }

    // pinned ring
    if (n.id === pinnedId) {
      ctx.beginPath();
      ctx.arc(n.x, n.y, r+5, 0, Math.PI*2);
      ctx.strokeStyle = '#fff';
      ctx.lineWidth = 1.5;
      ctx.setLineDash([4,3]);
      ctx.stroke();
      ctx.setLineDash([]);
    }

    ctx.globalAlpha = 1;
  });

  ctx.restore();
}

function lighten(hex, amt) {
  const n = parseInt(hex.slice(1),16);
  const r = Math.min(255,((n>>16)&0xff)+amt);
  const g = Math.min(255,((n>>8)&0xff)+amt);
  const b = Math.min(255,(n&0xff)+amt);
  return `rgb(${r},${g},${b})`;
}

// ── World ↔ Screen coords ────────────────────────────────────
function toWorld(ex, ey) {
  const rect = C.getBoundingClientRect();
  return {
    x: (ex - rect.left - offsetX) / scale,
    y: (ey - rect.top  - offsetY) / scale,
  };
}

function hitNode(wx, wy) {
  for (let i = nodes.length-1; i>=0; i--) {
    const n = nodes[i];
    const dx = wx-n.x, dy = wy-n.y;
    if (dx*dx+dy*dy <= (n.size+4)*(n.size+4)) return n;
  }
  return null;
}

// ── Mouse events ─────────────────────────────────────────────
C.addEventListener('mousedown', e => {
  const w = toWorld(e.clientX, e.clientY);
  const n = hitNode(w.x, w.y);
  if (n) {
    dragging = n;
    dragOffX = w.x - n.x;
    dragOffY = w.y - n.y;
    C.style.cursor = 'grabbing';
  }
});

C.addEventListener('mousemove', e => {
  const w = toWorld(e.clientX, e.clientY);
  if (dragging) {
    dragging.x = w.x - dragOffX;
    dragging.y = w.y - dragOffY;
    draw();
    return;
  }
  const n = hitNode(w.x, w.y);
  const newHover = n ? n.id : null;
  if (newHover !== hoverId) {
    hoverId = newHover;
    draw();
  }
  if (n) {
    TT.style.display = 'block';
    TT.style.left = (e.clientX+14)+'px';
    TT.style.top  = (e.clientY-10)+'px';
    TT.textContent = n.label + (n.type==='shared'?' ⟷ cross-section':'');
    C.style.cursor = 'pointer';
  } else {
    TT.style.display = 'none';
    C.style.cursor = 'grab';
  }
});

C.addEventListener('mouseup', e => {
  if (dragging) {
    const w = toWorld(e.clientX, e.clientY);
    const moved = Math.abs(w.x-dragging.x-dragOffX)+Math.abs(w.y-dragging.y-dragOffY) < 4;
    if (moved) {
      pinnedId = (pinnedId===dragging.id) ? null : dragging.id;
      draw();
    }
    dragging = null;
    C.style.cursor = 'grab';
  }
});

C.addEventListener('mouseleave', () => {
  dragging = null; hoverId = null;
  TT.style.display = 'none';
  draw();
});

// wheel zoom
C.addEventListener('wheel', e => {
  e.preventDefault();
  const rect = C.getBoundingClientRect();
  const mx = e.clientX - rect.left, my = e.clientY - rect.top;
  const delta = e.deltaY > 0 ? 0.9 : 1.1;
  offsetX = mx - (mx - offsetX)*delta;
  offsetY = my - (my - offsetY)*delta;
  scale *= delta;
  scale = Math.max(0.3, Math.min(3, scale));
  draw();
}, {passive:false});

// ── Public controls ──────────────────────────────────────────
window.stReset = function() {
  scale=1; offsetX=0; offsetY=0; pinnedId=null; hoverId=null;
  nodes.forEach(n => { const orig = RAW_NODES.find(r=>r.id===n.id); if(orig){n.x=orig.x;n.y=orig.y;} });
  layoutNodes(C.width, C.height);
  draw();
};
window.stFitAll = function() {
  let minX=Infinity,maxX=-Infinity,minY=Infinity,maxY=-Infinity;
  nodes.forEach(n=>{minX=Math.min(minX,n.x-n.size);maxX=Math.max(maxX,n.x+n.size);minY=Math.min(minY,n.y-n.size);maxY=Math.max(maxY,n.y+n.size);});
  const pad=40, W=C.width, H=C.height;
  const sx=(W-pad*2)/(maxX-minX), sy=(H-pad*2)/(maxY-minY);
  scale=Math.min(sx,sy,2);
  offsetX=pad-minX*scale; offsetY=pad-minY*scale;
  draw();
};
window.stToggleLabels = function() { showLabels=!showLabels; draw(); };

// ── Init ─────────────────────────────────────────────────────
window.addEventListener('resize', ()=>{ resize(); layoutNodes(C.width,C.height); draw(); });
init();
setTimeout(stFitAll, 80);

})();
// ─────────────────────────────────────────────────────────────
</script>

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
