@extends('layouts.academic')
@section('title','Departments')
@section('heading','Departments')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Department</button>
@endsection
@section('content')
@php
$depts = [
    ['id'=>1,'code'=>'CS',  'name'=>'Computer Science',    'faculty'=>'Faculty of Engineering','hod'=>'Dr. Sarah Mitchell','staff'=>5,'courses'=>2,'status'=>'Active'],
    ['id'=>2,'code'=>'MATH','name'=>'Mathematics',          'faculty'=>'Faculty of Science',   'hod'=>'Prof. James Okafor','staff'=>3,'courses'=>1,'status'=>'Active'],
    ['id'=>3,'code'=>'PHY', 'name'=>'Physics',              'faculty'=>'Faculty of Science',   'hod'=>'Dr. Priya Nair',    'staff'=>4,'courses'=>1,'status'=>'Active'],
    ['id'=>4,'code'=>'DS',  'name'=>'Data Science',         'faculty'=>'Faculty of Engineering','hod'=>'Dr. Amina Yusuf', 'staff'=>3,'courses'=>1,'status'=>'Active'],
    ['id'=>5,'code'=>'SWE', 'name'=>'Software Engineering', 'faculty'=>'Faculty of Engineering','hod'=>'—',               'staff'=>2,'courses'=>2,'status'=>'Inactive'],
];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 What is a Department?</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Department</strong> is an academic unit within a Faculty — e.g. <em>Computer Science</em> under <em>Faculty of Engineering</em>.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Departments own <strong style="color:#fff;">Courses</strong>, <strong style="color:#fff;">Staff</strong> and <strong style="color:#fff;">Semesters</strong>.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @foreach([['Total',count($depts),'#4f46e5'],['Active',count(array_filter($depts,fn($d)=>$d['status']==='Active')),'#10b981'],['Inactive',count(array_filter($depts,fn($d)=>$d['status']==='Inactive')),'#ef4444']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Start Here</div>
            <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;">Create <strong>Departments</strong> first. Then add <strong>Courses</strong> and <strong>Subjects</strong> under each department.</p>
        </div>
    </div>
    {{-- Table --}}
    <div style="flex:1;">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($depts) }} Departments</span>
                <input class="form-input" style="width:220px;" placeholder="Search departments…" type="text">
            </div>
            <table>
                <thead><tr><th>Code</th><th>Department Name</th><th>Faculty</th><th>Head of Dept</th><th>Staff</th><th>Courses</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($depts as $d)
                <tr>
                    <td style="font-weight:800;font-family:monospace;color:#4f46e5;">{{ $d['code'] }}</td>
                    <td style="font-weight:700;color:#1e293b;">{{ $d['name'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $d['faculty'] }}</td>
                    <td style="font-size:12px;">{{ $d['hod'] }}</td>
                    <td style="font-weight:700;color:#0ea5e9;">{{ $d['staff'] }}</td>
                    <td style="font-weight:700;color:#f59e0b;">{{ $d['courses'] }}</td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $d['status']==='Active'?'#d1fae5':'#fee2e2' }};color:{{ $d['status']==='Active'?'#065f46':'#991b1b' }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $d['status']==='Active'?'#10b981':'#ef4444' }};display:inline-block;"></span>{{ $d['status'] }}</span></td>
                    <td><div style="display:flex;gap:6px;"><button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button><button class="btn btn-danger btn-sm">Delete</button></div></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Add --}}
<div id="modal-add" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">🏛️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Department</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Faculty / Organisation <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select></div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Dept Code <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. CS" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Department Name <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. Computer Science"></div>
        </div>
        <div><label class="form-label">Head of Department</label><select class="form-select"><option>— Select Staff —</option><option>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option><option>Dr. Priya Nair</option></select></div>
        <div><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Create Department</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Department</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Dept Code</label><input class="form-input" value="CS" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Department Name</label><input class="form-input" value="Computer Science"></div>
        </div>
        <div><label class="form-label">Head of Department</label><select class="form-select"><option selected>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option></select></div>
        <div><label class="form-label">Status</label><select class="form-select"><option selected>Active</option><option>Inactive</option></select></div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
