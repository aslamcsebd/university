@extends('layouts.academic')
@section('title', 'Alumni List')
@section('heading', 'Alumni List')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection

@section('content')
@php
$alumni = [
    ['id'=>'ALM-001','name'=>'Chris Evans',  'course'=>'B.Sc CS',    'year'=>2022,'job'=>'Software Engineer @ Google',   'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'ALM-002','name'=>'Nina Patel',   'course'=>'B.Com',      'year'=>2021,'job'=>'Financial Analyst @ KPMG',     'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'ALM-003','name'=>'Sam Torres',   'course'=>'B.E Civil',  'year'=>2023,'job'=>'Civil Engineer @ Bechtel',     'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'ALM-004','name'=>'Lily Zhang',   'course'=>'B.A English','year'=>2022,'job'=>'Content Writer @ HubSpot',     'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'ALM-005','name'=>'Mark Johnson', 'course'=>'B.Sc Math',  'year'=>2020,'job'=>'Data Scientist @ Amazon',      'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Alumni','546','🎓','linear-gradient(135deg,#6366f1,#818cf8)'],['Employed','489','💼','linear-gradient(135deg,#10b981,#34d399)'],['This Year','38','📅','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Grad Year</th><th>Current Position</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($alumni as $a)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$a['id']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:{{$a['bg']}};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{$a['color']}};">{{substr($a['name'],0,2)}}</div>
                    <span style="font-weight:600;">{{$a['name']}}</span>
                </div>
            </td>
            <td style="color:#64748b;">{{$a['course']}}</td>
            <td style="text-align:center;font-weight:700;">{{$a['year']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$a['job']}}</td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
