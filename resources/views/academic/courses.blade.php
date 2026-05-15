@extends('layouts.academic')
@section('title','Courses / Programmes')
@section('heading','Courses / Programmes')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Course</button>
@endsection
@section('content')
@php
$courses = [
    ['id'=>1,'code'=>'BCS',  'name'=>'Bachelor of Computer Science',    'dept'=>'Computer Science',    'level'=>'Degree', 'duration'=>'3 Years','subjects'=>4,'status'=>'Active'],
    ['id'=>2,'code'=>'DCS',  'name'=>'Diploma in Computer Science',     'dept'=>'Computer Science',    'level'=>'Diploma','duration'=>'2 Years','subjects'=>3,'status'=>'Active'],
    ['id'=>3,'code'=>'BMATH','name'=>'Bachelor of Mathematics',         'dept'=>'Mathematics',         'level'=>'Degree', 'duration'=>'3 Years','subjects'=>2,'status'=>'Active'],
    ['id'=>4,'code'=>'BPHY', 'name'=>'Bachelor of Physics',             'dept'=>'Physics',             'level'=>'Degree', 'duration'=>'3 Years','subjects'=>2,'status'=>'Active'],
    ['id'=>5,'code'=>'MDS',  'name'=>'Master of Data Science',          'dept'=>'Data Science',        'level'=>'Masters','duration'=>'2 Years','subjects'=>2,'status'=>'Active'],
    ['id'=>6,'code'=>'BSWE', 'name'=>'Bachelor of Software Engineering','dept'=>'Software Engineering','level'=>'Degree', 'duration'=>'4 Years','subjects'=>0,'status'=>'Active'],
    ['id'=>7,'code'=>'DSE',  'name'=>'Diploma in Software Engineering', 'dept'=>'Software Engineering','level'=>'Diploma','duration'=>'2 Years','subjects'=>0,'status'=>'Inactive'],
];
$levelStyle=['Degree'=>['#eef2ff','#4338ca'],'Diploma'=>['#fef9c3','#854d0e'],'Masters'=>['#f3e8ff','#6b21a8'],'PhD'=>['#fee2e2','#991b1b']];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 What is a Course?</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Course</strong> is a full academic programme — e.g. <em>Bachelor of Computer Science</em>.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Each course belongs to a <strong style="color:#fff;">Department</strong> and contains multiple <strong style="color:#fff;">Subjects</strong>.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @php $total=count($courses);$active=count(array_filter($courses,fn($c)=>$c['status']==='Active')); @endphp
            @foreach([['Total',$total,'#4f46e5'],['Active',$active,'#10b981'],['Inactive',$total-$active,'#ef4444']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Flow</div>
            <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;"><strong>Department</strong> → <strong>Course</strong> → <strong>Subjects</strong> → <strong>Semester</strong></p>
        </div>
    </div>
    {{-- Table --}}
    <div style="flex:1;">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($courses) }} Courses</span>
                <div style="display:flex;gap:10px;">
                    <select class="form-select" style="width:170px;"><option>All Departments</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
                    <select class="form-select" style="width:120px;"><option>All Levels</option><option>Degree</option><option>Diploma</option><option>Masters</option></select>
                    <input class="form-input" style="width:180px;" placeholder="Search…" type="text">
                </div>
            </div>
            <table>
                <thead><tr><th>Code</th><th>Programme Name</th><th>Department</th><th>Level</th><th>Duration</th><th>Subjects</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($courses as $c)
                @php [$bg,$tc]=$levelStyle[$c['level']]??['#f1f5f9','#475569']; @endphp
                <tr>
                    <td style="font-weight:800;font-family:monospace;color:#4f46e5;">{{ $c['code'] }}</td>
                    <td style="font-weight:700;color:#1e293b;">{{ $c['name'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $c['dept'] }}</td>
                    <td><span style="background:{{ $bg }};color:{{ $tc }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:9999px;">{{ $c['level'] }}</span></td>
                    <td style="font-size:12px;color:#64748b;">{{ $c['duration'] }}</td>
                    <td><a href="/academic/subjects" style="font-weight:700;color:#4f46e5;text-decoration:none;">{{ $c['subjects'] }} <span style="font-size:11px;color:#94a3b8;font-weight:400;">subj.</span></a></td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $c['status']==='Active'?'#d1fae5':'#fee2e2' }};color:{{ $c['status']==='Active'?'#065f46':'#991b1b' }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $c['status']==='Active'?'#10b981':'#ef4444' }};display:inline-block;"></span>{{ $c['status'] }}</span></td>
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
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">🎓</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Course / Programme</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Faculty <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select></div>
            <div><label class="form-label">Department <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option><option>Software Engineering</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Course Code <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. BCS" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Programme Name <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. Bachelor of Computer Science"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Level</label><select class="form-select"><option>Degree</option><option>Diploma</option><option>Masters</option><option>PhD</option></select></div>
            <div><label class="form-label">Duration</label><select class="form-select"><option>1 Year</option><option>2 Years</option><option>3 Years</option><option>4 Years</option></select></div>
        </div>
        <div><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Create Course</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Course</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Course Code</label><input class="form-input" value="BCS" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Programme Name</label><input class="form-input" value="Bachelor of Computer Science"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Level</label><select class="form-select"><option selected>Degree</option><option>Diploma</option><option>Masters</option></select></div>
            <div><label class="form-label">Duration</label><select class="form-select"><option selected>3 Years</option><option>2 Years</option><option>4 Years</option></select></div>
        </div>
        <div><label class="form-label">Status</label><select class="form-select"><option selected>Active</option><option>Inactive</option></select></div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
