@extends('layouts.academic')
@section('title', 'Transport Members')
@section('heading', 'Transport Members Report')
@section('content')
@php
$routes = [
    ['route'=>'Route A','vehicle'=>'ABC-1234','capacity'=>40,'students'=>32,'staff'=>2,'total'=>34,'occupancy'=>'85%'],
    ['route'=>'Route B','vehicle'=>'DEF-5678','capacity'=>40,'students'=>28,'staff'=>1,'total'=>29,'occupancy'=>'73%'],
    ['route'=>'Route C','vehicle'=>'GHI-9012','capacity'=>15,'students'=>12,'staff'=>1,'total'=>13,'occupancy'=>'87%'],
    ['route'=>'Route E','vehicle'=>'MNO-7890','capacity'=>25,'students'=>20,'staff'=>2,'total'=>22,'occupancy'=>'88%'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Route</th><th>Vehicle</th><th>Capacity</th><th>Students</th><th>Staff</th><th>Total</th><th>Occupancy</th></tr></thead>
        <tbody>
        @foreach($routes as $r)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$r['route']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['vehicle']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['capacity']}}</td>
            <td style="text-align:center;font-weight:700;color:#6366f1;">{{$r['students']}}</td>
            <td style="text-align:center;font-weight:700;color:#f59e0b;">{{$r['staff']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['total']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$r['occupancy']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
