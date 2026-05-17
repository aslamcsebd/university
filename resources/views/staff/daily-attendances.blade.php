@extends('layouts.academic')
@section('title', 'Daily Attendances')
@section('heading', 'Daily Attendances')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Mark Attendance</a>
@endsection
@section('content')
@php
$staff = [
    ['id'=>'STF-001','name'=>'Dr. Mitchell',  'in'=>'08:02 AM','out'=>'05:10 PM','hours'=>'9h 8m', 'status'=>'Present'],
    ['id'=>'STF-002','name'=>'Prof. Okafor',  'in'=>'08:15 AM','out'=>'05:00 PM','hours'=>'8h 45m','status'=>'Present'],
    ['id'=>'STF-003','name'=>'Dr. Nair',      'in'=>'—',       'out'=>'—',       'hours'=>'—',     'status'=>'Absent'],
    ['id'=>'STF-004','name'=>'Dr. Yusuf',     'in'=>'09:05 AM','out'=>'05:00 PM','hours'=>'7h 55m','status'=>'Late'],
    ['id'=>'STF-005','name'=>'Mr. Hargreaves','in'=>'—',       'out'=>'—',       'hours'=>'—',     'status'=>'Leave'],
];
@endphp
<div style="display:flex;gap:10px;margin-bottom:16px;align-items:center;">
    <input type="date" class="form-input" style="width:180px;" value="2025-07-15">
    <select class="form-select" style="width:200px;"><option>All Departments</option></select>
    <button class="btn btn-primary">Filter</button>
</div>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Present','3','✅','linear-gradient(135deg,#10b981,#34d399)'],['Absent','1','❌','linear-gradient(135deg,#ef4444,#f87171)'],['Late','1','⏰','linear-gradient(135deg,#f59e0b,#fbbf24)'],['On Leave','1','🏖️','linear-gradient(135deg,#8b5cf6,#a78bfa)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Check In</th><th>Check Out</th><th>Hours</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($staff as $s)
        @php $colors=['Present'=>['#d1fae5','#065f46'],'Absent'=>['#fee2e2','#991b1b'],'Late'=>['#fef3c7','#92400e'],'Leave'=>['#f5f3ff','#6d28d9']]; $c=$colors[$s['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['in']}}</td>
            <td style="color:#64748b;">{{$s['out']}}</td>
            <td style="font-weight:600;">{{$s['hours']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$s['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
