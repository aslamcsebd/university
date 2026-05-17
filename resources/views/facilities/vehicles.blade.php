@extends('layouts.academic')
@section('title', 'Vehicles')
@section('heading', 'Vehicles')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Vehicle</a>
@endsection
@section('content')
@php
$vehicles = [
    ['id'=>'VEH-001','number'=>'ABC-1234','type'=>'Bus',  'capacity'=>40,'driver'=>'Mr. Johnson','route'=>'Route A','status'=>'Active'],
    ['id'=>'VEH-002','number'=>'DEF-5678','type'=>'Bus',  'capacity'=>40,'driver'=>'Mr. Patel',  'route'=>'Route B','status'=>'Active'],
    ['id'=>'VEH-003','number'=>'GHI-9012','type'=>'Van',  'capacity'=>15,'driver'=>'Mr. Lee',    'route'=>'Route C','status'=>'Active'],
    ['id'=>'VEH-004','number'=>'JKL-3456','type'=>'Bus',  'capacity'=>40,'driver'=>'Mr. Ahmed',  'route'=>'Route D','status'=>'Maintenance'],
    ['id'=>'VEH-005','number'=>'MNO-7890','type'=>'Minibus','capacity'=>25,'driver'=>'Mr. Clark','route'=>'Route E','status'=>'Active'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Vehicles','5','🚌','linear-gradient(135deg,#6366f1,#818cf8)'],['Active','4','✅','linear-gradient(135deg,#10b981,#34d399)'],['Maintenance','1','🔧','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Total Capacity','160','👥','linear-gradient(135deg,#8b5cf6,#a78bfa)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Vehicle No.</th><th>Type</th><th>Capacity</th><th>Driver</th><th>Route</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($vehicles as $v)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$v['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$v['number']}}</td>
            <td style="color:#64748b;">{{$v['type']}}</td>
            <td style="text-align:center;font-weight:700;">{{$v['capacity']}}</td>
            <td style="color:#64748b;">{{$v['driver']}}</td>
            <td style="color:#64748b;">{{$v['route']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$v['status']==='Active'?'#d1fae5':'#fef3c7'}};color:{{$v['status']==='Active'?'#065f46':'#92400e'}};">{{$v['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
