@extends('layouts.academic')
@section('title', 'Hostel Rooms')
@section('heading', 'Hostel Rooms')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Room</a>
@endsection
@section('content')
@php
$rooms = [
    ['id'=>'HR-101','hostel'=>'Boys Hostel A','type'=>'Double','capacity'=>2,'occupied'=>2,'status'=>'Full',     'floor'=>'1st'],
    ['id'=>'HR-102','hostel'=>'Boys Hostel A','type'=>'Double','capacity'=>2,'occupied'=>1,'status'=>'Available','floor'=>'1st'],
    ['id'=>'HR-103','hostel'=>'Boys Hostel A','type'=>'Single','capacity'=>1,'occupied'=>1,'status'=>'Full',     'floor'=>'1st'],
    ['id'=>'HR-201','hostel'=>'Girls Hostel B','type'=>'Triple','capacity'=>3,'occupied'=>3,'status'=>'Full',    'floor'=>'2nd'],
    ['id'=>'HR-202','hostel'=>'Girls Hostel B','type'=>'Double','capacity'=>2,'occupied'=>0,'status'=>'Available','floor'=>'2nd'],
];
@endphp
<div style="display:flex;gap:10px;margin-bottom:16px;">
    <select class="form-select" style="width:200px;"><option>All Hostels</option><option>Boys Hostel A</option><option>Girls Hostel B</option></select>
    <select class="form-select" style="width:160px;"><option>All Status</option><option>Available</option><option>Full</option></select>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Room ID</th><th>Hostel</th><th>Floor</th><th>Type</th><th>Capacity</th><th>Occupied</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($rooms as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="color:#64748b;">{{$r['hostel']}}</td>
            <td style="color:#64748b;">{{$r['floor']}}</td>
            <td style="color:#64748b;">{{$r['type']}}</td>
            <td style="text-align:center;">{{$r['capacity']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['occupied']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Available'?'#d1fae5':'#fee2e2'}};color:{{$r['status']==='Available'?'#065f46':'#991b1b'}};">{{$r['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#f59e0b;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
