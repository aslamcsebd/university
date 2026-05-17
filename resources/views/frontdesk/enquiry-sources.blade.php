@extends('layouts.academic')
@section('title', 'Enquiry Sources')
@section('heading', 'Enquiry Sources')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Source</a>
@endsection
@section('content')
@php
$items = [
    ['id'=>1,'name'=>'Walk-in', 'count'=>18,'status'=>'Active'],
    ['id'=>2,'name'=>'Website', 'count'=>24,'status'=>'Active'],
    ['id'=>3,'name'=>'Referral','count'=>12,'status'=>'Active'],
    ['id'=>4,'name'=>'Phone',   'count'=>9, 'status'=>'Active'],
    ['id'=>5,'name'=>'Social Media','count'=>15,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Enquiries</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($items as $i)
        <tr>
            <td style="color:#64748b;">{{$i['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$i['name']}}</td>
            <td style="text-align:center;font-weight:700;">{{$i['count']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$i['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
