@extends('layouts.academic')
@section('title', 'Student Progress')
@section('heading', 'Student Progress Report')
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS','sem'=>'Sem 3','attendance'=>'92%','gpa'=>'3.8','assignments'=>'18/20','status'=>'Excellent'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',  'sem'=>'Sem 1','attendance'=>'78%','gpa'=>'3.2','assignments'=>'14/20','status'=>'Good'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS','sem'=>'Sem 5','attendance'=>'95%','gpa'=>'3.9','assignments'=>'20/20','status'=>'Excellent'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',    'sem'=>'Sem 2','attendance'=>'65%','gpa'=>'2.8','assignments'=>'10/20','status'=>'At Risk'],
    ['id'=>'STU-105','name'=>'Eva Green',    'course'=>'B.A Eng','sem'=>'Sem 4','attendance'=>'85%','gpa'=>'3.5','assignments'=>'16/20','status'=>'Good'],
];
$sc = ['Excellent'=>['#d1fae5','#065f46'],'Good'=>['#dbeafe','#1e40af'],'At Risk'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Semester</th><th>Attendance</th><th>GPA</th><th>Assignments</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="color:#64748b;">{{$s['sem']}}</td>
            <td style="font-weight:700;color:{{(int)$s['attendance']>=80?'#10b981':'#ef4444'}};">{{$s['attendance']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$s['gpa']}}</td>
            <td style="color:#64748b;">{{$s['assignments']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$sc[$s['status']][0]}};color:{{$sc[$s['status']][1]}};">{{$s['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
