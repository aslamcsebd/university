@extends('layouts.academic')
@section('title', 'Enroll Courses')
@section('heading', 'Enroll Courses')

@section('content')
<div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
<div class="card" style="padding:24px;height:fit-content;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">🔍 Filter</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Program</label><select class="form-select"><option>B.Sc Computer Science</option></select></div>
        <div><label class="form-label">Semester</label><select class="form-select"><option>Semester 1</option><option>Semester 2</option></select></div>
        <div><label class="form-label">Session</label><select class="form-select"><option>2024-2025</option></select></div>
        <button class="btn btn-primary">Load Courses</button>
    </div>
</div>
<div>
@php
$courses = [
    ['code'=>'CS101','name'=>'Introduction to Programming','credits'=>3,'staff'=>'Dr. Mitchell','enrolled'=>38,'capacity'=>40,'status'=>'Open'],
    ['code'=>'CS102','name'=>'Discrete Mathematics',       'credits'=>3,'staff'=>'Prof. Okafor', 'enrolled'=>40,'capacity'=>40,'status'=>'Full'],
    ['code'=>'CS103','name'=>'Digital Logic Design',       'credits'=>3,'staff'=>'Dr. Nair',     'enrolled'=>35,'capacity'=>40,'status'=>'Open'],
    ['code'=>'MATH101','name'=>'Calculus I',               'credits'=>3,'staff'=>'Prof. Chen',   'enrolled'=>39,'capacity'=>40,'status'=>'Open'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:14px;font-weight:700;color:#1e1b4b;">Available Courses — Semester 1</div>
    <table>
        <thead><tr><th>Code</th><th>Course Name</th><th>Credits</th><th>Staff</th><th>Enrolled</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($courses as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['code']}}</td>
            <td style="font-weight:600;">{{$c['name']}}</td>
            <td style="text-align:center;">{{$c['credits']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['staff']}}</td>
            <td style="text-align:center;">{{$c['enrolled']}}/{{$c['capacity']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c['status']==='Open'?'#d1fae5':'#fee2e2'}};color:{{$c['status']==='Open'?'#065f46':'#991b1b'}};">{{$c['status']}}</span></td>
            <td>@if($c['status']==='Open')<a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Enroll</a>@else<span style="font-size:12px;color:#94a3b8;">Full</span>@endif</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
@endsection
