@extends('layouts.academic')
@section('title', 'Postal Exchanges')
@section('heading', 'Postal Exchanges')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Record</a>
@endsection
@section('content')
@php
$posts = [
    ['id'=>'PST-001','from'=>'University Board','to'=>'Principal',    'type'=>'Received','subject'=>'Annual Report Request','date'=>'2024-01-18','status'=>'Delivered'],
    ['id'=>'PST-002','from'=>'Principal',       'to'=>'Ministry',     'type'=>'Sent',    'subject'=>'Budget Proposal',       'date'=>'2024-01-19','status'=>'Sent'],
    ['id'=>'PST-003','from'=>'<name>',          'to'=>'Accounts Dept','type'=>'Received','subject'=>'Fee Dispute Letter',    'date'=>'2024-01-20','status'=>'Delivered'],
    ['id'=>'PST-004','from'=>'HR Dept',         'to'=>'Staff',        'type'=>'Sent',    'subject'=>'Appointment Letter',    'date'=>'2024-01-21','status'=>'Sent'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>From</th><th>To</th><th>Type</th><th>Subject</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($posts as $p)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$p['id']}}</td>
            <td style="color:#64748b;">{{$p['from']}}</td>
            <td style="color:#64748b;">{{$p['to']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$p['type']==='Received'?'#dbeafe':'#d1fae5'}};color:{{$p['type']==='Received'?'#1e40af':'#065f46'}};">{{$p['type']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$p['subject']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$p['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f1f5f9;color:#64748b;">{{$p['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
