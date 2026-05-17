@extends('layouts.academic')
@section('title', 'Hostel Members')
@section('heading', 'Hostel Members Report')
@section('content')
@php
$hostels = [
    ['name'=>'Boys Hostel A', 'capacity'=>60,'students'=>52,'staff'=>3,'vacant'=>8, 'occupancy'=>'87%'],
    ['name'=>'Girls Hostel B','capacity'=>50,'students'=>48,'staff'=>2,'vacant'=>2, 'occupancy'=>'96%'],
    ['name'=>'Boys Hostel C', 'capacity'=>40,'students'=>35,'staff'=>2,'vacant'=>5, 'occupancy'=>'88%'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Hostel</th><th>Capacity</th><th>Students</th><th>Staff</th><th>Vacant</th><th>Occupancy</th></tr></thead>
        <tbody>
        @foreach($hostels as $h)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$h['name']}}</td>
            <td style="text-align:center;font-weight:700;">{{$h['capacity']}}</td>
            <td style="text-align:center;font-weight:700;color:#6366f1;">{{$h['students']}}</td>
            <td style="text-align:center;font-weight:700;color:#f59e0b;">{{$h['staff']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$h['vacant']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$h['occupancy']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
