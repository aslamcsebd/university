@extends('layouts.academic')
@section('title', 'Total Marksheets')
@section('heading', 'Total Marksheets')
@section('content')
@php
$marksheets = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS','semesters'=>6,'cgpa'=>'3.75','grade'=>'A', 'status'=>'Completed'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',  'semesters'=>2,'cgpa'=>'3.10','grade'=>'B', 'status'=>'In Progress'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS','semesters'=>6,'cgpa'=>'3.90','grade'=>'A+','status'=>'Completed'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',    'semesters'=>4,'cgpa'=>'2.95','grade'=>'C+','status'=>'In Progress'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Student ID</th><th>Name</th><th>Course</th><th>Semesters</th><th>CGPA</th><th>Grade</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($marksheets as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['name']}}</td>
            <td style="color:#64748b;">{{$m['course']}}</td>
            <td style="text-align:center;font-weight:700;">{{$m['semesters']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$m['cgpa']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$m['grade']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$m['status']==='Completed'?'#d1fae5':'#fef3c7'}};color:{{$m['status']==='Completed'?'#065f46':'#92400e'}};">{{$m['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Print</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
