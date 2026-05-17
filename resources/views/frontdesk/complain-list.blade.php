@extends('layouts.academic')
@section('title', 'Complain List')
@section('heading', 'Complain List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Complain</a>
@endsection
@section('content')
@php
$complains = [
    ['id'=>'CMP-001','name'=>'<name>','type'=>'Academic',    'source'=>'Student','subject'=>'Exam result discrepancy','date'=>'2024-01-18','status'=>'Open'],
    ['id'=>'CMP-002','name'=>'<name>','type'=>'Facility',    'source'=>'Staff',  'subject'=>'AC not working in lab',  'date'=>'2024-01-19','status'=>'In Progress'],
    ['id'=>'CMP-003','name'=>'<name>','type'=>'Fee',         'source'=>'Parent', 'subject'=>'Incorrect fee charged',  'date'=>'2024-01-20','status'=>'Resolved'],
    ['id'=>'CMP-004','name'=>'<name>','type'=>'Behavioral',  'source'=>'Student','subject'=>'Bullying incident',      'date'=>'2024-01-21','status'=>'Open'],
    ['id'=>'CMP-005','name'=>'<name>','type'=>'Academic',    'source'=>'Student','subject'=>'Teacher absence',        'date'=>'2024-01-22','status'=>'In Progress'],
];
$colors = ['Open'=>['#fee2e2','#991b1b'],'In Progress'=>['#fef3c7','#92400e'],'Resolved'=>['#d1fae5','#065f46']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Source</th><th>Subject</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($complains as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['id']}}</td>
            <td style="font-weight:600;">{{$c['name']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$c['type']}}</span></td>
            <td style="color:#64748b;">{{$c['source']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['subject']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$c['status']][0]}};color:{{$colors[$c['status']][1]}};">{{$c['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Close</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
