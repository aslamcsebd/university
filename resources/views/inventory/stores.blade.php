@extends('layouts.academic')
@section('title', 'Stores')
@section('heading', 'Stores')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Store</a>
@endsection
@section('content')
@php
$stores = [
    ['id'=>'STR-001','name'=>'Store A','location'=>'Block A, Ground Floor','manager'=>'Mr. Adams', 'items'=>3,'status'=>'Active'],
    ['id'=>'STR-002','name'=>'Store B','location'=>'Block B, Room 101',    'manager'=>'Ms. Rivera','items'=>2,'status'=>'Active'],
    ['id'=>'STR-003','name'=>'Store C','location'=>'Science Block',        'manager'=>'Mr. Hassan','items'=>2,'status'=>'Active'],
    ['id'=>'STR-004','name'=>'Store D','location'=>'Admin Block',          'manager'=>'Ms. Patel', 'items'=>0,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Location</th><th>Manager</th><th>Items</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($stores as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['location']}}</td>
            <td style="color:#64748b;">{{$s['manager']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['items']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='Active'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
