@extends('layouts.academic')
@section('title', 'Roles & Permissions')
@section('heading', 'Roles & Permissions')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Role</a>
@endsection
@section('content')
@php
$roles = [
    ['id'=>1,'name'=>'Super Admin','users'=>1, 'permissions'=>'All','status'=>'Active'],
    ['id'=>2,'name'=>'Admin',      'users'=>3, 'permissions'=>'Most','status'=>'Active'],
    ['id'=>3,'name'=>'Teacher',    'users'=>24,'permissions'=>'Academic','status'=>'Active'],
    ['id'=>4,'name'=>'Accountant', 'users'=>2, 'permissions'=>'Finance','status'=>'Active'],
    ['id'=>5,'name'=>'Librarian',  'users'=>1, 'permissions'=>'Library','status'=>'Active'],
    ['id'=>6,'name'=>'Student',    'users'=>153,'permissions'=>'Student Panel','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Role Name</th><th>Users</th><th>Permissions</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($roles as $r)
        <tr>
            <td style="color:#64748b;">{{$r['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$r['name']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['users']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$r['permissions']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$r['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#10b981;font-weight:600;text-decoration:none;">Permissions</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
