@extends('layouts.academic')
@section('title', 'Roles & Permissions')
@section('heading', 'Roles & Permissions')
@section('header-actions')
    <button onclick="openModal('modal-add-role')" class="btn btn-primary">+ Add Role</button>
@endsection
@section('content')
@php
$roles = [
    ['id'=>1,'name'=>'Super Admin','color'=>'#ef4444','bg'=>'#fee2e2','users'=>1, 'desc'=>'Full system access'],
    ['id'=>2,'name'=>'Admin',      'color'=>'#f59e0b','bg'=>'#fef3c7','users'=>3, 'desc'=>'Manage all modules'],
    ['id'=>3,'name'=>'Teacher',    'color'=>'#6366f1','bg'=>'#eef2ff','users'=>24,'desc'=>'Academic & class management'],
    ['id'=>4,'name'=>'Accountant', 'color'=>'#10b981','bg'=>'#d1fae5','users'=>2, 'desc'=>'Finance & fees management'],
    ['id'=>5,'name'=>'Librarian',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','users'=>1, 'desc'=>'Library management'],
    ['id'=>6,'name'=>'Student',    'color'=>'#8b5cf6','bg'=>'#f5f3ff','users'=>153,'desc'=>'Student panel only'],
];

$modules = [
    'Academic'      => ['Departments','Courses','Subjects','Semesters','Faculties','Programs','Batches','Sessions','Sections','Class Rooms','Enroll Courses'],
    'Timetable'     => ['Timetable','Manage Classes','Class Schedules','Manage Exams','Exam Schedules','Teacher Routines','Schedule Settings'],
    'Examinations'  => ['Exam Attendances','Exam Mark Ledger','Exam Results','Course Mark Ledger','Course Results','Grading Systems','Exam Types','Admit Cards','Mark Distribution'],
    'Students'      => ['Applications','New Registration','Student List','Transfer In/Out','ID Cards','Attendances','Manage Leave','Enrollments'],
    'Study Materials'=> ['Assignments','Content List','Downloads'],
    'Staff'         => ['Staff List','Payrolls','Designations','Departments','Attendances','Leave Management'],
    'Facilities'    => ['Buildings','Rooms','Hostels','Transport'],
    'Finance'       => ['Fees','Quick Assign','Fees Reports','Income','Expense'],
    'Library'       => ['Issue Book','Book List','Book Requests','Members'],
    'Inventory'     => ['Issue Item','Item Stocks','Item List','Stores','Suppliers'],
    'Front Desk'    => ['Visitor Logs','Phone Logs','Enquiry','Complain','Postal','Meetings'],
    'Transcripts'   => ['Semester Marksheets','Total Marksheets','Marksheet Setting','Certificates'],
    'Reports'       => ['Student Progress','Course Students','Attendance Reports','Fees Reports','Salary Reports','Library Reports'],
    'Communicate'   => ['Send Email','Send SMS','Events','Calendar','Notices'],
    'Front Web'     => ['Sliders','About Us','News','Gallery','Testimonials','Settings'],
    'Settings'      => ['General','Mail Setting','SMS','Payment','Roles & Permissions','Student Panel'],
    'Teacher Panel' => ['Dashboard','My Classes','Class Schedules','Exam Schedules','Mark Entry','Attendance','Assignments','Leave'],
    'Student Panel' => ['Dashboard','Class Schedules','Exam Schedules','Apply Leaves','Notices','Transcript','My Profile'],
];

$roleAccess = [
    1 => 'all',
    2 => ['Academic','Timetable','Examinations','Students','Study Materials','Staff','Facilities','Finance','Library','Inventory','Front Desk','Transcripts','Reports','Communicate','Front Web','Settings'],
    3 => ['Timetable','Examinations','Study Materials','Transcripts','Communicate','Teacher Panel'],
    4 => ['Finance','Reports'],
    5 => ['Library'],
    6 => ['Student Panel'],
];
@endphp

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px;">

    {{-- Left: Roles List --}}
    <div style="display:flex;flex-direction:column;gap:10px;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:0 4px;">Roles ({{ count($roles) }})</div>
        @foreach($roles as $r)
        <button onclick="showRole({{ $r['id'] }}, '{{ $r['name'] }}')"
            id="role-btn-{{ $r['id'] }}"
            style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:#fff;border:2px solid {{ $r['id']===1 ? $r['color'] : '#e5e7eb' }};border-radius:10px;cursor:pointer;text-align:left;transition:all .15s;width:100%;">
            <div style="width:38px;height:38px;border-radius:9px;background:{{ $r['bg'] }};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:{{ $r['color'] }};flex-shrink:0;">{{ substr($r['name'],0,2) }}</div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $r['name'] }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:1px;">{{ $r['users'] }} users · {{ $r['desc'] }}</div>
            </div>
            <span style="font-size:10px;padding:2px 8px;border-radius:20px;background:{{ $r['bg'] }};color:{{ $r['color'] }};font-weight:700;">
                {{ $roleAccess[$r['id']] === 'all' ? 'All' : count($roleAccess[$r['id']]) . ' modules' }}
            </span>
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

        <div style="padding:20px;display:flex;flex-direction:column;gap:16px;" id="perm-body">
            @foreach($modules as $module => $perms)
            <div style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;background:#f8fafc;border-bottom:1px solid #e5e7eb;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:700;color:#1e293b;">
                        <input type="checkbox" class="module-check" data-module="{{ $module }}" checked
                            onchange="toggleModule('{{ $module }}', this.checked)"
                            style="width:15px;height:15px;accent-color:#6366f1;">
                        {{ $module }}
                    </label>
                    <span style="font-size:11px;color:#94a3b8;">{{ count($perms) }} permissions</span>
                </div>
                <div style="padding:12px 16px;display:flex;flex-wrap:wrap;gap:10px;">
                    @foreach($perms as $perm)
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:12px;color:#374151;background:#f1f5f9;padding:5px 10px;border-radius:6px;border:1px solid #e5e7eb;">
                        <input type="checkbox" class="perm-check perm-{{ Str::slug($module) }}" checked
                            style="width:13px;height:13px;accent-color:#6366f1;">
                        {{ $perm }}
                    </label>
                    @endforeach
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
const roleData = {
    @foreach($roles as $r)
    {{ $r['id'] }}: {
        name: '{{ $r['name'] }}',
        desc: '{{ $r['desc'] }}',
        access: @if($roleAccess[$r['id']] === 'all') 'all' @else {{ json_encode($roleAccess[$r['id']]) }} @endif
    },
    @endforeach
};

function showRole(id, name) {
    document.querySelectorAll('[id^="role-btn-"]').forEach(btn => {
        btn.style.borderColor = '#e5e7eb';
    });
    document.getElementById('role-btn-' + id).style.borderColor = '#6366f1';

    const role = roleData[id];
    document.getElementById('perm-title').textContent = role.name + ' — Permissions';
    document.getElementById('perm-desc').textContent = role.desc;

    document.querySelectorAll('.perm-check, .module-check').forEach(cb => {
        cb.checked = role.access === 'all';
    });

    if (role.access !== 'all') {
        document.querySelectorAll('.module-check').forEach(cb => {
            const mod = cb.dataset.module;
            const allowed = role.access.includes(mod);
            cb.checked = allowed;
            document.querySelectorAll('.perm-' + mod.toLowerCase().replace(/[^a-z0-9]/g,'-')).forEach(p => {
                p.checked = allowed;
            });
        });
    }
}

function toggleModule(module, checked) {
    const slug = module.toLowerCase().replace(/[^a-z0-9]/g, '-');
    document.querySelectorAll('.perm-' + slug).forEach(cb => cb.checked = checked);
}

function toggleAll(checked) {
    document.querySelectorAll('.perm-check, .module-check').forEach(cb => cb.checked = checked);
}

showRole(1, 'Super Admin');
</script>
@endsection
