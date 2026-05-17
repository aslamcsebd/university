@extends('layouts.academic')
@section('title', 'Certificate Templates')
@section('heading', 'Certificate Templates')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Template</a>
@endsection
@section('content')
@php
$templates = [
    ['id'=>1,'name'=>'Degree Certificate',     'type'=>'Degree',      'last_used'=>'2024-01-15','status'=>'Active'],
    ['id'=>2,'name'=>'Provisional Certificate','type'=>'Provisional', 'last_used'=>'2024-01-10','status'=>'Active'],
    ['id'=>3,'name'=>'Migration Certificate',  'type'=>'Migration',   'last_used'=>'2024-01-10','status'=>'Active'],
    ['id'=>4,'name'=>'Merit Certificate',      'type'=>'Merit',       'last_used'=>'2023-12-20','status'=>'Active'],
    ['id'=>5,'name'=>'Participation Certificate','type'=>'Participation','last_used'=>'2023-11-15','status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Type</th><th>Last Used</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($templates as $t)
        <tr>
            <td style="color:#64748b;">{{$t['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$t['name']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$t['type']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$t['last_used']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$t['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$t['status']==='Active'?'#065f46':'#991b1b'}};">{{$t['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
