@extends('layouts.academic')
@section('title', 'States / Provinces')
@section('heading', 'States / Provinces')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add State</a>
@endsection
@section('content')
@php
$states = [
    ['id'=>1,'name'=>'California',  'code'=>'CA','country'=>'USA','districts'=>58,'status'=>'Active'],
    ['id'=>2,'name'=>'New York',    'code'=>'NY','country'=>'USA','districts'=>62,'status'=>'Active'],
    ['id'=>3,'name'=>'Texas',       'code'=>'TX','country'=>'USA','districts'=>254,'status'=>'Active'],
    ['id'=>4,'name'=>'Florida',     'code'=>'FL','country'=>'USA','districts'=>67,'status'=>'Active'],
    ['id'=>5,'name'=>'Illinois',    'code'=>'IL','country'=>'USA','districts'=>102,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Code</th><th>Country</th><th>Districts</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($states as $s)
        <tr>
            <td style="color:#64748b;">{{$s['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$s['name']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$s['code']}}</td>
            <td style="color:#64748b;">{{$s['country']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['districts']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
