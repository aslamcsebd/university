@extends('layouts.academic')
@section('title', 'Sessions')
@section('heading', 'Sessions')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Session</a>
@endsection

@section('content')
@php
$sessions = [
    ['id'=>'SES-001','name'=>'2025-2026','start'=>'Sep 01, 2025','end'=>'Jun 30, 2026','semesters'=>2,'status'=>'Upcoming'],
    ['id'=>'SES-002','name'=>'2024-2025','start'=>'Sep 01, 2024','end'=>'Jun 30, 2025','semesters'=>2,'status'=>'Active'],
    ['id'=>'SES-003','name'=>'2023-2024','start'=>'Sep 01, 2023','end'=>'Jun 30, 2024','semesters'=>2,'status'=>'Completed'],
    ['id'=>'SES-004','name'=>'2022-2023','start'=>'Sep 01, 2022','end'=>'Jun 30, 2023','semesters'=>2,'status'=>'Completed'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Current Session','2024-2025','📅','linear-gradient(135deg,#6366f1,#818cf8)'],['Active Semesters','2','📖','linear-gradient(135deg,#10b981,#34d399)'],['Total Sessions','4','🗂️','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:22px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Session</th><th>Start Date</th><th>End Date</th><th>Semesters</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($sessions as $s)
        @php $colors=['Active'=>['#d1fae5','#065f46'],'Upcoming'=>['#dbeafe','#1e40af'],'Completed'=>['#f3f4f6','#374151']]; $c=$colors[$s['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:700;font-size:14px;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['start']}}</td>
            <td style="color:#64748b;">{{$s['end']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['semesters']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
