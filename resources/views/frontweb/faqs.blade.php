@extends('layouts.academic')
@section('title', 'FAQs')
@section('heading', 'FAQs — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add FAQ</a>
@endsection
@section('content')
@php
$faqs = [
    ['id'=>1,'question'=>'How do I apply for admission?',          'category'=>'Admission','order'=>1,'status'=>'Active'],
    ['id'=>2,'question'=>'What are the fee payment methods?',      'category'=>'Finance',  'order'=>2,'status'=>'Active'],
    ['id'=>3,'question'=>'Is hostel accommodation available?',     'category'=>'Hostel',   'order'=>3,'status'=>'Active'],
    ['id'=>4,'question'=>'What scholarships are available?',       'category'=>'Finance',  'order'=>4,'status'=>'Active'],
    ['id'=>5,'question'=>'How can I get my transcripts?',          'category'=>'Academic', 'order'=>5,'status'=>'Active'],
    ['id'=>6,'question'=>'What is the attendance requirement?',    'category'=>'Academic', 'order'=>6,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Question</th><th>Category</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($faqs as $f)
        <tr>
            <td style="color:#64748b;">{{$f['id']}}</td>
            <td style="font-weight:600;color:#1e293b;">{{$f['question']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$f['category']}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$f['order']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$f['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
