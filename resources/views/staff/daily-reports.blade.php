@extends('layouts.academic')
@section('title', 'Daily Reports')
@section('heading', 'Daily Reports')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection
@section('content')
@php
$days = [
    ['date'=>'Jul 15','present'=>21,'absent'=>1,'late'=>1,'leave'=>1,'total'=>24],
    ['date'=>'Jul 14','present'=>22,'absent'=>1,'late'=>0,'leave'=>1,'total'=>24],
    ['date'=>'Jul 13','present'=>20,'absent'=>2,'late'=>1,'leave'=>1,'total'=>24],
    ['date'=>'Jul 12','present'=>23,'absent'=>0,'late'=>1,'leave'=>0,'total'=>24],
    ['date'=>'Jul 11','present'=>22,'absent'=>1,'late'=>0,'leave'=>1,'total'=>24],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <input type="month" class="form-input" style="width:180px;" value="2025-07">
        <select class="form-select" style="width:200px;"><option>All Departments</option></select>
        <button class="btn btn-primary">Filter</button>
    </div>
    <table>
        <thead><tr><th>Date</th><th style="text-align:center;">Total</th><th style="text-align:center;">Present</th><th style="text-align:center;">Absent</th><th style="text-align:center;">Late</th><th style="text-align:center;">Leave</th><th>Attendance %</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($days as $d)
        @php $pct=round($d['present']/$d['total']*100); @endphp
        <tr>
            <td style="font-weight:700;">{{$d['date']}}, 2025</td>
            <td style="text-align:center;">{{$d['total']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$d['present']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$d['absent']}}</td>
            <td style="text-align:center;font-weight:700;color:#f59e0b;">{{$d['late']}}</td>
            <td style="text-align:center;font-weight:700;color:#8b5cf6;">{{$d['leave']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="flex:1;height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:#10b981;border-radius:9999px;"></div></div>
                    <span style="font-size:12px;font-weight:700;color:#10b981;">{{$pct}}%</span>
                </div>
            </td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
