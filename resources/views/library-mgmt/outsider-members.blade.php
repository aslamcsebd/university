@extends('layouts.academic')
@section('title', 'Outsider Members')
@section('heading', 'Library — Outsider Members')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Member</a>
@endsection
@section('content')
@php
$members = [
    ['id'=>'LIB-O001','name'=>'Dr. Wilson',  'org'=>'City Research Lab',  'phone'=>'+1-555-0401','issued'=>1,'expiry'=>'2024-06-30','status'=>'Active'],
    ['id'=>'LIB-O002','name'=>'Ms. Carter',  'org'=>'Public Library',     'phone'=>'+1-555-0402','issued'=>0,'expiry'=>'2024-06-30','status'=>'Active'],
    ['id'=>'LIB-O003','name'=>'Mr. Nguyen',  'org'=>'Tech Institute',     'phone'=>'+1-555-0403','issued'=>2,'expiry'=>'2023-12-31','status'=>'Expired'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Lib ID</th><th>Name</th><th>Organization</th><th>Phone</th><th>Books Issued</th><th>Expiry</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($members as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['name']}}</td>
            <td style="color:#64748b;">{{$m['org']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['phone']}}</td>
            <td style="text-align:center;font-weight:700;">{{$m['issued']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['expiry']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$m['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$m['status']==='Active'?'#065f46':'#991b1b'}};">{{$m['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Remove</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
