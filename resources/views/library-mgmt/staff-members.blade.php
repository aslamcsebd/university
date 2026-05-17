@extends('layouts.academic')
@section('title', 'Staff Members')
@section('heading', 'Library — Staff Members')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Member</a>
@endsection
@section('content')
@php
$members = [
    ['id'=>'LIB-T001','name'=>'Mr. Adams',   'staff_id'=>'STF-010','dept'=>'Computer Science','issued'=>1,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-T002','name'=>'Ms. Rivera',  'staff_id'=>'STF-011','dept'=>'Mathematics',     'issued'=>2,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-T003','name'=>'Mr. Hassan',  'staff_id'=>'STF-012','dept'=>'Physics',         'issued'=>0,'expiry'=>'2024-12-31','status'=>'Active'],
    ['id'=>'LIB-T004','name'=>'Ms. Patel',   'staff_id'=>'STF-013','dept'=>'Commerce',        'issued'=>3,'expiry'=>'2024-12-31','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Lib ID</th><th>Name</th><th>Staff ID</th><th>Department</th><th>Books Issued</th><th>Expiry</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($members as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['name']}}</td>
            <td style="color:#64748b;">{{$m['staff_id']}}</td>
            <td style="color:#64748b;">{{$m['dept']}}</td>
            <td style="text-align:center;font-weight:700;">{{$m['issued']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['expiry']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$m['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
