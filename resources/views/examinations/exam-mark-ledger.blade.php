@extends('layouts.academic')
@section('title', 'Exam Mark Ledger')
@section('heading', 'Exam Mark Ledger')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'cs201'=>78,'math202'=>82,'phy101'=>71,'cs301'=>88,'cs302'=>75],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'cs201'=>85,'math202'=>90,'phy101'=>80,'cs301'=>92,'cs302'=>88],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'cs201'=>62,'math202'=>70,'phy101'=>65,'cs301'=>74,'cs302'=>68],
    ['id'=>'STU-004','name'=>'Emily Clark',  'cs201'=>91,'math202'=>88,'phy101'=>85,'cs301'=>94,'cs302'=>90],
    ['id'=>'STU-005','name'=>'Omar Hassan',  'cs201'=>55,'math202'=>60,'phy101'=>58,'cs301'=>65,'cs302'=>62],
];
$subjects = ['CS201','MATH202','PHY101','CS301','CS302'];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <select class="form-select" style="width:180px;"><option>Mid-Term 2025</option></select>
        <select class="form-select" style="width:180px;"><option>B.Sc CS — Sem 3</option></select>
    </div>
    <div style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
                <th>Student</th>
                @foreach($subjects as $s)<th style="text-align:center;">{{$s}}</th>@endforeach
                <th style="text-align:center;">Total</th><th style="text-align:center;">%</th><th style="text-align:center;">Grade</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $s)
        @php
            $marks = [$s['cs201'],$s['math202'],$s['phy101'],$s['cs301'],$s['cs302']];
            $total = array_sum($marks); $pct = round($total/500*100);
            $grade = $pct>=90?'A+':($pct>=80?'A':($pct>=70?'B+':($pct>=60?'B':($pct>=50?'C':'F'))));
            $gc = $pct>=60?'#10b981':'#ef4444';
        @endphp
        <tr>
            <td><div style="font-weight:600;">{{$s['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$s['id']}}</div></td>
            @foreach($marks as $m)
            <td style="text-align:center;font-weight:600;color:{{$m>=50?'#1e293b':'#ef4444'}};">{{$m}}</td>
            @endforeach
            <td style="text-align:center;font-weight:800;color:#1e293b;">{{$total}}</td>
            <td style="text-align:center;font-weight:700;color:{{$gc}};">{{$pct}}%</td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:800;background:{{$pct>=60?'#d1fae5':'#fee2e2'}};color:{{$gc}};">{{$grade}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
