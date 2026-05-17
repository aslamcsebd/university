@extends('layouts.academic')
@section('title', 'Districts / Cities')
@section('heading', 'Districts / Cities')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add District</a>
@endsection
@section('content')
@php
$districts = [
    ['id'=>1,'name'=>'Los Angeles','state'=>'California','zip'=>'90001','status'=>'Active'],
    ['id'=>2,'name'=>'San Francisco','state'=>'California','zip'=>'94102','status'=>'Active'],
    ['id'=>3,'name'=>'New York City','state'=>'New York','zip'=>'10001','status'=>'Active'],
    ['id'=>4,'name'=>'Buffalo',     'state'=>'New York','zip'=>'14201','status'=>'Active'],
    ['id'=>5,'name'=>'Houston',     'state'=>'Texas',   'zip'=>'77001','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>State</th><th>ZIP</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($districts as $d)
        <tr>
            <td style="color:#64748b;">{{$d['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$d['name']}}</td>
            <td style="color:#64748b;">{{$d['state']}}</td>
            <td style="color:#64748b;">{{$d['zip']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$d['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
