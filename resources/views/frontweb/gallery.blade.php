@extends('layouts.academic')
@section('title', 'Gallery')
@section('heading', 'Gallery — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Image</a>
@endsection
@section('content')
@php
$images = [
    ['id'=>1,'title'=>'Campus Main Building',  'category'=>'Campus',  'order'=>1,'status'=>'Active'],
    ['id'=>2,'title'=>'Science Laboratory',    'category'=>'Facility','order'=>2,'status'=>'Active'],
    ['id'=>3,'title'=>'Library Interior',      'category'=>'Facility','order'=>3,'status'=>'Active'],
    ['id'=>4,'title'=>'Sports Ground',         'category'=>'Sports',  'order'=>4,'status'=>'Active'],
    ['id'=>5,'title'=>'Graduation Ceremony',   'category'=>'Events',  'order'=>5,'status'=>'Active'],
    ['id'=>6,'title'=>'Cultural Fest 2023',    'category'=>'Events',  'order'=>6,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($images as $i)
        <tr>
            <td style="color:#64748b;">{{$i['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$i['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$i['category']}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$i['order']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$i['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$i['status']==='Active'?'#065f46':'#991b1b'}};">{{$i['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
