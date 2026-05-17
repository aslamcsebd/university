@extends('layouts.academic')
@section('title', 'Transfer Out')
@section('heading', 'Transfer Out')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ New Transfer Out</a>
@endsection

@section('content')
@php
$transfers = [
    ['id'=>'TRF-OUT-001','name'=>'James Wilson',  'to'=>'Metro University', 'course'=>'B.Sc CS',    'date'=>'Jun 20, 2025','status'=>'Approved'],
    ['id'=>'TRF-OUT-002','name'=>'Fatima Noor',   'to'=>'National College', 'course'=>'B.A English', 'date'=>'Jun 25, 2025','status'=>'Pending'],
    ['id'=>'TRF-OUT-003','name'=>'Carlos Rivera',  'to'=>'Tech Academy',    'course'=>'B.E Mech',   'date'=>'Jul 02, 2025','status'=>'Approved'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Transfers Out','3','📤','linear-gradient(135deg,#8b5cf6,#a78bfa)'],['Approved','2','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','1','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Student Name</th><th>To Institution</th><th>Course</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($transfers as $t)
        <tr>
            <td style="font-weight:700;color:#8b5cf6;">{{$t['id']}}</td>
            <td style="font-weight:600;">{{$t['name']}}</td>
            <td style="color:#64748b;">{{$t['to']}}</td>
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
