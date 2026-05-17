@extends('layouts.academic')
@section('title', 'Salary Paid')
@section('heading', 'Salary Paid Report')
@section('content')
@php
$records = [
    ['id'=>'STF-010','name'=>'Mr. Adams',  'dept'=>'CS',      'designation'=>'Professor',  'salary'=>'$4,500','paid'=>'$4,500','month'=>'January 2024','status'=>'Paid'],
    ['id'=>'STF-011','name'=>'Ms. Rivera', 'dept'=>'Math',    'designation'=>'Lecturer',   'salary'=>'$3,200','paid'=>'$3,200','month'=>'January 2024','status'=>'Paid'],
    ['id'=>'STF-012','name'=>'Mr. Hassan', 'dept'=>'Physics', 'designation'=>'Lecturer',   'salary'=>'$3,200','paid'=>'$0',   'month'=>'January 2024','status'=>'Pending'],
    ['id'=>'STF-013','name'=>'Mr. Kumar',  'dept'=>'Commerce','designation'=>'Asst. Prof', 'salary'=>'$3,800','paid'=>'$3,800','month'=>'January 2024','status'=>'Paid'],
    ['id'=>'STF-014','name'=>'Ms. Patel',  'dept'=>'Arts',    'designation'=>'Lecturer',   'salary'=>'$3,000','paid'=>'$3,000','month'=>'January 2024','status'=>'Paid'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Department</th><th>Designation</th><th>Salary</th><th>Paid</th><th>Month</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['dept']}}</td>
            <td style="color:#64748b;">{{$r['designation']}}</td>
            <td style="font-weight:700;">{{$r['salary']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$r['paid']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['month']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Paid'?'#d1fae5':'#fef3c7'}};color:{{$r['status']==='Paid'?'#065f46':'#92400e'}};">{{$r['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
