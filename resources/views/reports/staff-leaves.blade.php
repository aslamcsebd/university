@extends('layouts.academic')
@section('title', 'Staff Leaves')
@section('heading', 'Staff Leaves Report')
@section('content')
@php
$records = [
    ['id'=>'STF-010','name'=>'Mr. Adams',  'dept'=>'CS',     'total_leaves'=>15,'used'=>3,'remaining'=>12,'this_month'=>1],
    ['id'=>'STF-011','name'=>'Ms. Rivera', 'dept'=>'Math',   'total_leaves'=>15,'used'=>7,'remaining'=>8, 'this_month'=>2],
    ['id'=>'STF-012','name'=>'Mr. Hassan', 'dept'=>'Physics','total_leaves'=>15,'used'=>0,'remaining'=>15,'this_month'=>0],
    ['id'=>'STF-013','name'=>'Mr. Kumar',  'dept'=>'Commerce','total_leaves'=>15,'used'=>5,'remaining'=>10,'this_month'=>0],
    ['id'=>'STF-014','name'=>'Ms. Patel',  'dept'=>'Arts',   'total_leaves'=>15,'used'=>12,'remaining'=>3,'this_month'=>3],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Department</th><th>Total Leaves</th><th>Used</th><th>Remaining</th><th>This Month</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['dept']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['total_leaves']}}</td>
            <td style="text-align:center;font-weight:700;color:#f59e0b;">{{$r['used']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$r['remaining']}}</td>
            <td style="text-align:center;font-weight:700;color:#6366f1;">{{$r['this_month']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
