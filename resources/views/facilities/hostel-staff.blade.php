@extends('layouts.academic')
@section('title', 'Hostel Staff')
@section('heading', 'Hostel Staff')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Assign Staff</a>
@endsection
@section('content')
@php
$staff = [
    ['id'=>'STF-010','name'=>'Mr. Adams',   'hostel'=>'Boys Hostel A', 'role'=>'Warden',       'phone'=>'+1-555-0201','status'=>'Active'],
    ['id'=>'STF-011','name'=>'Ms. Rivera',  'hostel'=>'Girls Hostel B','role'=>'Warden',       'phone'=>'+1-555-0202','status'=>'Active'],
    ['id'=>'STF-012','name'=>'Mr. Hassan',  'hostel'=>'Boys Hostel C', 'role'=>'Warden',       'phone'=>'+1-555-0203','status'=>'Active'],
    ['id'=>'STF-013','name'=>'Mr. Kumar',   'hostel'=>'Boys Hostel A', 'role'=>'Security',     'phone'=>'+1-555-0204','status'=>'Active'],
    ['id'=>'STF-014','name'=>'Ms. Patel',   'hostel'=>'Girls Hostel B','role'=>'Housekeeper',  'phone'=>'+1-555-0205','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Hostel</th><th>Role</th><th>Phone</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($staff as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['hostel']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$s['role']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$s['phone']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
