@extends('layouts.academic')
@section('title', 'Certificates')
@section('heading', 'Certificates')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Issue Certificate</a>
@endsection
@section('content')
@php
$certs = [
    ['id'=>'CERT-001','student'=>'Alice Johnson','type'=>'Degree Certificate',    'course'=>'B.Sc CS','issued'=>'2024-01-15','status'=>'Issued'],
    ['id'=>'CERT-002','student'=>'Carol White',  'type'=>'Degree Certificate',    'course'=>'B.Sc CS','issued'=>'2024-01-15','status'=>'Issued'],
    ['id'=>'CERT-003','student'=>'Bob Smith',    'type'=>'Provisional Certificate','course'=>'B.Com', 'issued'=>'—',         'status'=>'Pending'],
    ['id'=>'CERT-004','student'=>'Eva Green',    'type'=>'Migration Certificate',  'course'=>'B.A Eng','issued'=>'2024-01-10','status'=>'Issued'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Student</th><th>Type</th><th>Course</th><th>Issued Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($certs as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['id']}}</td>
            <td style="font-weight:600;">{{$c['student']}}</td>
            <td style="color:#64748b;">{{$c['type']}}</td>
            <td style="color:#64748b;">{{$c['course']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['issued']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c['status']==='Issued'?'#d1fae5':'#fef3c7'}};color:{{$c['status']==='Issued'?'#065f46':'#92400e'}};">{{$c['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Print</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
