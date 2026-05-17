@extends('layouts.academic')
@section('title', 'Applications')
@section('heading', 'Applications')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ New Application</a>
@endsection

@section('content')
@php
$apps = [
    ['id'=>'APP-001','name'=>'John Smith',    'course'=>'B.Sc Computer Science','date'=>'Jul 10, 2025','status'=>'Pending',  'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'APP-002','name'=>'Sara Ahmed',    'course'=>'B.A English Literature', 'date'=>'Jul 11, 2025','status'=>'Approved', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'APP-003','name'=>'Ravi Kumar',    'course'=>'B.Com Accounting',       'date'=>'Jul 12, 2025','status'=>'Pending',  'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'APP-004','name'=>'Emily Clark',   'course'=>'B.Sc Physics',           'date'=>'Jul 13, 2025','status'=>'Rejected', 'color'=>'#ef4444','bg'=>'#fee2e2'],
    ['id'=>'APP-005','name'=>'Omar Hassan',   'course'=>'B.E Civil Engineering',  'date'=>'Jul 14, 2025','status'=>'Approved', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'APP-006','name'=>'Priya Sharma',  'course'=>'B.Sc Mathematics',       'date'=>'Jul 15, 2025','status'=>'Pending',  'color'=>'#f59e0b','bg'=>'#fef3c7'],
];
$stats = [
    ['label'=>'Total','value'=>124,'icon'=>'📋','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)'],
    ['label'=>'Pending','value'=>48,'icon'=>'⏳','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)'],
    ['label'=>'Approved','value'=>61,'icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)'],
    ['label'=>'Rejected','value'=>15,'icon'=>'❌','grad'=>'linear-gradient(135deg,#ef4444,#f87171)'],
];
@endphp

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach($stats as $s)
    <div style="background:{{$s['grad']}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s['value']}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s['label']}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s['icon']}}</div>
    </div>
    @endforeach
</div>

<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">All Applications</div>
        <input placeholder="Search..." style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;outline:none;width:200px;">
    </div>
    <table>
        <thead><tr>
            <th>App ID</th><th>Name</th><th>Course</th><th>Date</th><th>Status</th><th>Action</th>
        </tr></thead>
        <tbody>
        @foreach($apps as $a)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$a['id']}}</td>
            <td style="font-weight:600;">{{$a['name']}}</td>
            <td style="color:#64748b;">{{$a['course']}}</td>
            <td style="color:#64748b;">{{$a['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$a['bg']}};color:{{$a['color']}};">{{$a['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
