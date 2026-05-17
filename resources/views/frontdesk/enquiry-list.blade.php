@extends('layouts.academic')
@section('title', 'Enquiry List')
@section('heading', 'Enquiry List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Enquiry</a>
@endsection
@section('content')
@php
$enquiries = [
    ['id'=>'ENQ-001','name'=>'<name>','phone'=>'<phone number>','source'=>'Walk-in',  'course'=>'B.Sc CS', 'date'=>'2024-01-20','status'=>'New'],
    ['id'=>'ENQ-002','name'=>'<name>','phone'=>'<phone number>','source'=>'Website',  'course'=>'MBA',     'date'=>'2024-01-21','status'=>'Followed Up'],
    ['id'=>'ENQ-003','name'=>'<name>','phone'=>'<phone number>','source'=>'Referral', 'course'=>'B.Com',   'date'=>'2024-01-21','status'=>'New'],
    ['id'=>'ENQ-004','name'=>'<name>','phone'=>'<phone number>','source'=>'Phone',    'course'=>'B.A Eng', 'date'=>'2024-01-22','status'=>'Converted'],
    ['id'=>'ENQ-005','name'=>'<name>','phone'=>'<phone number>','source'=>'Walk-in',  'course'=>'B.Sc CS', 'date'=>'2024-01-22','status'=>'New'],
];
$colors = ['New'=>['#dbeafe','#1e40af'],'Followed Up'=>['#fef3c7','#92400e'],'Converted'=>['#d1fae5','#065f46']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Source</th><th>Course</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($enquiries as $e)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$e['id']}}</td>
            <td style="font-weight:600;">{{$e['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$e['phone']}}</td>
            <td style="color:#64748b;">{{$e['source']}}</td>
            <td style="color:#64748b;">{{$e['course']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$e['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$e['status']][0]}};color:{{$colors[$e['status']][1]}};">{{$e['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
