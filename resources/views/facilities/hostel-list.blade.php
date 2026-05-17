@extends('layouts.academic')
@section('title', 'Hostel List')
@section('heading', 'Hostel List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Hostel</a>
@endsection
@section('content')
@php
$hostels = [
    ['id'=>'HST-001','name'=>'Boys Hostel A','type'=>'Boys', 'rooms'=>40,'capacity'=>160,'occupied'=>142,'warden'=>'Mr. Adams',   'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'HST-002','name'=>'Girls Hostel B','type'=>'Girls','rooms'=>35,'capacity'=>140,'occupied'=>128,'warden'=>'Ms. Rivera',  'color'=>'#ec4899','bg'=>'#fdf2f8'],
    ['id'=>'HST-003','name'=>'Boys Hostel C', 'type'=>'Boys', 'rooms'=>30,'capacity'=>120,'occupied'=>98, 'warden'=>'Mr. Hassan',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Hostels','3','🏠','linear-gradient(135deg,#6366f1,#818cf8)'],['Total Capacity','420','🛏️','linear-gradient(135deg,#10b981,#34d399)'],['Occupied','368','👥','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
@foreach($hostels as $h)
@php $pct=round($h['occupied']/$h['capacity']*100); @endphp
<div class="card" style="padding:20px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:{{$h['bg']}};display:flex;align-items:center;justify-content:center;font-size:22px;">🏠</div>
        <div><div style="font-size:14px;font-weight:700;color:#1e293b;">{{$h['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$h['id']}} · {{$h['type']}}</div></div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
        @foreach([['Rooms',$h['rooms']],['Capacity',$h['capacity']],['Occupied',$h['occupied']],['Available',$h['capacity']-$h['occupied']]] as $stat)
        <div style="background:#f8fafc;border-radius:8px;padding:8px;text-align:center;">
            <div style="font-size:15px;font-weight:800;color:#1e293b;">{{$stat[1]}}</div>
            <div style="font-size:10px;color:#94a3b8;margin-top:1px;">{{$stat[0]}}</div>
        </div>
        @endforeach
    </div>
    <div style="margin-bottom:10px;">
        <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;"><span>Occupancy</span><span style="font-weight:700;color:{{$h['color']}};">{{$pct}}%</span></div>
        <div style="height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:{{$h['color']}};border-radius:9999px;"></div></div>
    </div>
    <div style="font-size:12px;color:#64748b;">Warden: <span style="font-weight:600;color:#1e293b;">{{$h['warden']}}</span></div>
</div>
@endforeach
</div>
@endsection
