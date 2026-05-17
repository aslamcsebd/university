@extends('layouts.academic')
@section('title', 'Sliders')
@section('heading', 'Sliders')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Slide</a>
@endsection
@section('content')
@php
$sliders = [
    ['id'=>1,'title'=>'Welcome to Grand University','subtitle'=>'Excellence in Education','order'=>1,'status'=>'Active'],
    ['id'=>2,'title'=>'World-Class Facilities',     'subtitle'=>'State of the art campus', 'order'=>2,'status'=>'Active'],
    ['id'=>3,'title'=>'Apply Now for 2024',         'subtitle'=>'Admissions are open',     'order'=>3,'status'=>'Active'],
    ['id'=>4,'title'=>'Research & Innovation',      'subtitle'=>'Leading research programs','order'=>4,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Subtitle</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($sliders as $s)
        <tr>
            <td style="color:#64748b;">{{$s['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$s['title']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['subtitle']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['order']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='Active'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
