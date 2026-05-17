@extends('layouts.academic')
@section('title', 'Manage Leave')
@section('heading', 'Manage Leave — Students')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Leave</a>
@endsection

@section('content')
@php
$leaves = [
    ['id'=>'LV-001','name'=>'Alex Johnson','type'=>'Medical',  'from'=>'Jul 10','to'=>'Jul 12','days'=>3,'status'=>'Approved'],
    ['id'=>'LV-002','name'=>'Sara Ahmed',  'type'=>'Personal', 'from'=>'Jul 14','to'=>'Jul 14','days'=>1,'status'=>'Pending'],
    ['id'=>'LV-003','name'=>'Ravi Kumar',  'type'=>'Family',   'from'=>'Jul 16','to'=>'Jul 18','days'=>3,'status'=>'Approved'],
    ['id'=>'LV-004','name'=>'Emily Clark', 'type'=>'Medical',  'from'=>'Jul 20','to'=>'Jul 22','days'=>3,'status'=>'Rejected'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total','10','📋','linear-gradient(135deg,#6366f1,#818cf8)'],['Approved','6','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','2','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Rejected','2','❌','linear-gradient(135deg,#ef4444,#f87171)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Student</th><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($leaves as $l)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$l['id']}}</td>
            <td style="font-weight:600;">{{$l['name']}}</td>
            <td style="color:#64748b;">{{$l['type']}}</td>
            <td style="color:#64748b;">{{$l['from']}}</td>
            <td style="color:#64748b;">{{$l['to']}}</td>
            <td style="text-align:center;font-weight:700;">{{$l['days']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$l['status']==='Approved'?'#d1fae5':($l['status']==='Pending'?'#fef3c7':'#fee2e2')}};color:{{$l['status']==='Approved'?'#065f46':($l['status']==='Pending'?'#92400e':'#991b1b')}};">{{$l['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
