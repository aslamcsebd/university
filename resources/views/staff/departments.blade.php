@extends('layouts.academic')
@section('title', 'Departments')
@section('heading', 'Departments (HR)')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Department</a>
@endsection
@section('content')
@php
$depts = [
    ['id'=>'DPT-001','name'=>'Computer Science','head'=>'Dr. Mitchell','staff'=>6,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'DPT-002','name'=>'Mathematics',     'head'=>'Prof. Okafor', 'staff'=>4,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'DPT-003','name'=>'Physics',         'head'=>'Dr. Nair',     'staff'=>3,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'DPT-004','name'=>'Civil Engineering','head'=>'Prof. Chen',  'staff'=>5,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'DPT-005','name'=>'Administration',  'head'=>'Mr. Adams',    'staff'=>4,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
@foreach($depts as $d)
<div class="card" style="padding:20px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:{{$d['bg']}};display:flex;align-items:center;justify-content:center;font-size:20px;">🏛️</div>
        <div><div style="font-size:14px;font-weight:700;color:#1e293b;">{{$d['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$d['id']}}</div></div>
    </div>
    <div style="font-size:12px;color:#64748b;margin-bottom:8px;">Head: <span style="font-weight:600;color:#1e293b;">{{$d['head']}}</span></div>
    <div style="display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:13px;font-weight:700;color:{{$d['color']}};">{{$d['staff']}} Staff</span>
        <div style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></div>
    </div>
</div>
@endforeach
</div>
@endsection
