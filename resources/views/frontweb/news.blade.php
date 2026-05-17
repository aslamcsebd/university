@extends('layouts.academic')
@section('title', 'News')
@section('heading', 'News — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add News</a>
@endsection
@section('content')
@php
$news = [
    ['id'=>1,'title'=>'University Ranked Top 50 Nationally',  'date'=>'2024-01-20','author'=>'Admin','views'=>245,'status'=>'Published'],
    ['id'=>2,'title'=>'New Research Lab Inaugurated',          'date'=>'2024-01-18','author'=>'Admin','views'=>180,'status'=>'Published'],
    ['id'=>3,'title'=>'Students Win National Hackathon',       'date'=>'2024-01-15','author'=>'Admin','views'=>320,'status'=>'Published'],
    ['id'=>4,'title'=>'International Partnership Announced',   'date'=>'2024-01-10','author'=>'Admin','views'=>150,'status'=>'Published'],
    ['id'=>5,'title'=>'New Scholarship Program Launched',      'date'=>'2024-01-08','author'=>'Admin','views'=>0,  'status'=>'Draft'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Date</th><th>Author</th><th>Views</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($news as $n)
        <tr>
            <td style="color:#64748b;">{{$n['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$n['title']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$n['date']}}</td>
            <td style="color:#64748b;">{{$n['author']}}</td>
            <td style="text-align:center;font-weight:700;color:#6366f1;">{{$n['views']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$n['status']==='Published'?'#d1fae5':'#fef3c7'}};color:{{$n['status']==='Published'?'#065f46':'#92400e'}};">{{$n['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
