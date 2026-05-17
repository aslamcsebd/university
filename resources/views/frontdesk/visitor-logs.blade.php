@extends('layouts.academic')
@section('title', 'Visitor Logs')
@section('heading', 'Visitor Logs')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Visitor</a>
@endsection
@section('content')
@php
$visitors = [
    ['id'=>'VIS-001','name'=>'<name>','purpose'=>'Meeting','host'=>'Mr. Adams',  'in'=>'09:15','out'=>'10:30','date'=>'2024-01-22','status'=>'Left'],
    ['id'=>'VIS-002','name'=>'<name>','purpose'=>'Enquiry','host'=>'Reception',  'in'=>'10:00','out'=>'—',    'date'=>'2024-01-22','status'=>'Inside'],
    ['id'=>'VIS-003','name'=>'<name>','purpose'=>'Delivery','host'=>'Admin',     'in'=>'11:20','out'=>'11:35','date'=>'2024-01-22','status'=>'Left'],
    ['id'=>'VIS-004','name'=>'<name>','purpose'=>'Interview','host'=>'HR Dept',  'in'=>'14:00','out'=>'15:00','date'=>'2024-01-22','status'=>'Left'],
    ['id'=>'VIS-005','name'=>'<name>','purpose'=>'Meeting','host'=>'Principal',  'in'=>'15:30','out'=>'—',    'date'=>'2024-01-22','status'=>'Inside'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Purpose</th><th>Host</th><th>In</th><th>Out</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($visitors as $v)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$v['id']}}</td>
            <td style="font-weight:600;">{{$v['name']}}</td>
            <td style="color:#64748b;">{{$v['purpose']}}</td>
            <td style="color:#64748b;">{{$v['host']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$v['in']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$v['out']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$v['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$v['status']==='Inside'?'#dbeafe':'#f1f5f9'}};color:{{$v['status']==='Inside'?'#1e40af':'#64748b'}};">{{$v['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
