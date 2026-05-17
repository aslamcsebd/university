@extends('layouts.academic')
@section('title', 'Student Members')
@section('heading', 'Library — Student Members')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Member</a>
@endsection
@section('content')
@php
$members = [
    ['id'=>'LIB-S001','name'=>'Alice Johnson','student_id'=>'STU-101','course'=>'B.Sc CS', 'issued'=>2,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-S002','name'=>'Bob Smith',    'student_id'=>'STU-102','course'=>'B.Com',   'issued'=>1,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-S003','name'=>'Carol White',  'student_id'=>'STU-103','course'=>'B.Sc CS', 'issued'=>3,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-S004','name'=>'David Brown',  'student_id'=>'STU-104','course'=>'MBA',     'issued'=>0,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-S005','name'=>'Eva Green',    'student_id'=>'STU-105','course'=>'B.A Eng', 'issued'=>1,'expiry'=>'2023-12-31','status'=>'Expired'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Lib ID</th><th>Name</th><th>Student ID</th><th>Course</th><th>Books Issued</th><th>Expiry</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($members as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['name']}}</td>
            <td style="color:#64748b;">{{$m['student_id']}}</td>
            <td style="color:#64748b;">{{$m['course']}}</td>
            <td style="text-align:center;font-weight:700;">{{$m['issued']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['expiry']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$m['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$m['status']==='Active'?'#065f46':'#991b1b'}};">{{$m['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
