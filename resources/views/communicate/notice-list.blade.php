@extends('layouts.academic')
@section('title', 'Notice List')
@section('heading', 'Notice List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Notice</a>
@endsection
@section('content')
@php
$notices = [
    ['id'=>'NTC-001','title'=>'Semester Exam Schedule',  'category'=>'Exam',     'audience'=>'All Students','date'=>'2024-01-20','status'=>'Published'],
    ['id'=>'NTC-002','title'=>'Fee Payment Deadline',    'category'=>'Finance',  'audience'=>'All Students','date'=>'2024-01-18','status'=>'Published'],
    ['id'=>'NTC-003','title'=>'Staff Meeting',           'category'=>'General',  'audience'=>'All Staff',   'date'=>'2024-01-22','status'=>'Published'],
    ['id'=>'NTC-004','title'=>'Library Closure Notice',  'category'=>'Library',  'audience'=>'Everyone',    'date'=>'2024-01-23','status'=>'Draft'],
    ['id'=>'NTC-005','title'=>'Sports Day Registration', 'category'=>'Events',   'audience'=>'All Students','date'=>'2024-01-24','status'=>'Published'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Category</th><th>Audience</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($notices as $n)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$n['id']}}</td>
            <td style="font-weight:600;">{{$n['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$n['category']}}</span></td>
            <td style="color:#64748b;">{{$n['audience']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$n['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$n['status']==='Published'?'#d1fae5':'#fef3c7'}};color:{{$n['status']==='Published'?'#065f46':'#92400e'}};">{{$n['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
