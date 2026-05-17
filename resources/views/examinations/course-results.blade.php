@extends('layouts.academic')
@section('title', 'Course Results')
@section('heading', 'Course Results')

@section('content')
@php
$courses = [
    ['code'=>'CS201','name'=>'Data Structures',     'students'=>42,'passed'=>38,'failed'=>4,'avg'=>74,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['code'=>'MATH202','name'=>'Calculus II',        'students'=>42,'passed'=>35,'failed'=>7,'avg'=>68,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['code'=>'PHY101','name'=>'Physics Lab',         'students'=>42,'passed'=>40,'failed'=>2,'avg'=>79,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['code'=>'CS301','name'=>'Database Systems',     'students'=>42,'passed'=>41,'failed'=>1,'avg'=>82,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['code'=>'CS302','name'=>'Software Engineering', 'students'=>42,'passed'=>36,'failed'=>6,'avg'=>71,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
@foreach($courses as $c)
@php $passRate=round($c['passed']/$c['students']*100); @endphp
<div class="card" style="padding:20px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:{{$c['bg']}};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:{{$c['color']}};">{{substr($c['code'],0,2)}}</div>
        <div><div style="font-size:14px;font-weight:700;color:#1e293b;">{{$c['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$c['code']}}</div></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:14px;">
        @foreach([['Students',$c['students'],'#1e293b'],['Passed',$c['passed'],'#10b981'],['Failed',$c['failed'],'#ef4444'],['Avg',$c['avg'].'%','#6366f1']] as $stat)
        <div style="background:#f8fafc;border-radius:8px;padding:10px;text-align:center;">
            <div style="font-size:16px;font-weight:800;color:{{$stat[2]}};">{{$stat[1]}}</div>
            <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{$stat[0]}}</div>
        </div>
        @endforeach
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
        <div style="flex:1;height:8px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$passRate}}%;background:{{$c['color']}};border-radius:9999px;"></div></div>
        <span style="font-size:12px;font-weight:700;color:{{$c['color']}};">{{$passRate}}% pass</span>
    </div>
</div>
@endforeach
</div>
@endsection
