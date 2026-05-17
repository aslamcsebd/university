@extends('layouts.academic')
@section('title', 'Exam Attendances')
@section('heading', 'Exam Attendances')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Mark Attendance</a>
@endsection

@section('content')
@php
$rows = [
    ['roll'=>'CS201-001','name'=>'Alex Johnson', 'seat'=>'A-01','status'=>'Present','time'=>'09:02 AM'],
    ['roll'=>'CS201-002','name'=>'Sara Ahmed',   'seat'=>'A-02','status'=>'Present','time'=>'09:05 AM'],
    ['roll'=>'CS201-003','name'=>'Ravi Kumar',   'seat'=>'A-03','status'=>'Absent', 'time'=>'—'],
    ['roll'=>'CS201-004','name'=>'Emily Clark',  'seat'=>'A-04','status'=>'Present','time'=>'09:01 AM'],
    ['roll'=>'CS201-005','name'=>'Omar Hassan',  'seat'=>'A-05','status'=>'Present','time'=>'09:08 AM'],
    ['roll'=>'CS201-006','name'=>'Priya Sharma', 'seat'=>'A-06','status'=>'Absent', 'time'=>'—'],
];
@endphp
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:14px;padding:16px 24px;margin-bottom:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
    <div><div style="font-size:15px;font-weight:800;">Data Structures — CS201</div><div style="font-size:12px;opacity:.7;margin-top:3px;">Mid-Term · Jul 18, 2025 · Hall A · 09:00 AM</div></div>
    <div style="display:flex;gap:16px;">
        <div style="text-align:center;"><div style="font-size:22px;font-weight:800;">4</div><div style="font-size:10px;opacity:.7;">Present</div></div>
        <div style="text-align:center;"><div style="font-size:22px;font-weight:800;">2</div><div style="font-size:10px;opacity:.7;">Absent</div></div>
    </div>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Roll No</th><th>Name</th><th>Seat</th><th>Status</th><th>Time In</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($rows as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['roll']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['seat']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Present'?'#d1fae5':'#fee2e2'}};color:{{$r['status']==='Present'?'#065f46':'#991b1b'}};">{{$r['status']}}</span></td>
            <td style="color:#64748b;">{{$r['time']}}</td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
