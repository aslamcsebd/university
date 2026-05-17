@extends('layouts.academic')
@section('title', 'Transport Staff')
@section('heading', 'Transport Staff')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Assign Staff</a>
@endsection
@section('content')
@php
$staff = [
    ['id'=>'STF-020','name'=>'Mr. Johnson','route'=>'Route A','vehicle'=>'ABC-1234','role'=>'Driver',    'phone'=>'+1-555-0301','status'=>'Active'],
    ['id'=>'STF-021','name'=>'Mr. Patel',  'route'=>'Route B','vehicle'=>'DEF-5678','role'=>'Driver',    'phone'=>'+1-555-0302','status'=>'Active'],
    ['id'=>'STF-022','name'=>'Mr. Lee',    'route'=>'Route C','vehicle'=>'GHI-9012','role'=>'Driver',    'phone'=>'+1-555-0303','status'=>'Active'],
    ['id'=>'STF-023','name'=>'Mr. Ahmed',  'route'=>'Route D','vehicle'=>'JKL-3456','role'=>'Driver',    'phone'=>'+1-555-0304','status'=>'Inactive'],
    ['id'=>'STF-024','name'=>'Mr. Clark',  'route'=>'Route E','vehicle'=>'MNO-7890','role'=>'Driver',    'phone'=>'+1-555-0305','status'=>'Active'],
    ['id'=>'STF-025','name'=>'Ms. Torres', 'route'=>'Route A','vehicle'=>'ABC-1234','role'=>'Attendant', 'phone'=>'+1-555-0306','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Route</th><th>Vehicle</th><th>Role</th><th>Phone</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($staff as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['route']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['vehicle']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$s['role']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$s['phone']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='Active'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
