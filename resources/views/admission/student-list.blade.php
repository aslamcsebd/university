@extends('layouts.academic')
@section('title', 'Student List')
@section('heading', 'Student List')

@section('header-actions')
    <a href="/admission/new-registration" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Student</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson',  'course'=>'B.Sc CS',    'semester'=>'Sem 3','batch'=>'2023-26','status'=>'Active'],
    ['id'=>'STU-002','name'=>'Sara Ahmed',    'course'=>'B.A English','semester'=>'Sem 1','batch'=>'2025-28','status'=>'Active'],
    ['id'=>'STU-003','name'=>'Ravi Kumar',    'course'=>'B.Com',      'semester'=>'Sem 5','batch'=>'2022-25','status'=>'Active'],
    ['id'=>'STU-004','name'=>'Emily Clark',   'course'=>'B.Sc Physics','semester'=>'Sem 2','batch'=>'2024-27','status'=>'Inactive'],
    ['id'=>'STU-005','name'=>'Omar Hassan',   'course'=>'B.E Civil',  'semester'=>'Sem 4','batch'=>'2023-26','status'=>'Active'],
    ['id'=>'STU-006','name'=>'Priya Sharma',  'course'=>'B.Sc Math',  'semester'=>'Sem 6','batch'=>'2022-25','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;align-items:center;">
        <input placeholder="Search students..." style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;outline:none;flex:1;">
        <select style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;"><option>All Courses</option></select>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Semester</th><th>Batch</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="color:#64748b;">{{$s['semester']}}</td>
            <td style="color:#64748b;">{{$s['batch']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#f3f4f6'}};color:{{$s['status']==='Active'?'#065f46':'#374151'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#f59e0b;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
