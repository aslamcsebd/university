@extends('layouts.academic')
@section('title','Semesters')
@section('heading','Semesters')
@section('header-actions')
<button class="btn btn-primary" onclick="openModal('modal-add')">+ New Semester</button>
@endsection
@section('content')
@php
$semesters = [
    ['id'=>1,'name'=>'Semester 1 2025','dept'=>'Computer Science',   'course'=>'Bachelor of Computer Science','year'=>2025,'sem'=>1,'start'=>'2025-01-13','end'=>'2025-05-09','subjects'=>['CS101','CS201','CS301'],'status'=>'Active'],
    ['id'=>2,'name'=>'Semester 2 2025','dept'=>'Computer Science',   'course'=>'Bachelor of Computer Science','year'=>2025,'sem'=>2,'start'=>'2025-06-02','end'=>'2025-09-26','subjects'=>['CS401'],'status'=>'Upcoming'],
    ['id'=>3,'name'=>'Semester 1 2025','dept'=>'Mathematics',        'course'=>'Bachelor of Mathematics',     'year'=>2025,'sem'=>1,'start'=>'2025-01-13','end'=>'2025-05-09','subjects'=>['MATH101','MATH201'],'status'=>'Active'],
    ['id'=>4,'name'=>'Semester 1 2025','dept'=>'Physics',            'course'=>'Bachelor of Physics',         'year'=>2025,'sem'=>1,'start'=>'2025-01-13','end'=>'2025-05-09','subjects'=>['PHY101','PHY201'],'status'=>'Active'],
    ['id'=>5,'name'=>'Semester 1 2025','dept'=>'Data Science',       'course'=>'Master of Data Science',      'year'=>2025,'sem'=>1,'start'=>'2025-01-13','end'=>'2025-05-09','subjects'=>['DS401'],'status'=>'Active'],
    ['id'=>6,'name'=>'Semester 2 2024','dept'=>'Computer Science',   'course'=>'Bachelor of Computer Science','year'=>2024,'sem'=>2,'start'=>'2024-06-03','end'=>'2024-09-27','subjects'=>['CS101','CS201'],'status'=>'Completed'],
];
$statusStyle=['Active'=>['#d1fae5','#065f46','#10b981'],'Upcoming'=>['#dbeafe','#1e40af','#3b82f6'],'Completed'=>['#f3f4f6','#374151','#9ca3af']];
@endphp
<div style="display:flex;gap:20px;align-items:flex-start;">
    {{-- Tips --}}
    <div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
        <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">💡 What is a Semester?</div>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">A <strong style="color:#fff;">Semester</strong> is a time period within a Department's Course — e.g. <em>Semester 1 2025 for BCS</em>.</p>
            <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Each semester links a <strong style="color:#fff;">Course</strong> with selected <strong style="color:#fff;">Subjects</strong> for that period.</p>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
            @php
                $total=count($semesters);
                $active=count(array_filter($semesters,fn($s)=>$s['status']==='Active'));
                $upcoming=count(array_filter($semesters,fn($s)=>$s['status']==='Upcoming'));
                $completed=count(array_filter($semesters,fn($s)=>$s['status']==='Completed'));
            @endphp
            @foreach([['Total',$total,'#4f46e5'],['Active',$active,'#10b981'],['Upcoming',$upcoming,'#3b82f6'],['Completed',$completed,'#94a3b8']] as [$l,$v,$c])
            <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
                <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
            </div>
            @endforeach
        </div>
        <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:12px;padding:14px;">
            <div style="font-size:12px;font-weight:700;color:#854d0e;margin-bottom:6px;">⚠️ Note</div>
            <p style="font-size:11px;color:#92400e;line-height:1.6;margin:0;">Only <strong>Active</strong> semesters can have timetable slots created against them.</p>
        </div>
    </div>
    {{-- Table --}}
    <div style="flex:1;">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <span style="font-size:16px;font-weight:700;color:#1e1b4b;">{{ count($semesters) }} Semesters</span>
                <div style="display:flex;gap:10px;">
                    <select class="form-select" style="width:170px;"><option>All Departments</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
                    <select class="form-select" style="width:120px;"><option>All Years</option><option>2025</option><option>2024</option></select>
                    <select class="form-select" style="width:130px;"><option>All Statuses</option><option>Active</option><option>Upcoming</option><option>Completed</option></select>
                </div>
            </div>
            <table>
                <thead><tr><th>Semester</th><th>Department</th><th>Course</th><th>Period</th><th>Subjects</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($semesters as $s)
                @php [$bg,$tc,$dot]=$statusStyle[$s['status']]; $weeks=round((strtotime($s['end'])-strtotime($s['start']))/604800); @endphp
                <tr>
                    <td>
                        <div style="font-weight:700;color:#1e293b;">{{ $s['name'] }}</div>
                        <div style="font-size:11px;color:#94a3b8;">Year {{ $s['year'] }} · Sem {{ $s['sem'] }}</div>
                    </td>
                    <td style="font-size:12px;color:#64748b;">{{ $s['dept'] }}</td>
                    <td style="font-size:12px;font-weight:600;color:#4338ca;">{{ $s['course'] }}</td>
                    <td>
                        <div style="font-size:12px;color:#374151;">{{ date('d M Y',strtotime($s['start'])) }} – {{ date('d M Y',strtotime($s['end'])) }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $weeks }} weeks</div>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:4px;">
                            @foreach($s['subjects'] as $sub)
                            <span style="background:#eef2ff;color:#4338ca;font-size:10px;font-weight:700;padding:2px 7px;border-radius:5px;font-family:monospace;">{{ $sub }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;background:{{ $bg }};color:{{ $tc }};"><span style="width:6px;height:6px;border-radius:50%;background:{{ $dot }};display:inline-block;"></span>{{ $s['status'] }}</span></td>
                    <td><div style="display:flex;gap:6px;"><button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button><button class="btn btn-danger btn-sm">Delete</button></div></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Add --}}
<div id="modal-add" data-modal style="display:none;" class="modal"><div class="modal-box modal-box-lg">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">📅</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">New Semester</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Department <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select></div>
            <div><label class="form-label">Course <span style="color:#ef4444;">*</span></label><select class="form-select"><option>Bachelor of Computer Science (BCS)</option><option>Diploma in Computer Science (DCS)</option><option>Bachelor of Mathematics (BMATH)</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Year <span style="color:#ef4444;">*</span></label><input class="form-input" type="number" value="2025"></div>
            <div><label class="form-label">Semester No. <span style="color:#ef4444;">*</span></label><select class="form-select"><option>1</option><option>2</option><option>3</option></select></div>
            <div><label class="form-label">Status</label><select class="form-select"><option>Upcoming</option><option>Active</option><option>Completed</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Start Date <span style="color:#ef4444;">*</span></label><input class="form-input" type="date"></div>
            <div><label class="form-label">End Date <span style="color:#ef4444;">*</span></label><input class="form-input" type="date"></div>
        </div>
        <div>
            <label class="form-label">Subjects / Modules <span style="color:#ef4444;">*</span></label>
            <div style="border:1px solid #d1d5db;border-radius:8px;padding:12px;display:flex;flex-wrap:wrap;gap:10px;background:#f9fafb;">
                @foreach(['CS101 – Intro to Programming','CS201 – Data Structures','CS301 – Database Systems','CS401 – Software Engineering','MATH101 – Calculus I','PHY101 – Physics Fundamentals'] as $sub)
                <label style="display:flex;align-items:center;gap:6px;font-size:12px;cursor:pointer;background:#fff;padding:5px 10px;border-radius:6px;border:1px solid #e5e7eb;">
                    <input type="checkbox"> {{ $sub }}
                </label>
                @endforeach
            </div>
            <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Select subjects offered in this semester.</div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Create Semester</button></div>
</div></div>
{{-- Edit --}}
<div id="modal-edit" data-modal style="display:none;" class="modal"><div class="modal-box modal-box-lg">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;"><div style="width:36px;height:36px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">✏️</div><h2 style="font-size:16px;font-weight:700;margin:0;color:#1e1b4b;">Edit Semester</h2></div>
    <div style="display:grid;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Department</label><select class="form-select"><option selected>Computer Science</option><option>Mathematics</option></select></div>
            <div><label class="form-label">Course</label><select class="form-select"><option selected>Bachelor of Computer Science (BCS)</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div><label class="form-label">Year</label><input class="form-input" type="number" value="2025"></div>
            <div><label class="form-label">Semester No.</label><select class="form-select"><option selected>1</option><option>2</option></select></div>
            <div><label class="form-label">Status</label><select class="form-select"><option selected>Active</option><option>Upcoming</option><option>Completed</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Start Date</label><input class="form-input" type="date" value="2025-01-13"></div>
            <div><label class="form-label">End Date</label><input class="form-input" type="date" value="2025-05-09"></div>
        </div>
        <div>
            <label class="form-label">Subjects / Modules</label>
            <div style="border:1px solid #d1d5db;border-radius:8px;padding:12px;display:flex;flex-wrap:wrap;gap:10px;background:#f9fafb;">
                @foreach(['CS101 – Intro to Programming','CS201 – Data Structures','CS301 – Database Systems','CS401 – Software Engineering'] as $i=>$sub)
                <label style="display:flex;align-items:center;gap:6px;font-size:12px;cursor:pointer;background:#fff;padding:5px 10px;border-radius:6px;border:1px solid #e5e7eb;">
                    <input type="checkbox" {{ $i<3?'checked':'' }}> {{ $sub }}
                </label>
                @endforeach
            </div>
        </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;"><button class="btn btn-secondary" onclick="closeModal()">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
</div></div>
@endsection
