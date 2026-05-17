@extends('layouts.academic')
@section('title', 'Expense Categories')
@section('heading', 'Expense Categories')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Category</a>
@endsection
@section('content')
@php
$cats = [
    ['id'=>1,'name'=>'Salary',      'description'=>'Staff and faculty salaries',  'count'=>12,'status'=>'Active'],
    ['id'=>2,'name'=>'Utilities',   'description'=>'Electricity, water, internet','count'=>8, 'status'=>'Active'],
    ['id'=>3,'name'=>'Equipment',   'description'=>'Lab and office equipment',    'count'=>5, 'status'=>'Active'],
    ['id'=>4,'name'=>'Maintenance', 'description'=>'Building and asset upkeep',   'count'=>7, 'status'=>'Active'],
    ['id'=>5,'name'=>'Supplies',    'description'=>'Stationery and consumables',  'count'=>4, 'status'=>'Active'],
    ['id'=>6,'name'=>'Events',      'description'=>'Events and ceremonies',       'count'=>3, 'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Records</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($cats as $c)
        <tr>
            <td style="color:#64748b;">{{$c['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$c['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['description']}}</td>
            <td style="text-align:center;font-weight:700;">{{$c['count']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$c['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
