@extends('layouts.academic')
@section('title', 'Student Fees')
@section('heading', 'Student Fees Report')
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson','course'=>'B.Sc CS','total'=>'$1,400','paid'=>'$1,400','balance'=>'$0',   'status'=>'Paid'],
    ['id'=>'STU-102','name'=>'Bob Smith',    'course'=>'B.Com',  'total'=>'$1,100','paid'=>'$1,100','balance'=>'$0',   'status'=>'Paid'],
    ['id'=>'STU-103','name'=>'Carol White',  'course'=>'B.Sc CS','total'=>'$1,400','paid'=>'$800', 'balance'=>'$600', 'status'=>'Partial'],
    ['id'=>'STU-104','name'=>'David Brown',  'course'=>'MBA',    'total'=>'$2,800','paid'=>'$0',   'balance'=>'$2,800','status'=>'Unpaid'],
    ['id'=>'STU-105','name'=>'Eva Green',    'course'=>'B.A Eng','total'=>'$980',  'paid'=>'$980', 'balance'=>'$0',   'status'=>'Paid'],
];
$colors = ['Paid'=>['#d1fae5','#065f46'],'Partial'=>['#fef3c7','#92400e'],'Unpaid'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Total</th><th>Paid</th><th>Balance</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="font-weight:700;">{{$s['total']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$s['paid']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$s['balance']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$s['status']][0]}};color:{{$colors[$s['status']][1]}};">{{$s['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
