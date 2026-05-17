@extends('layouts.academic')
@section('title', 'Payroll Reports')
@section('heading', 'Payroll Reports')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection
@section('content')
@php
$months = [
    ['month'=>'July 2025',    'staff'=>24,'total'=>22150,'paid'=>18500,'pending'=>3650],
    ['month'=>'June 2025',    'staff'=>24,'total'=>22150,'paid'=>22150,'pending'=>0],
    ['month'=>'May 2025',     'staff'=>23,'total'=>21500,'paid'=>21500,'pending'=>0],
    ['month'=>'April 2025',   'staff'=>23,'total'=>21500,'paid'=>21500,'pending'=>0],
    ['month'=>'March 2025',   'staff'=>22,'total'=>20800,'paid'=>20800,'pending'=>0],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Paid (2025)','$107,450','💰','linear-gradient(135deg,#10b981,#34d399)'],['Pending','$3,650','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Avg Monthly','$21,490','📊','linear-gradient(135deg,#6366f1,#818cf8)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:22px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:28px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Month</th><th>Staff Count</th><th>Total Payroll</th><th>Paid</th><th>Pending</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($months as $m)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$m['month']}}</td>
            <td style="text-align:center;">{{$m['staff']}}</td>
            <td style="font-weight:600;">${{number_format($m['total'])}}</td>
            <td style="font-weight:600;color:#10b981;">${{number_format($m['paid'])}}</td>
            <td style="font-weight:600;color:{{$m['pending']>0?'#ef4444':'#94a3b8'}};">${{number_format($m['pending'])}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$m['pending']==0?'#d1fae5':'#fef3c7'}};color:{{$m['pending']==0?'#065f46':'#92400e'}};">{{$m['pending']==0?'Complete':'Partial'}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
