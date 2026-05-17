@extends('layouts.academic')
@section('title', 'Course Mark Ledger')
@section('heading', 'Course Mark Ledger')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'mid'=>78,'assignment'=>18,'quiz'=>14,'final'=>72,'total'=>182],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'mid'=>85,'assignment'=>20,'quiz'=>16,'final'=>80,'total'=>201],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'mid'=>62,'assignment'=>14,'quiz'=>10,'final'=>58,'total'=>144],
    ['id'=>'STU-004','name'=>'Emily Clark',  'mid'=>91,'assignment'=>19,'quiz'=>17,'final'=>88,'total'=>215],
    ['id'=>'STU-005','name'=>'Omar Hassan',  'mid'=>55,'assignment'=>12,'quiz'=>9, 'final'=>50,'total'=>126],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;align-items:center;">
        <select class="form-select" style="width:200px;"><option>CS201 — Data Structures</option></select>
        <select class="form-select" style="width:160px;"><option>Semester 3</option></select>
    </div>
    <div style="padding:12px 20px;background:#f8fafc;border-bottom:1px solid #f1f5f9;display:flex;gap:20px;font-size:12px;color:#64748b;">
        <span>Mid-Term: <strong>100 marks</strong></span>
        <span>Assignment: <strong>20 marks</strong></span>
        <span>Quiz: <strong>20 marks</strong></span>
        <span>Final: <strong>100 marks</strong></span>
        <span>Total: <strong>240 marks</strong></span>
    </div>
    <table>
        <thead><tr><th>Student</th><th style="text-align:center;">Mid-Term /100</th><th style="text-align:center;">Assignment /20</th><th style="text-align:center;">Quiz /20</th><th style="text-align:center;">Final /100</th><th style="text-align:center;">Total /240</th><th style="text-align:center;">Grade</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        @php $pct=round($s['total']/240*100); $grade=$pct>=90?'A+':($pct>=80?'A':($pct>=70?'B+':($pct>=60?'B':($pct>=50?'C':'F')))); $gc=$pct>=50?'#10b981':'#ef4444'; @endphp
        <tr>
            <td><div style="font-weight:600;">{{$s['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$s['id']}}</div></td>
            <td style="text-align:center;font-weight:600;">{{$s['mid']}}</td>
            <td style="text-align:center;font-weight:600;">{{$s['assignment']}}</td>
            <td style="text-align:center;font-weight:600;">{{$s['quiz']}}</td>
            <td style="text-align:center;font-weight:600;">{{$s['final']}}</td>
            <td style="text-align:center;font-weight:800;color:#1e293b;">{{$s['total']}}</td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:800;background:{{$pct>=50?'#d1fae5':'#fee2e2'}};color:{{$gc}};">{{$grade}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
