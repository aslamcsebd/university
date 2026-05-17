@extends('layouts.academic')
@section('title', 'Suppliers')
@section('heading', 'Suppliers')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Supplier</a>
@endsection
@section('content')
@php
$suppliers = [
    ['id'=>'SUP-001','name'=>'TechCorp',    'contact'=>'<contact>','email'=>'<email>','phone'=>'+1-555-0501','items'=>2,'status'=>'Active'],
    ['id'=>'SUP-002','name'=>'OfficeSupply','contact'=>'<contact>','email'=>'<email>','phone'=>'+1-555-0502','items'=>1,'status'=>'Active'],
    ['id'=>'SUP-003','name'=>'FurnishCo',  'contact'=>'<contact>','email'=>'<email>','phone'=>'+1-555-0503','items'=>1,'status'=>'Active'],
    ['id'=>'SUP-004','name'=>'UniWear',    'contact'=>'<contact>','email'=>'<email>','phone'=>'+1-555-0504','items'=>1,'status'=>'Active'],
    ['id'=>'SUP-005','name'=>'SafetyFirst','contact'=>'<contact>','email'=>'<email>','phone'=>'+1-555-0505','items'=>1,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Contact</th><th>Email</th><th>Phone</th><th>Items</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($suppliers as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['contact']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['email']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['phone']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['items']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='Active'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
