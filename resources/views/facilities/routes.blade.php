@extends('layouts.academic')
@section('title', 'Routes')
@section('heading', 'Routes')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Route</a>
@endsection
@section('content')
@php
$routes = [
    ['id'=>'RT-001','name'=>'Route A','from'=>'City Center','to'=>'Campus Gate 1','stops'=>6,'vehicles'=>2,'status'=>'Active'],
    ['id'=>'RT-002','name'=>'Route B','from'=>'North Zone', 'to'=>'Campus Gate 2','stops'=>5,'vehicles'=>1,'status'=>'Active'],
    ['id'=>'RT-003','name'=>'Route C','from'=>'East Side',  'to'=>'Campus Gate 1','stops'=>4,'vehicles'=>1,'status'=>'Active'],
    ['id'=>'RT-004','name'=>'Route D','from'=>'West End',   'to'=>'Campus Gate 3','stops'=>7,'vehicles'=>1,'status'=>'Inactive'],
    ['id'=>'RT-005','name'=>'Route E','from'=>'South Park', 'to'=>'Campus Gate 2','stops'=>5,'vehicles'=>1,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>From</th><th>To</th><th>Stops</th><th>Vehicles</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($routes as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['from']}}</td>
            <td style="color:#64748b;">{{$r['to']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['stops']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['vehicles']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$r['status']==='Active'?'#065f46':'#991b1b'}};">{{$r['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
