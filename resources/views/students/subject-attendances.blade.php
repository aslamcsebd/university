@extends('layouts.academic')
@section('title', 'Subject Attendances')
@section('heading', 'Subject Attendances')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Mark Attendance</a>
@endsection

@section('content')
@php
$subjects = [
    ['code'=>'CS201','name'=>'Data Structures',     'staff'=>'Dr. Mitchell', 'total'=>24,'present'=>21,'absent'=>3,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['code'=>'MATH202','name'=>'Calculus II',        'staff'=>'Prof. Okafor', 'total'=>20,'present'=>18,'absent'=>2,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['code'=>'PHY101','name'=>'Physics Lab',         'staff'=>'Dr. Nair',     'total'=>16,'present'=>12,'absent'=>4,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['code'=>'CS301','name'=>'Database Systems',     'staff'=>'Dr. Yusuf',    'total'=>22,'present'=>21,'absent'=>1,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['code'=>'CS302','name'=>'Software Engineering', 'staff'=>'Mr. Hargreaves','total'=>18,'present'=>14,'absent'=>4,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Classes','100','📖','linear-gradient(135deg,#6366f1,#818cf8)'],['Total Present','86','✅','linear-gradient(135deg,#10b981,#34d399)'],['Total Absent','14','❌','linear-gradient(135deg,#ef4444,#f87171)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Code</th><th>Subject</th><th>Staff</th><th>Total</th><th>Present</th><th>Absent</th><th>%</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($subjects as $s)
        @php $pct = round($s['present']/$s['total']*100); $c=$pct>=85?'#10b981':($pct>=75?'#f59e0b':'#ef4444'); @endphp
        <tr>
            <td><span style="padding:3px 8px;border-radius:6px;font-size:11px;font-weight:700;background:{{$s['bg']}};color:{{$s['color']}};">{{$s['code']}}</span></td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['staff']}}</td>
            <td style="text-align:center;">{{$s['total']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$s['present']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$s['absent']}}</td>
            <td style="font-weight:800;color:{{$c}};">{{$pct}}%</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$pct>=75?'#d1fae5':'#fee2e2'}};color:{{$pct>=75?'#065f46':'#991b1b'}};">{{$pct>=75?'OK':'At Risk'}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
