@extends('layouts.academic')
@section('title', 'Transfer In')
@section('heading', 'Transfer In')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ New Transfer In</a>
@endsection

@section('content')
@php
$transfers = [
    ['id'=>'TRF-IN-001','name'=>'Michael Brown', 'from'=>'City College',    'course'=>'B.Sc CS',   'date'=>'Jul 01, 2025','status'=>'Approved'],
    ['id'=>'TRF-IN-002','name'=>'Aisha Malik',   'from'=>'State University','course'=>'B.A English','date'=>'Jul 05, 2025','status'=>'Pending'],
    ['id'=>'TRF-IN-003','name'=>'David Lee',     'from'=>'Tech Institute',  'course'=>'B.E Civil', 'date'=>'Jul 08, 2025','status'=>'Approved'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Transfers In','3','📥','linear-gradient(135deg,#6366f1,#818cf8)'],['Approved','2','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','1','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Student Name</th><th>From Institution</th><th>Course</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($transfers as $t)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$t['id']}}</td>
            <td style="font-weight:600;">{{$t['name']}}</td>
            <td style="color:#64748b;">{{$t['from']}}</td>
            <td style="color:#64748b;">{{$t['course']}}</td>
            <td style="color:#64748b;">{{$t['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$t['status']==='Approved'?'#d1fae5':'#fef3c7'}};color:{{$t['status']==='Approved'?'#065f46':'#92400e'}};">{{$t['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
