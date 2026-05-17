@extends('layouts.academic')
@section('title', 'Manage Exams')
@section('heading', 'Manage Exams')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Exam</a>
@endsection

@section('content')
@php
$exams = [
    ['id'=>'EXM-001','name'=>'Mid-Term Exam 2025','type'=>'Mid-Term','program'=>'B.Sc CS','semester'=>'Sem 3','start'=>'Jul 18, 2025','end'=>'Jul 25, 2025','status'=>'Upcoming'],
    ['id'=>'EXM-002','name'=>'Final Exam 2025',   'type'=>'Final',   'program'=>'B.Sc CS','semester'=>'Sem 3','start'=>'Nov 10, 2025','end'=>'Nov 20, 2025','status'=>'Scheduled'],
    ['id'=>'EXM-003','name'=>'Mid-Term Exam 2025','type'=>'Mid-Term','program'=>'B.E Civil','semester'=>'Sem 4','start'=>'Jul 20, 2025','end'=>'Jul 28, 2025','status'=>'Upcoming'],
    ['id'=>'EXM-004','name'=>'Supplementary 2024','type'=>'Supplementary','program'=>'B.Com','semester'=>'Sem 5','start'=>'Aug 05, 2025','end'=>'Aug 10, 2025','status'=>'Scheduled'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Exams','4','📝','linear-gradient(135deg,#6366f1,#818cf8)'],['Upcoming','2','⏰','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Scheduled','2','📅','linear-gradient(135deg,#0ea5e9,#38bdf8)'],['Completed','8','✅','linear-gradient(135deg,#10b981,#34d399)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Exam Name</th><th>Type</th><th>Program</th><th>Semester</th><th>Start</th><th>End</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($exams as $e)
        @php $colors=['Upcoming'=>['#fef3c7','#92400e'],'Scheduled'=>['#dbeafe','#1e40af'],'Completed'=>['#d1fae5','#065f46']]; $c=$colors[$e['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$e['id']}}</td>
            <td style="font-weight:600;">{{$e['name']}}</td>
            <td style="color:#64748b;">{{$e['type']}}</td>
            <td style="color:#64748b;">{{$e['program']}}</td>
            <td style="color:#64748b;">{{$e['semester']}}</td>
            <td style="color:#64748b;">{{$e['start']}}</td>
            <td style="color:#64748b;">{{$e['end']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$e['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
