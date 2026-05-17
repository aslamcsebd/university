@extends('layouts.academic')
@section('title', 'Teacher Routines')
@section('heading', 'Teacher Routines')

@section('content')
@php
$teachers = [
    ['name'=>'Dr. Mitchell', 'dept'=>'CS',   'classes'=>8,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['name'=>'Prof. Okafor', 'dept'=>'Math', 'classes'=>6,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['name'=>'Dr. Nair',     'dept'=>'Phys', 'classes'=>5,'color'=>'#10b981','bg'=>'#d1fae5'],
];
$days = ['Mon','Tue','Wed','Thu','Fri'];
$routines = [
    'Dr. Mitchell' => ['Mon'=>[['09:00','CS201','Room 101'],['14:00','CS301','Room 102']],'Wed'=>[['09:00','CS201','Room 101']],'Fri'=>[['10:00','CS302','Room 103']]],
    'Prof. Okafor' => ['Tue'=>[['10:00','MATH202','Hall B']],'Thu'=>[['14:00','MATH202','Hall B']]],
    'Dr. Nair'     => ['Wed'=>[['14:00','PHY101','Lab 1']],'Fri'=>[['14:00','PHY101','Lab 1']]],
];
@endphp
<div style="margin-bottom:16px;display:flex;gap:10px;">
    <select class="form-select" style="width:220px;"><option>All Teachers</option>@foreach($teachers as $t)<option>{{$t['name']}}</option>@endforeach</select>
    <select class="form-select" style="width:160px;"><option>This Week</option></select>
</div>
@foreach($teachers as $t)
<div class="card" style="overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:12px;">
        <div style="width:40px;height:40px;border-radius:10px;background:{{$t['bg']}};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:{{$t['color']}};">{{substr($t['name'],3,2)}}</div>
        <div><div style="font-size:14px;font-weight:700;color:#1e293b;">{{$t['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$t['dept']}} · {{$t['classes']}} classes/week</div></div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;padding:14px 16px;">
        @foreach($days as $d)
        <div>
            <div style="font-size:10px;font-weight:700;color:#94a3b8;text-align:center;margin-bottom:6px;">{{$d}}</div>
            @if(isset($routines[$t['name']][$d === 'Mon' ? 'Mon' : ($d === 'Tue' ? 'Tue' : ($d === 'Wed' ? 'Wed' : ($d === 'Thu' ? 'Thu' : 'Fri')))]))
                @foreach($routines[$t['name']][$d === 'Mon' ? 'Mon' : ($d === 'Tue' ? 'Tue' : ($d === 'Wed' ? 'Wed' : ($d === 'Thu' ? 'Thu' : 'Fri')))] as $cls)
                <div style="background:{{$t['bg']}};border-left:3px solid {{$t['color']}};border-radius:6px;padding:6px 8px;margin-bottom:4px;">
                    <div style="font-size:10px;font-weight:700;color:{{$t['color']}};">{{$cls[0]}}</div>
                    <div style="font-size:10px;font-weight:600;color:#1e293b;">{{$cls[1]}}</div>
                    <div style="font-size:9px;color:#94a3b8;">{{$cls[2]}}</div>
                </div>
                @endforeach
            @else
            <div style="height:50px;background:#f8fafc;border-radius:6px;border:1px dashed #e2e8f0;"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endforeach
@endsection
