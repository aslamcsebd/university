@extends('layouts.academic')
@section('title', 'Subject Attendance')
@section('heading', 'Subject Attendance Report')
@section('content')
@php
$subjects = [
    ['code'=>'CS301','name'=>'Data Structures',    'teacher'=>'Mr. Adams',  'classes'=>20,'avg_attendance'=>'88%','below_75'=>3],
    ['code'=>'CS302','name'=>'Algorithms',          'teacher'=>'Ms. Rivera', 'classes'=>18,'avg_attendance'=>'82%','below_75'=>5],
    ['code'=>'CS303','name'=>'Database Systems',    'teacher'=>'Mr. Hassan', 'classes'=>22,'avg_attendance'=>'91%','below_75'=>1],
    ['code'=>'CS304','name'=>'Operating Systems',   'teacher'=>'Ms. Patel',  'classes'=>20,'avg_attendance'=>'75%','below_75'=>8],
    ['code'=>'CS305','name'=>'Computer Networks',   'teacher'=>'Mr. Kumar',  'classes'=>16,'avg_attendance'=>'94%','below_75'=>0],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Code</th><th>Subject</th><th>Teacher</th><th>Classes Held</th><th>Avg Attendance</th><th>Below 75%</th></tr></thead>
        <tbody>
        @foreach($subjects as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['code']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['teacher']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['classes']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$s['avg_attendance']}}</td>
            <td style="text-align:center;font-weight:700;color:{{$s['below_75']>0?'#ef4444':'#10b981'}};">{{$s['below_75']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
