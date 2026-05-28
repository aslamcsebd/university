@extends('layouts.academic')
@section('title', 'Roles & Permissions')
@section('heading', 'Roles & Permissions')
@section('header-actions')
    <button onclick="openModal('modal-add-role')" class="btn btn-primary">+ Add Role</button>
@endsection
@section('content')
@php
$roles = [
    ['id'=>1,'name'=>'Super Admin','color'=>'#ef4444','bg'=>'#fee2e2','users'=>1,  'desc'=>'Full system access'],
    ['id'=>2,'name'=>'Admin',      'color'=>'#f59e0b','bg'=>'#fef3c7','users'=>3,  'desc'=>'Manage all modules'],
    ['id'=>3,'name'=>'Teacher',    'color'=>'#6366f1','bg'=>'#eef2ff','users'=>24, 'desc'=>'Academic & class management'],
    ['id'=>4,'name'=>'Accountant', 'color'=>'#10b981','bg'=>'#d1fae5','users'=>2,  'desc'=>'Finance & fees management'],
    ['id'=>5,'name'=>'Librarian',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','users'=>1,  'desc'=>'Library management'],
    ['id'=>6,'name'=>'Student',    'color'=>'#8b5cf6','bg'=>'#f5f3ff','users'=>153,'desc'=>'Student panel only'],
];

$modules = [
    '🏛️ Academic' => [
        'Departments'    => ['View','Create','Edit','Delete'],
        'Courses'        => ['View','Create','Edit','Delete'],
        'Subjects'       => ['View','Create','Edit','Delete'],
        'Semesters'      => ['View','Create','Edit','Delete'],
        'Faculties'      => ['View','Create','Edit','Delete'],
        'Programs'       => ['View','Create','Edit','Delete'],
        'Batches'        => ['View','Create','Edit','Delete'],
        'Sessions'       => ['View','Create','Edit','Delete'],
        'Sections'       => ['View','Create','Edit','Delete'],
        'Class Rooms'    => ['View','Create','Edit','Delete'],
        'Enroll Courses' => ['View','Create','Edit','Delete'],
    ],
    '🗓️ Timetable' => [
        'Timetable'              => ['View','Create','Edit','Delete'],
        'Manage Classes'         => ['View','Create','Edit','Delete'],
        'Class Schedules'        => ['View','Create','Edit','Delete'],
        'Manage Exams'           => ['View','Create','Edit','Delete'],
        'Exam Schedules'         => ['View','Create','Edit','Delete'],
        'Teacher Routines'       => ['View'],
        'Class Schedule Setting' => ['View','Edit'],
        'Exam Schedule Setting'  => ['View','Edit'],
    ],
    '📝 Examinations' => [
        'Exam Attendances'   => ['View','Create','Edit','Delete'],
        'Exam Mark Ledger'   => ['View','Create','Edit','Delete'],
        'Exam Results'       => ['View','Create','Edit','Delete'],
        'Course Mark Ledger' => ['View','Create','Edit','Delete'],
        'Course Results'     => ['View','Create','Edit','Delete'],
        'Grading Systems'    => ['View','Create','Edit','Delete'],
        'Exam Types'         => ['View','Create','Edit','Delete'],
        'Admit Cards'        => ['View','Create','Edit','Delete'],
        'Admit Setting'      => ['View','Edit'],
        'Mark Distribution'  => ['View','Create','Edit','Delete'],
    ],
    '🧑🎓 Students' => [
        'Applications'       => ['View','Create','Edit','Delete','Approve'],
        'New Registration'   => ['View','Create','Edit','Delete'],
        'Student List'       => ['View','Create','Edit','Delete'],
        'Transfer In'        => ['View','Create','Edit','Delete'],
        'Transfer Out'       => ['View','Create','Edit','Delete'],
        'Status Types'       => ['View','Create','Edit','Delete'],
        'ID Cards'           => ['View','Print'],
        'ID Card Setting'    => ['View','Edit'],
        'Attendances'        => ['View','Create','Edit','Delete'],
        'Subject Attendances'=> ['View','Create','Edit','Delete'],
        'Attendance Reports' => ['View','Export'],
        'Manage Leave'       => ['View','Create','Edit','Delete','Approve'],
        'Student Notes'      => ['View','Create','Edit','Delete'],
        'Alumni List'        => ['View','Create','Edit','Delete'],
        'Single Enroll'      => ['View','Create','Edit','Delete'],
        'Group Enrolls'      => ['View','Create','Edit','Delete'],
        'Course Add Drop'    => ['View','Create','Edit','Delete','Approve'],
        'Course Graduation'  => ['View','Create','Edit','Delete'],
    ],
    '📖 Study Materials' => [
        'Assignments'   => ['View','Create','Edit','Delete'],
        'Content List'  => ['View','Create','Edit','Delete'],
        'Content Types' => ['View','Create','Edit','Delete'],
        'Downloads'     => ['View','Create','Edit','Delete'],
    ],
    '👥 Staff' => [
        'Staff'              => ['View','Create','Edit','Delete'],
        'Staff List'         => ['View','Create','Edit','Delete'],
        'Staff Notes'        => ['View','Create','Edit','Delete'],
        'Payrolls'           => ['View','Create','Edit','Delete'],
        'Payroll Reports'    => ['View','Export'],
        'Work Shift Types'   => ['View','Create','Edit','Delete'],
        'Designations'       => ['View','Create','Edit','Delete'],
        'Departments'        => ['View','Create','Edit','Delete'],
        'Tax Settings'       => ['View','Edit'],
        'Pay Slip Setting'   => ['View','Edit'],
        'Daily Attendances'  => ['View','Create','Edit','Delete'],
        'Daily Reports'      => ['View','Export'],
        'Hourly Attendances' => ['View','Create','Edit','Delete'],
        'Hourly Reports'     => ['View','Export'],
        'Apply Leave'        => ['View','Create','Edit','Delete'],
        'My Leaves'          => ['View'],
        'Leave Types'        => ['View','Create','Edit','Delete'],
        'Manage Leave'       => ['View','Edit','Approve','Delete'],
    ],
    '🏢 Facilities' => [
        'Buildings'          => ['View','Create','Edit','Delete'],
        'Rooms'              => ['View','Create','Edit','Delete'],
        'Hostel List'        => ['View','Create','Edit','Delete'],
        'Hostel Rooms'       => ['View','Create','Edit','Delete'],
        'Room Types'         => ['View','Create','Edit','Delete'],
        'Hostel Students'    => ['View','Create','Edit','Delete'],
        'Hostel Staff'       => ['View','Create','Edit','Delete'],
        'Vehicles'           => ['View','Create','Edit','Delete'],
        'Routes'             => ['View','Create','Edit','Delete'],
        'Transport Students' => ['View','Create','Edit','Delete'],
        'Transport Staff'    => ['View','Create','Edit','Delete'],
    ],
    '💳 Finance' => [
        'Fees Due'           => ['View','Create','Edit','Delete'],
        'Quick Assign'       => ['View','Create'],
        'Quick Received'     => ['View','Create'],
        'Fees Reports'       => ['View','Export'],
        'Assign Group Fees'  => ['View','Create','Edit','Delete'],
        'Assigned History'   => ['View'],
        'Fees Types'         => ['View','Create','Edit','Delete'],
        'Fees Discounts'     => ['View','Create','Edit','Delete'],
        'Fees Fines'         => ['View','Create','Edit','Delete'],
        'Receipt Setting'    => ['View','Edit'],
        'Income List'        => ['View','Create','Edit','Delete'],
        'Income Categories'  => ['View','Create','Edit','Delete'],
        'Expense List'       => ['View','Create','Edit','Delete'],
        'Expense Categories' => ['View','Create','Edit','Delete'],
        'Outcome Overview'   => ['View','Export'],
    ],
    '📚 Library' => [
        'Issue Book'       => ['View','Create','Edit','Delete'],
        'Issue & Return'   => ['View','Create','Edit'],
        'Book List'        => ['View','Create','Edit','Delete'],
        'Book Requests'    => ['View','Approve','Delete'],
        'Book Categories'  => ['View','Create','Edit','Delete'],
        'Book Return Due'  => ['View','Export'],
        'Student Members'  => ['View','Create','Edit','Delete'],
        'Staff Members'    => ['View','Create','Edit','Delete'],
        'Outsider Members' => ['View','Create','Edit','Delete'],
        'Card Setting'     => ['View','Edit'],
    ],
    '📦 Inventory' => [
        'Issue Item'     => ['View','Create','Edit','Delete'],
        'Issue & Return' => ['View','Create','Edit'],
        'Item Stocks'    => ['View','Create','Edit','Delete'],
        'Item List'      => ['View','Create','Edit','Delete'],
        'Stores'         => ['View','Create','Edit','Delete'],
        'Suppliers'      => ['View','Create','Edit','Delete'],
        'Categories'     => ['View','Create','Edit','Delete'],
    ],
    '🖥️ Front Desk' => [
        'Visitor Logs'       => ['View','Create','Edit','Delete'],
        'Phone Logs'         => ['View','Create','Edit','Delete'],
        'Enquiry List'       => ['View','Create','Edit','Delete'],
        'Complain List'      => ['View','Create','Edit','Delete'],
        'Postal Exchanges'   => ['View','Create','Edit','Delete'],
        'Meeting Schedules'  => ['View','Create','Edit','Delete'],
        'Visit Purposes'     => ['View','Create','Edit','Delete'],
        'Token Settings'     => ['View','Edit'],
        'Enquiry Sources'    => ['View','Create','Edit','Delete'],
        'Enquiry References' => ['View','Create','Edit','Delete'],
        'Complain Types'     => ['View','Create','Edit','Delete'],
        'Complain Sources'   => ['View','Create','Edit','Delete'],
        'Postal Types'       => ['View','Create','Edit','Delete'],
        'Meeting Types'      => ['View','Create','Edit','Delete'],
    ],
    '🎖️ Transcripts' => [
        'Semester Marksheets'   => ['View','Export'],
        'Total Marksheets'      => ['View','Export'],
        'Marksheet Setting'     => ['View','Edit'],
        'Certificates'          => ['View','Create','Edit','Delete','Print'],
        'Certificate Templates' => ['View','Create','Edit','Delete'],
    ],
    '📊 Reports' => [
        'Student Progress'   => ['View','Export'],
        'Course Students'    => ['View','Export'],
        'Student Attendance' => ['View','Export'],
        'Subject Attendance' => ['View','Export'],
        'Collected Fees'     => ['View','Export'],
        'Student Fees'       => ['View','Export'],
        'Salary Paid'        => ['View','Export'],
        'Staff Leaves'       => ['View','Export'],
        'Total Income'       => ['View','Export'],
        'Total Expense'      => ['View','Export'],
        'Library History'    => ['View','Export'],
        'Book Return Due'    => ['View','Export'],
        'Inventory History'  => ['View','Export'],
        'Hostel Members'     => ['View','Export'],
        'Transport Members'  => ['View','Export'],
    ],
    '📢 Communicate' => [
        'Send Email'        => ['View','Create'],
        'Send SMS'          => ['View','Create'],
        'Event List'        => ['View','Create','Edit','Delete'],
        'Calendar'          => ['View','Create','Edit','Delete'],
        'Notice List'       => ['View','Create','Edit','Delete'],
        'Notice Categories' => ['View','Create','Edit','Delete'],
    ],
    '🌐 Front Web' => [
        'Contact Setting' => ['View','Edit'],
        'Social Setting'  => ['View','Edit'],
        'Sliders'         => ['View','Create','Edit','Delete'],
        'About Us'        => ['View','Edit'],
        'Features'        => ['View','Create','Edit','Delete'],
        'Courses'         => ['View','Create','Edit','Delete'],
        'Event'           => ['View','Create','Edit','Delete'],
        'News'            => ['View','Create','Edit','Delete'],
        'Faqs'            => ['View','Create','Edit','Delete'],
        'Gallery'         => ['View','Create','Edit','Delete'],
        'Testimonials'    => ['View','Create','Edit','Delete'],
        'Footer Pages'    => ['View','Create','Edit','Delete'],
        'Call To Action'  => ['View','Edit'],
    ],
    '⚙️ Settings' => [
        'General'             => ['View','Edit'],
        'States/Provinces'    => ['View','Create','Edit','Delete'],
        'Districts/Cities'    => ['View','Create','Edit','Delete'],
        'Languages'           => ['View','Create','Edit','Delete'],
        'Mail Setting'        => ['View','Edit'],
        'SMS Getaways'        => ['View','Edit'],
        'Payment Getaways'    => ['View','Edit'],
        'Online Application'  => ['View','Edit'],
        'Roles & Permissions' => ['View','Create','Edit','Delete'],
        'Staffs Fields'       => ['View','Create','Edit','Delete'],
        'Students Fields'     => ['View','Create','Edit','Delete'],
        'Applications Fields' => ['View','Create','Edit','Delete'],
        'Student Panel'       => ['View','Edit'],
    ],
    '👨🏫 Teacher Panel' => [
        'Dashboard'       => ['View'],
        'My Classes'      => ['View'],
        'Class Schedules' => ['View'],
        'Exam Schedules'  => ['View'],
        'Mark Entry'      => ['View','Create','Edit'],
        'Attendance'      => ['View','Create','Edit'],
        'Assignments'     => ['View','Create','Edit','Delete'],
        'Apply Leave'     => ['View','Create'],
        'My Leaves'       => ['View'],
        'My Profile'      => ['View','Edit'],
    ],
    '🎓 Student Panel' => [
        'Dashboard'       => ['View'],
        'Class Schedules' => ['View'],
        'Exam Schedules'  => ['View'],
        'Attendances'     => ['View'],
        'Apply Leaves'    => ['View','Create'],
        'Fees Reports'    => ['View'],
        'Library'         => ['View'],
        'Notices'         => ['View'],
        'Assignments'     => ['View'],
        'Downloads'       => ['View'],
        'Transcript'      => ['View'],
        'My Profile'      => ['View','Edit'],
    ],
];

$actionColors = [
    'View'   => ['bg'=>'#eff6ff','color'=>'#1d4ed8','border'=>'#bfdbfe'],
    'Create' => ['bg'=>'#f0fdf4','color'=>'#15803d','border'=>'#bbf7d0'],
    'Edit'   => ['bg'=>'#fffbeb','color'=>'#b45309','border'=>'#fde68a'],
    'Delete' => ['bg'=>'#fef2f2','color'=>'#b91c1c','border'=>'#fecaca'],
    'Export' => ['bg'=>'#f5f3ff','color'=>'#6d28d9','border'=>'#ddd6fe'],
    'Print'  => ['bg'=>'#f0f9ff','color'=>'#0369a1','border'=>'#bae6fd'],
    'Approve'=> ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#a7f3d0'],
];

$moduleKeys = array_keys($modules);
@endphp

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px;">

    {{-- Left: Roles List --}}
    <div style="display:flex;flex-direction:column;gap:10px;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:0 4px;">Roles ({{ count($roles) }})</div>
        @foreach($roles as $r)
        <button onclick="showRole({{ $r['id'] }})"
            id="role-btn-{{ $r['id'] }}"
            style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:#fff;border:2px solid {{ $r['id']===1 ? $r['color'] : '#e5e7eb' }};border-radius:10px;cursor:pointer;text-align:left;transition:all .15s;width:100%;">
            <div style="width:38px;height:38px;border-radius:9px;background:{{ $r['bg'] }};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:{{ $r['color'] }};flex-shrink:0;">{{ substr($r['name'],0,2) }}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $r['name'] }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:1px;">{{ $r['users'] }} users · {{ $r['desc'] }}</div>
            </div>
        </button>
        @endforeach
        <button onclick="openModal('modal-add-role')" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:#f8fafc;border:2px dashed #d1d5db;border-radius:10px;cursor:pointer;font-size:13px;font-weight:600;color:#64748b;width:100%;">
            + Add New Role
        </button>
    </div>

    {{-- Right: Permission Matrix --}}
    <div class="card" style="padding:0;overflow:hidden;min-width:0;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div>
                <div style="font-size:15px;font-weight:800;color:#1e1b4b;" id="perm-title">Super Admin — Permissions</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;" id="perm-desc">Full access to all modules and features</div>
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="toggleAll(true)"  class="btn btn-secondary btn-sm">✅ Select All</button>
                <button onclick="toggleAll(false)" class="btn btn-secondary btn-sm">❌ Clear All</button>
                <button class="btn btn-primary btn-sm">💾 Save</button>
            </div>
        </div>

        <div style="padding:20px;display:flex;flex-direction:column;gap:8px;" id="perm-body">
            @foreach($modules as $module => $pages)
            @php $moduleSlug = Str::slug($module); $isFirst = $loop->first; @endphp
            <div style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                {{-- Accordion Header --}}
                <div onclick="toggleAccordion('{{ $moduleSlug }}')"
                    style="display:flex;align-items:center;justify-content:space-between;padding:11px 16px;background:whitesmoke;cursor:pointer;user-select:none;border-bottom:1px solid #e5e7eb;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <label onclick="event.stopPropagation()" style="display:flex;align-items:center;gap:7px;cursor:pointer;">
                            <input type="checkbox" class="module-check" data-module="{{ $moduleSlug }}" checked
                                onchange="toggleModule('{{ $moduleSlug }}', this.checked)"
                                style="width:14px;height:14px;accent-color:#6366f1;">
                        </label>
                        <span style="font-size:13px;font-weight:700;color:#1e1b4b;">{{ $module }}</span>
                        <span style="font-size:10px;color:#6366f1;background:#eef2ff;padding:1px 7px;border-radius:9px;">{{ count($pages) }} pages</span>
                    </div>
                    <span id="arr-{{ $moduleSlug }}" style="color:#6366f1;font-size:12px;transition:transform .25s;display:inline-block;{{ $isFirst ? 'transform:rotate(180deg)' : '' }}">▼</span>
                </div>

                {{-- Accordion Body --}}
                <div id="acc-{{ $moduleSlug }}" style="{{ $isFirst ? '' : 'display:none;' }}">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="padding:8px 16px;font-size:11px;font-weight:700;color:#1e1b4b;text-align:left;border-bottom:1px solid #e5e7eb;width:200px;background:whitesmoke !important;">Page</th>
                                <th style="padding:8px 16px;font-size:11px;font-weight:700;color:#1e1b4b;text-align:left;border-bottom:1px solid #e5e7eb;background:whitesmoke !important;">Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page => $actions)
                            @php $pageSlug = $moduleSlug . '-' . Str::slug($page); @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">
                                <td style="padding:10px 16px;font-size:12px;font-weight:600;color:#374151;white-space:nowrap;">
                                    <label style="display:flex;align-items:center;gap:7px;cursor:pointer;">
                                        <input type="checkbox" class="page-check module-{{ $moduleSlug }}" data-page="{{ $pageSlug }}" checked
                                            onchange="togglePage('{{ $pageSlug }}', this.checked)"
                                            style="width:13px;height:13px;accent-color:#6366f1;">
                                        {{ $page }}
                                    </label>
                                </td>
                                <td style="padding:8px 16px;">
                                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                        @foreach($actions as $action)
                                        @php $ac = $actionColors[$action] ?? ['bg'=>'#f1f5f9','color'=>'#374151','border'=>'#e5e7eb']; @endphp
                                        <label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:11px;font-weight:600;color:{{ $ac['color'] }};background:{{ $ac['bg'] }};padding:3px 9px;border-radius:5px;border:1px solid {{ $ac['border'] }};">
                                            <input type="checkbox" class="perm-check perm-{{ $pageSlug }}" checked
                                                style="width:12px;height:12px;accent-color:#6366f1;">
                                            {{ $action }}
                                        </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Add Role Modal --}}
<div id="modal-add-role" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">+ Add New Role</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div><label class="form-label">Role Name</label><input class="form-input" placeholder="e.g. Accountant"></div>
            <div><label class="form-label">Description</label><input class="form-input" placeholder="Brief description of this role"></div>
            <div><label class="form-label">Color</label>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach(['#ef4444','#f59e0b','#10b981','#6366f1','#0ea5e9','#8b5cf6','#ec4899','#64748b'] as $c)
                    <label style="cursor:pointer;">
                        <input type="radio" name="role_color" value="{{ $c }}" style="display:none;">
                        <div style="width:28px;height:28px;border-radius:50%;background:{{ $c }};border:3px solid transparent;" onclick="this.style.border='3px solid #1e1b4b'"></div>
                    </label>
                    @endforeach
                </div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">Create Role</button>
            </div>
        </div>
    </div>
</div>

<script>
const roles = @json($roles);

function toggleAccordion(slug) {
    const body = document.getElementById('acc-' + slug);
    const arr  = document.getElementById('arr-' + slug);
    const open = body.style.display !== 'none';
    body.style.display = open ? 'none' : '';
    arr.style.transform = open ? '' : 'rotate(180deg)';
}

function showRole(id) {
    roles.forEach(r => {
        const btn = document.getElementById('role-btn-' + r.id);
        btn.style.borderColor = r.id === id ? r.color : '#e5e7eb';
        btn.style.background  = r.id === id ? r.bg : '#fff';
    });
    const role = roles.find(r => r.id === id);
    document.getElementById('perm-title').textContent = role.name + ' — Permissions';
    document.getElementById('perm-desc').textContent  = role.desc;
}

function toggleModule(moduleSlug, checked) {
    document.querySelectorAll('.module-' + moduleSlug).forEach(cb => {
        cb.checked = checked;
        togglePage(cb.dataset.page, checked);
    });
}

function togglePage(pageSlug, checked) {
    document.querySelectorAll('.perm-' + pageSlug).forEach(cb => cb.checked = checked);
}

function toggleAll(checked) {
    document.querySelectorAll('.perm-check, .page-check, .module-check').forEach(cb => cb.checked = checked);
}

showRole(1);
</script>
@endsection
