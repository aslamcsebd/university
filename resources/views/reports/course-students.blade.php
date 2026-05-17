@extends('layouts.academic')
@section('title', 'Course Students')
@section('heading', 'Course Students Report')
@section('content')
@php
$courses = [
    ['code'=>'CS101','name'=>'B.Sc Computer Science','dept'=>'CS',     'enrolled'=>42,'active'=>40,'graduated'=>0, 'dropped'=>2],
    ['code'=>'COM101','name'=>'B.Com',               'dept'=>'Commerce','enrolled'=>38,'active'=>36,'graduated'=>0, 'dropped'=>2],
    ['code'=>'MBA101','name'=>'MBA',                  'dept'=>'Business','enrolled'=>25,'active'=>24,'graduated'=>0, 'dropped'=>1],
    ['code'=>'ENG101','name'=>'B.A English',          'dept'=>'Arts',    'enrolled'=>30,'active'=>28,'graduated'=>0, 'dropped'=>2],
    ['code'=>'CS201','name'=>'M.Sc Computer Science', 'dept'=>'CS',     'enrolled'=>18,'active'=>18,'graduated'=>0, 'dropped'=>0],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Code</th><th>Course</th><th>Department</th><th>Enrolled</th><th>Active</th><th>Graduated</th><th>Dropped</th></tr></thead>
        <tbody>
        @foreach($courses as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['code']}}</td>
            <td style="font-weight:600;">{{$c['name']}}</td>
            <td style="color:#64748b;">{{$c['dept']}}</td>
            <td style="text-align:center;font-weight:700;">{{$c['enrolled']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$c['active']}}</td>
            <td style="text-align:center;font-weight:700;color:#6366f1;">{{$c['graduated']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$c['dropped']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
