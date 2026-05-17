@extends('layouts.academic')
@section('title', 'Visit Purposes')
@section('heading', 'Visit Purposes')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Purpose</a>
@endsection
@section('content')
@php
$purposes = [
    ['id'=>1,'name'=>'Meeting',    'description'=>'Official meetings','count'=>24,'status'=>'Active'],
    ['id'=>2,'name'=>'Enquiry',    'description'=>'Admission or general enquiry','count'=>18,'status'=>'Active'],
    ['id'=>3,'name'=>'Delivery',   'description'=>'Package or document delivery','count'=>12,'status'=>'Active'],
    ['id'=>4,'name'=>'Interview',  'description'=>'Job or admission interview','count'=>8,'status'=>'Active'],
    ['id'=>5,'name'=>'Maintenance','description'=>'Repair or maintenance work','count'=>5,'status'=>'Active'],
    ['id'=>6,'name'=>'Other',      'description'=>'Miscellaneous visits','count'=>3,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Visits</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($purposes as $p)
        <tr>
            <td style="color:#64748b;">{{$p['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$p['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$p['description']}}</td>
            <td style="text-align:center;font-weight:700;">{{$p['count']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$p['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
