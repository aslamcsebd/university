@extends('layouts.academic')
@section('title', 'Class Rooms')
@section('heading', 'Class Rooms')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Room</a>
@endsection

@section('content')
@php
$rooms = [
    ['id'=>'CR-001','name'=>'Room 101','building'=>'Block A','type'=>'Lecture','capacity'=>50,'status'=>'Available','features'=>['Projector','AC','WiFi']],
    ['id'=>'CR-002','name'=>'Room 102','building'=>'Block A','type'=>'Lecture','capacity'=>50,'status'=>'Occupied', 'features'=>['Projector','AC']],
    ['id'=>'CR-003','name'=>'Lab 1',   'building'=>'Block B','type'=>'Lab',    'capacity'=>30,'status'=>'Available','features'=>['Computers','AC','WiFi']],
    ['id'=>'CR-004','name'=>'Hall A',  'building'=>'Block C','type'=>'Hall',   'capacity'=>200,'status'=>'Available','features'=>['Projector','AC','Mic']],
    ['id'=>'CR-005','name'=>'Lab 2',   'building'=>'Block B','type'=>'Lab',    'capacity'=>30,'status'=>'Maintenance','features'=>['Computers']],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Rooms','5','🏫','linear-gradient(135deg,#6366f1,#818cf8)'],['Available','3','✅','linear-gradient(135deg,#10b981,#34d399)'],['Occupied','1','🔴','linear-gradient(135deg,#ef4444,#f87171)'],['Maintenance','1','🔧','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Room</th><th>Building</th><th>Type</th><th>Capacity</th><th>Features</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($rooms as $r)
        @php $colors=['Available'=>['#d1fae5','#065f46'],'Occupied'=>['#fee2e2','#991b1b'],'Maintenance'=>['#fef3c7','#92400e']]; $c=$colors[$r['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['building']}}</td>
            <td style="color:#64748b;">{{$r['type']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['capacity']}}</td>
            <td><div style="display:flex;gap:4px;flex-wrap:wrap;">@foreach($r['features'] as $f)<span style="padding:2px 6px;background:#f1f5f9;border-radius:4px;font-size:10px;color:#475569;">{{$f}}</span>@endforeach</div></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$r['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
