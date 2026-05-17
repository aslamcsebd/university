@extends('layouts.academic')
@section('title', 'Student Attendance')
@section('heading', 'Student Attendance Report')
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS','total'=>60,'present'=>55,'absent'=>5, 'pct'=>'92%','status'=>'Good'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',  'total'=>60,'present'=>47,'absent'=>13,'pct'=>'78%','status'=>'Warning'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS','total'=>60,'present'=>57,'absent'=>3, 'pct'=>'95%','status'=>'Good'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',    'total'=>60,'present'=>39,'absent'=>21,'pct'=>'65%','status'=>'Critical'],
    ['id'=>'STU-105','name'=>'Eva Green',    'course'=>'B.A Eng','total'=>60,'present'=>51,'absent'=>9, 'pct'=>'85%','status'=>'Good'],
];
$sc = ['Good'=>['#d1fae5','#065f46'],'Warning'=>['#fef3c7','#92400e'],'Critical'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Total Days</th><th>Present</th><th>Absent</th><th>Percentage</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['total']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$s['present']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$s['absent']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$s['pct']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$sc[$s['status']][0]}};color:{{$sc[$s['status']][1]}};">{{$s['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
