@extends('layouts.academic')
@section('title', 'Status Types')
@section('heading', 'Status Types')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Status</a>
@endsection

@section('content')
@php
$statuses = [
    ['id'=>1,'name'=>'Active',    'color'=>'#10b981','desc'=>'Currently enrolled and attending','students'=>312],
    ['id'=>2,'name'=>'Inactive',  'color'=>'#94a3b8','desc'=>'Not currently attending','students'=>24],
    ['id'=>3,'name'=>'Graduated', 'color'=>'#6366f1','desc'=>'Completed the program','students'=>187],
    ['id'=>4,'name'=>'Suspended', 'color'=>'#ef4444','desc'=>'Temporarily suspended','students'=>8],
    ['id'=>5,'name'=>'Withdrawn', 'color'=>'#f59e0b','desc'=>'Voluntarily withdrawn','students'=>15],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Status Name</th><th>Description</th><th>Students</th><th>Color</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($statuses as $s)
        <tr>
            <td style="color:#94a3b8;">{{$s['id']}}</td>
            <td><span style="padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;background:{{$s['color']}}22;color:{{$s['color']}};">{{$s['name']}}</span></td>
            <td style="color:#64748b;">{{$s['desc']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$s['students']}}</td>
            <td><div style="width:24px;height:24px;border-radius:6px;background:{{$s['color']}};"></div></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
