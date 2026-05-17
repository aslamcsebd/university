@extends('layouts.academic')
@section('title', 'ID Cards')
@section('heading', 'ID Cards')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">🖨 Print Selected</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'course'=>'B.Sc CS',    'batch'=>'2023-26','printed'=>true],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'course'=>'B.A English','batch'=>'2025-28','printed'=>false],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'course'=>'B.Com',      'batch'=>'2022-25','printed'=>true],
    ['id'=>'STU-004','name'=>'Emily Clark',  'course'=>'B.Sc Physics','batch'=>'2024-27','printed'=>false],
    ['id'=>'STU-005','name'=>'Omar Hassan',  'course'=>'B.E Civil',  'batch'=>'2023-26','printed'=>true],
];
@endphp

{{-- Preview Card --}}
<div style="margin-bottom:20px;">
    <div style="font-size:13px;font-weight:700;color:#1e1b4b;margin-bottom:12px;">ID Card Preview</div>
    <div style="width:320px;background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:20px;color:#fff;box-shadow:0 8px 30px rgba(79,70,229,.3);">
        <div style="font-size:11px;font-weight:700;letter-spacing:.1em;opacity:.7;margin-bottom:12px;">🎓 ACADEMY — STUDENT ID</div>
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;">AJ</div>
            <div>
                <div style="font-size:16px;font-weight:800;">Alex Johnson</div>
                <div style="font-size:11px;opacity:.7;margin-top:2px;">STU-001 · B.Sc CS</div>
                <div style="font-size:11px;opacity:.7;">Batch 2023–26</div>
            </div>
        </div>
        <div style="margin-top:14px;padding-top:12px;border-top:1px solid rgba(255,255,255,.2);font-size:10px;opacity:.6;">Valid: 2023 – 2026 · academy.edu</div>
    </div>
</div>

<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th><input type="checkbox"></th><th>ID</th><th>Name</th><th>Course</th><th>Batch</th><th>Printed</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td><input type="checkbox"></td>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="color:#64748b;">{{$s['batch']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['printed']?'#d1fae5':'#fef3c7'}};color:{{$s['printed']?'#065f46':'#92400e'}};">{{$s['printed']?'Printed':'Not Printed'}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">🖨 Print</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
