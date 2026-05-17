@extends('layouts.academic')
@section('title', 'Book Requests')
@section('heading', 'Book Requests')
@section('content')
@php
$requests = [
    ['id'=>'REQ-001','member'=>'Alice Johnson','book'=>'Machine Learning Basics','type'=>'Student','date'=>'2024-01-20','status'=>'Pending'],
    ['id'=>'REQ-002','member'=>'Bob Smith',    'book'=>'Advanced SQL',           'type'=>'Student','date'=>'2024-01-21','status'=>'Approved'],
    ['id'=>'REQ-003','member'=>'Carol White',  'book'=>'Cloud Computing',        'type'=>'Student','date'=>'2024-01-22','status'=>'Pending'],
    ['id'=>'REQ-004','member'=>'Mr. Adams',    'book'=>'Leadership Principles',  'type'=>'Staff',  'date'=>'2024-01-18','status'=>'Approved'],
    ['id'=>'REQ-005','member'=>'David Brown',  'book'=>'Cyber Security Basics',  'type'=>'Student','date'=>'2024-01-23','status'=>'Rejected'],
];
$colors = ['Pending'=>['#fef3c7','#92400e'],'Approved'=>['#d1fae5','#065f46'],'Rejected'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Member</th><th>Book Title</th><th>Type</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($requests as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['member']}}</td>
            <td style="color:#64748b;">{{$r['book']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$r['type']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$r['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$r['status']][0]}};color:{{$colors[$r['status']][1]}};">{{$r['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#10b981;font-weight:600;text-decoration:none;">Approve</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Reject</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
