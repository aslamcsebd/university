@extends('layouts.academic')
@section('title', 'Group Enrolls')
@section('heading', 'Group Enrolls')

@section('content')
<div class="card" style="padding:24px;max-width:720px;margin-bottom:20px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">👥 Group Enrollment Filter</div>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:16px;">
        <div><label class="form-label">Course</label><select class="form-select"><option>B.Sc Computer Science</option></select></div>
        <div><label class="form-label">Semester</label><select class="form-select"><option>Semester 1</option></select></div>
        <div><label class="form-label">Batch</label><input class="form-input" value="2025-2028"></div>
    </div>
    <button class="btn btn-primary">Load Students</button>
</div>
@php
$students = [
    ['id'=>'STU-010','name'=>'John Doe',    'email'=>'john@example.com'],
    ['id'=>'STU-011','name'=>'Jane Smith',  'email'=>'jane@example.com'],
    ['id'=>'STU-012','name'=>'Ali Hassan',  'email'=>'ali@example.com'],
    ['id'=>'STU-013','name'=>'Mia Wong',    'email'=>'mia@example.com'],
    ['id'=>'STU-014','name'=>'Leo Martin',  'email'=>'leo@example.com'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:13px;font-weight:700;color:#1e1b4b;">5 students found</div>
        <button class="btn btn-primary btn-sm">✅ Enroll All Selected</button>
    </div>
    <table>
        <thead><tr><th><input type="checkbox"></th><th>ID</th><th>Name</th><th>Email</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td><input type="checkbox" checked></td>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['email']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fef3c7;color:#92400e;">Not Enrolled</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
