@extends('layouts.academic')
@section('title', 'Phone Logs')
@section('heading', 'Phone Logs')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Log</a>
@endsection
@section('content')
@php
$logs = [
    ['id'=>'PH-001','caller'=>'<name>','phone'=>'<phone number>','type'=>'Incoming','purpose'=>'Admission Enquiry','handled_by'=>'Reception','duration'=>'5 min','date'=>'2024-01-22'],
    ['id'=>'PH-002','caller'=>'<name>','phone'=>'<phone number>','type'=>'Outgoing','purpose'=>'Fee Reminder',     'handled_by'=>'Accounts', 'duration'=>'3 min','date'=>'2024-01-22'],
    ['id'=>'PH-003','caller'=>'<name>','phone'=>'<phone number>','type'=>'Incoming','purpose'=>'Result Enquiry',   'handled_by'=>'Reception','duration'=>'4 min','date'=>'2024-01-22'],
    ['id'=>'PH-004','caller'=>'<name>','phone'=>'<phone number>','type'=>'Incoming','purpose'=>'Complaint',        'handled_by'=>'Principal','duration'=>'8 min','date'=>'2024-01-22'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Caller</th><th>Phone</th><th>Type</th><th>Purpose</th><th>Handled By</th><th>Duration</th><th>Date</th></tr></thead>
        <tbody>
        @foreach($logs as $l)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$l['id']}}</td>
            <td style="font-weight:600;">{{$l['caller']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$l['phone']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$l['type']==='Incoming'?'#dbeafe':'#d1fae5'}};color:{{$l['type']==='Incoming'?'#1e40af':'#065f46'}};">{{$l['type']}}</span></td>
            <td style="color:#64748b;">{{$l['purpose']}}</td>
            <td style="color:#64748b;">{{$l['handled_by']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$l['duration']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$l['date']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
