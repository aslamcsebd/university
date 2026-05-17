@extends('layouts.academic')
@section('title', 'Semester Marksheets')
@section('heading', 'Semester Marksheets')
@section('content')
@php
$marksheets = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS','semester'=>'Sem 3','gpa'=>'3.8','grade'=>'A','status'=>'Published'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',  'semester'=>'Sem 1','gpa'=>'3.2','grade'=>'B','status'=>'Published'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS','semester'=>'Sem 5','gpa'=>'3.9','grade'=>'A+','status'=>'Published'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',    'semester'=>'Sem 2','gpa'=>'2.8','grade'=>'C','status'=>'Draft'],
    ['id'=>'STU-105','name'=>'Eva Green',    'course'=>'B.A Eng','semester'=>'Sem 4','gpa'=>'3.5','grade'=>'B+','status'=>'Published'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Student ID</th><th>Name</th><th>Course</th><th>Semester</th><th>GPA</th><th>Grade</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($marksheets as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['name']}}</td>
            <td style="color:#64748b;">{{$m['course']}}</td>
            <td style="color:#64748b;">{{$m['semester']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$m['gpa']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$m['grade']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$m['status']==='Published'?'#d1fae5':'#fef3c7'}};color:{{$m['status']==='Published'?'#065f46':'#92400e'}};">{{$m['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Print</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
