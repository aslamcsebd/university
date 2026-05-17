@extends('layouts.academic')
@section('title', 'Fees Due')
@section('heading', 'Fees Due')
@section('content')
@php
$fees = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS',  'semester'=>'Sem 3','amount'=>'$1,200','due'=>'2024-02-15','status'=>'Overdue'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',    'semester'=>'Sem 1','amount'=>'$900', 'due'=>'2024-03-01','status'=>'Pending'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS',  'semester'=>'Sem 5','amount'=>'$1,200','due'=>'2024-03-10','status'=>'Pending'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',      'semester'=>'Sem 2','amount'=>'$2,500','due'=>'2024-01-20','status'=>'Overdue'],
    ['id'=>'STU-105','name'=>'Eva Green',    'course'=>'B.A Eng',  'semester'=>'Sem 4','amount'=>'$800', 'due'=>'2024-03-15','status'=>'Pending'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Student ID</th><th>Name</th><th>Course</th><th>Semester</th><th>Amount</th><th>Due Date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($fees as $f)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$f['id']}}</td>
            <td style="font-weight:600;">{{$f['name']}}</td>
            <td style="color:#64748b;">{{$f['course']}}</td>
            <td style="color:#64748b;">{{$f['semester']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$f['amount']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$f['due']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$f['status']==='Overdue'?'#fee2e2':'#fef3c7'}};color:{{$f['status']==='Overdue'?'#991b1b':'#92400e'}};">{{$f['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Collect</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
