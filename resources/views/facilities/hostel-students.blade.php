@extends('layouts.academic')
@section('title', 'Hostel Students')
@section('heading', 'Hostel Students')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Assign Room</a>
@endsection
@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'hostel'=>'Boys Hostel A','room'=>'HR-101','type'=>'Double','fee'=>'$100','status'=>'Active'],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'hostel'=>'Boys Hostel A','room'=>'HR-102','type'=>'Double','fee'=>'$100','status'=>'Active'],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'hostel'=>'Girls Hostel B','room'=>'HR-201','type'=>'Triple','fee'=>'$80','status'=>'Active'],
    ['id'=>'STU-006','name'=>'Priya Sharma', 'hostel'=>'Girls Hostel B','room'=>'HR-201','type'=>'Triple','fee'=>'$80','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <select class="form-select" style="width:200px;"><option>All Hostels</option></select>
        <input placeholder="Search student..." class="form-input" style="max-width:240px;">
    </div>
    <table>
        <thead><tr><th>Student ID</th><th>Name</th><th>Hostel</th><th>Room</th><th>Room Type</th><th>Monthly Fee</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['hostel']}}</td>
            <td style="font-weight:600;color:#1e293b;">{{$s['room']}}</td>
            <td style="color:#64748b;">{{$s['type']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$s['fee']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
