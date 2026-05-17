@extends('layouts.academic')
@section('title', 'Testimonials')
@section('heading', 'Testimonials — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Testimonial</a>
@endsection
@section('content')
@php
$testimonials = [
    ['id'=>1,'name'=>'<name>','role'=>'Alumni, B.Sc CS 2022',  'rating'=>5,'quote'=>'Grand University shaped my career in the best way possible.','status'=>'Active'],
    ['id'=>2,'name'=>'<name>','role'=>'Alumni, MBA 2021',      'rating'=>5,'quote'=>'The faculty and facilities here are world-class.',            'status'=>'Active'],
    ['id'=>3,'name'=>'<name>','role'=>'Current Student, B.Com','rating'=>4,'quote'=>'Great learning environment and supportive staff.',            'status'=>'Active'],
    ['id'=>4,'name'=>'<name>','role'=>'Alumni, B.A Eng 2023',  'rating'=>5,'quote'=>'The best decision I made was choosing this university.',     'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Role</th><th>Rating</th><th>Quote</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($testimonials as $t)
        <tr>
            <td style="color:#64748b;">{{$t['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$t['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$t['role']}}</td>
            <td style="color:#f59e0b;font-weight:700;">{{str_repeat('★',$t['rating'])}}</td>
            <td style="color:#64748b;font-size:12px;max-width:200px;">{{$t['quote']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$t['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$t['status']==='Active'?'#065f46':'#991b1b'}};">{{$t['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
