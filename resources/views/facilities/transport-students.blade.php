@extends('layouts.academic')
@section('title', 'Transport Students')
@section('heading', 'Transport Students')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Assign Student</a>
@endsection
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson','route'=>'Route A','vehicle'=>'ABC-1234','stop'=>'Stop 3','fee'=>'$50/mo','status'=>'Active'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'route'=>'Route B','vehicle'=>'DEF-5678','stop'=>'Stop 1','fee'=>'$50/mo','status'=>'Active'],
    ['id'=>'STU-103','name'=>'Carol White',  'route'=>'Route A','vehicle'=>'ABC-1234','stop'=>'Stop 5','fee'=>'$50/mo','status'=>'Active'],
    ['id'=>'STU-104','name'=>'David Brown',  'route'=>'Route C','vehicle'=>'GHI-9012','stop'=>'Stop 2','fee'=>'$45/mo','status'=>'Active'],
    ['id'=>'STU-105','name'=>'Eva Green',    'route'=>'Route E','vehicle'=>'MNO-7890','stop'=>'Stop 4','fee'=>'$48/mo','status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Route</th><th>Vehicle</th><th>Stop</th><th>Fee</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['route']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['vehicle']}}</td>
            <td style="color:#64748b;">{{$s['stop']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$s['fee']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='Active'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
