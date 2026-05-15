@extends('layouts.academic')
@section('title', 'Academic Staff')
@section('heading', 'Academic Staff')

@section('header-actions')
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ Assign Staff</button>
@endsection

@section('content')
@php
$staff = [
    ['id'=>1,'name'=>'Dr. Sarah Mitchell','email'=>'s.mitchell@uni.edu','dept'=>'Computer Science','org'=>'Faculty of Engineering','manager'=>true,'status'=>'Active'],
    ['id'=>2,'name'=>'Prof. James Okafor','email'=>'j.okafor@uni.edu','dept'=>'Mathematics','org'=>'Faculty of Science','manager'=>false,'status'=>'Active'],
    ['id'=>3,'name'=>'Dr. Priya Nair','email'=>'p.nair@uni.edu','dept'=>'Physics','org'=>'Faculty of Science','manager'=>true,'status'=>'Active'],
    ['id'=>4,'name'=>'Mr. Tom Hargreaves','email'=>'t.hargreaves@uni.edu','dept'=>'Software Engineering','org'=>'Faculty of Engineering','manager'=>false,'status'=>'Inactive'],
    ['id'=>5,'name'=>'Dr. Amina Yusuf','email'=>'a.yusuf@uni.edu','dept'=>'Data Science','org'=>'Faculty of Engineering','manager'=>false,'status'=>'Active'],
];
@endphp

<div style="display:flex;gap:20px;align-items:flex-start;">

{{-- Left Tips --}}
<div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
    <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
        <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 Academic Staff</div>
        <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">Academic staff are employees assigned to teach or manage subjects within a department.</p>
        <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">A <strong style="color:#fff;">Manager</strong> can oversee scheduling for their department.</p>
    </div>
    <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
        <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
        @php
            $active   = count(array_filter($staff, fn($s) => $s['status']==='Active'));
            $managers = count(array_filter($staff, fn($s) => $s['manager']));
            $depts    = count(array_unique(array_column($staff,'dept')));
        @endphp
        @foreach([['Total Staff',count($staff),'#4f46e5'],['Active',$active,'#10b981'],['Managers',$managers,'#0ea5e9'],['Departments',$depts,'#f59e0b']] as [$l,$v,$c])
        <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
            <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
        </div>
        @endforeach
    </div>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
        <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Tip</div>
        <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;">Assign staff to departments before creating timetable slots. Only active staff appear in the slot scheduler.</p>
    </div>
    <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:12px;padding:14px;">
        <div style="font-size:12px;font-weight:700;color:#854d0e;margin-bottom:6px;">⚠️ Note</div>
        <p style="font-size:11px;color:#92400e;line-height:1.6;margin:0;">Removing a staff member will not delete their existing timetable slots — only future scheduling is affected.</p>
    </div>
</div>

{{-- Right Table --}}
<div style="flex:1;">
<div class="card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:16px; font-weight:700; color:#1e1b4b;">{{ count($staff) }} Staff Assigned</span>
        <div style="display:flex;gap:10px;">
            <select class="form-select" style="width:170px;"><option>All Departments</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
            <input class="form-input" style="width:200px;" placeholder="Search staff…" type="text">
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Organisation</th>
                <th>Manager</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>
                    <div style="font-weight:600; font-size:13px;">{{ $s['name'] }}</div>
                    <div style="font-size:11px; color:#9ca3af;">{{ $s['email'] }}</div>
                </td>
                <td>{{ $s['dept'] }}</td>
                <td>{{ $s['org'] }}</td>
                <td>
                    @if($s['manager'])
                        <span class="badge badge-blue">Manager</span>
                    @else
                        <span class="badge badge-gray">Staff</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $s['status']==='Active' ? 'badge-green' : 'badge-red' }}">{{ $s['status'] }}</span>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button>
                        <button class="btn btn-danger btn-sm">Remove</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>{{-- end card --}}
</div>{{-- end right --}}
</div>{{-- end flex --}}

{{-- Add Modal --}}
<div id="modal-add" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Assign Academic Staff</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Organisation</label>
                <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
            </div>
            <div>
                <label class="form-label">Employee</label>
                <select class="form-select"><option>Select employee…</option><option>Dr. Linda Chow</option><option>Mr. Kevin Patel</option></select>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="is-manager" style="width:15px;height:15px;">
                <label for="is-manager" style="font-size:13px;">Assign as Manager</label>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Assign</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Staff Assignment</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Staff Member</label>
                <input class="form-input" value="Dr. Sarah Mitchell" readonly style="background:#f9fafb;">
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="edit-manager" checked style="width:15px;height:15px;">
                <label for="edit-manager" style="font-size:13px;">Manager</label>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select class="form-select"><option>Active</option><option>Inactive</option></select>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
@endsection
