@extends('layouts.academic')
@section('title','Subjects / Modules')
@section('heading','Subjects / Modules')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Subject</button>
@endsection
@section('content')
@php
$subjects = [
    ['id'=>1,'course_id'=>1,'course'=>'Bachelor of Computer Science','dept'=>'Computer Science','code'=>'CS101','name'=>'Introduction to Programming','type'=>'Lecture','credits'=>3,'status'=>'Active'],
    ['id'=>2,'course_id'=>1,'course'=>'Bachelor of Computer Science','dept'=>'Computer Science','code'=>'CS201','name'=>'Data Structures & Algorithms','type'=>'Lecture','credits'=>4,'status'=>'Active'],
    ['id'=>3,'course_id'=>1,'course'=>'Bachelor of Computer Science','dept'=>'Computer Science','code'=>'CS301','name'=>'Database Systems','type'=>'Lab','credits'=>3,'status'=>'Active'],
    ['id'=>4,'course_id'=>1,'course'=>'Bachelor of Computer Science','dept'=>'Computer Science','code'=>'CS401','name'=>'Software Engineering','type'=>'Lecture','credits'=>4,'status'=>'Active'],
    ['id'=>5,'course_id'=>2,'course'=>'Diploma in Computer Science','dept'=>'Computer Science','code'=>'DCS101','name'=>'Web Development','type'=>'Lab','credits'=>3,'status'=>'Active'],
    ['id'=>6,'course_id'=>3,'course'=>'Bachelor of Mathematics','dept'=>'Mathematics','code'=>'MATH101','name'=>'Calculus I','type'=>'Lecture','credits'=>3,'status'=>'Active'],
    ['id'=>7,'course_id'=>3,'course'=>'Bachelor of Mathematics','dept'=>'Mathematics','code'=>'MATH201','name'=>'Linear Algebra','type'=>'Lecture','credits'=>3,'status'=>'Inactive'],
    ['id'=>8,'course_id'=>4,'course'=>'Bachelor of Physics','dept'=>'Physics','code'=>'PHY101','name'=>'Physics Fundamentals','type'=>'Lecture','credits'=>3,'status'=>'Active'],
    ['id'=>9,'course_id'=>4,'course'=>'Bachelor of Physics','dept'=>'Physics','code'=>'PHY201','name'=>'Physics Lab','type'=>'Lab','credits'=>2,'status'=>'Active'],
    ['id'=>10,'course_id'=>5,'course'=>'Master of Data Science','dept'=>'Data Science','code'=>'DS401','name'=>'Machine Learning','type'=>'Workshop','credits'=>4,'status'=>'Active'],
];
$typeStyle=['Lecture'=>['#dbeafe','#1e40af'],'Lab'=>['#fef9c3','#854d0e'],'Workshop'=>['#d1fae5','#065f46'],'Tutorial'=>['#f3f4f6','#374151']];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 What is a Subject?</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Subject / Module</strong> is a unit of study within a Course — e.g. <em>CS101 – Intro to Programming</em>.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Subjects are assigned to <strong style="color:#fff;">Semesters</strong> and scheduled on the <strong style="color:#fff;">Timetable</strong>.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @php $total=count($subjects);$active=count(array_filter($subjects,fn($s)=>$s['status']==='Active')); @endphp
            @foreach([['Total',$total,'#4f46e5'],['Active',$active,'#10b981'],['Inactive',$total-$active,'#ef4444'],['Courses',count(array_unique(array_column($subjects,'course_id'))),'#f59e0b']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ Tip</div>
            <p style="font-size:11px;color:#166534;line-height:1.6;margin:0;">Always select the correct <strong>Course</strong> when creating a subject. The subject code must be unique per course.</p>
        </div>
    </div>
    {{-- Table --}}
    <div style="flex:1;">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($subjects) }} Subjects</span>
                <div style="display:flex;gap:10px;">
                    <select class="form-select" style="width:200px;"><option>All Courses</option><option>Bachelor of Computer Science</option><option>Bachelor of Mathematics</option><option>Bachelor of Physics</option><option>Master of Data Science</option></select>
                    <select class="form-select" style="width:120px;"><option>All Types</option><option>Lecture</option><option>Lab</option><option>Workshop</option></select>
                    <input class="form-input" style="width:180px;" placeholder="Search subjects…" type="text">
                </div>
            </div>
            <table>
                <thead><tr><th>#</th><th>Course</th><th>Subject Code</th><th>Subject Name</th><th>Type</th><th>Credits</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($subjects as $s)
                @php [$bg,$tc]=$typeStyle[$s['type']]??['#f1f5f9','#374151']; @endphp
                <tr>
                    <td style="color:#94a3b8;font-size:12px;">{{ $s['id'] }}</td>
                    <td>
                        <div style="font-size:12px;font-weight:700;color:#4338ca;">{{ $s['course'] }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $s['dept'] }}</div>
                    </td>
                    <td style="font-weight:800;font-family:monospace;color:#4f46e5;">{{ $s['code'] }}</td>
                    <td style="font-weight:600;color:#1e293b;">{{ $s['name'] }}</td>
                    <td><span style="background:{{ $bg }};color:{{ $tc }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:9999px;">{{ $s['type'] }}</span></td>
                    <td><span style="background:#f1f5f9;color:#475569;font-size:12px;font-weight:700;padding:3px 9px;border-radius:6px;">{{ $s['credits'] }} cr</span></td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $s['status']==='Active'?'#d1fae5':'#fee2e2' }};color:{{ $s['status']==='Active'?'#065f46':'#991b1b' }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $s['status']==='Active'?'#10b981':'#ef4444' }};display:inline-block;"></span>{{ $s['status'] }}</span></td>
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
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">📖</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Subject / Module</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Course <span style="color:#ef4444;">*</span></label><select class="form-select"><option value="">— Select Course —</option><option>Bachelor of Computer Science (BCS)</option><option>Diploma in Computer Science (DCS)</option><option>Bachelor of Mathematics (BMATH)</option><option>Bachelor of Physics (BPHY)</option><option>Master of Data Science (MDS)</option></select><div style="font-size:11px;color:#94a3b8;margin-top:4px;">The programme this subject belongs to.</div></div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Subject Code <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. CS101" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Subject Name <span style="color:#ef4444;">*</span></label><input class="form-input" placeholder="e.g. Introduction to Programming"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Type</label><select class="form-select"><option>Lecture</option><option>Lab</option><option>Workshop</option><option>Tutorial</option></select></div>
            <div><label class="form-label">Credits</label><input class="form-input" type="number" min="1" max="10" placeholder="3"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
        </div>
    </div>
    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:10px 14px;margin-top:14px;font-size:12px;color:#0369a1;">💡 Subject code must be unique per course. It will appear on timetable slots.</div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Subject</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Subject</h2></div>
    <div style="display:grid;gap:14px;">
        <div><label class="form-label">Course</label><select class="form-select"><option selected>Bachelor of Computer Science (BCS)</option><option>Diploma in Computer Science (DCS)</option></select></div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div><label class="form-label">Subject Code</label><input class="form-input" value="CS101" style="font-family:monospace;font-weight:700;"></div>
            <div><label class="form-label">Subject Name</label><input class="form-input" value="Introduction to Programming"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Type</label><select class="form-select"><option selected>Lecture</option><option>Lab</option><option>Workshop</option></select></div>
            <div><label class="form-label">Credits</label><input class="form-input" type="number" value="3"></div>
            <div><label class="form-label">Status</label><select class="form-select"><option selected>Active</option><option>Inactive</option></select></div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
