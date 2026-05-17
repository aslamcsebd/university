@extends('layouts.academic')
@section('title', 'Event — Web')
@section('heading', 'Event — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Event</a>
@endsection
@section('content')
@php
$events = [
    ['id'=>1,'title'=>'Annual Sports Day',   'date'=>'Feb 10, 2024','category'=>'Sports',  'status'=>'Published'],
    ['id'=>2,'title'=>'Science Exhibition',  'date'=>'Feb 15, 2024','category'=>'Academic','status'=>'Published'],
    ['id'=>3,'title'=>'Cultural Fest',       'date'=>'Jan 20, 2024','category'=>'Cultural','status'=>'Published'],
    ['id'=>4,'title'=>'Alumni Meet',         'date'=>'Mar 01, 2024','category'=>'Social',  'status'=>'Draft'],
    ['id'=>5,'title'=>'Graduation Ceremony', 'date'=>'Mar 15, 2024','category'=>'Academic','status'=>'Published'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Date</th><th>Category</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($events as $e)
        <tr>
            <td style="color:#64748b;">{{$e['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$e['title']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$e['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$e['category']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$e['status']==='Published'?'#d1fae5':'#fef3c7'}};color:{{$e['status']==='Published'?'#065f46':'#92400e'}};">{{$e['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
