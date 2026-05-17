@extends('layouts.academic')
@section('title', 'Footer Pages')
@section('heading', 'Footer Pages')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Page</a>
@endsection
@section('content')
@php
$pages = [
    ['id'=>1,'title'=>'Privacy Policy',    'slug'=>'privacy-policy',    'last_updated'=>'2024-01-01','status'=>'Published'],
    ['id'=>2,'title'=>'Terms of Service',  'slug'=>'terms-of-service',  'last_updated'=>'2024-01-01','status'=>'Published'],
    ['id'=>3,'title'=>'Refund Policy',     'slug'=>'refund-policy',     'last_updated'=>'2024-01-01','status'=>'Published'],
    ['id'=>4,'title'=>'Cookie Policy',     'slug'=>'cookie-policy',     'last_updated'=>'2024-01-01','status'=>'Draft'],
    ['id'=>5,'title'=>'Disclaimer',        'slug'=>'disclaimer',        'last_updated'=>'2024-01-01','status'=>'Published'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Last Updated</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($pages as $p)
        <tr>
            <td style="color:#64748b;">{{$p['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$p['title']}}</td>
            <td style="color:#6366f1;font-size:12px;">{{$p['slug']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$p['last_updated']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$p['status']==='Published'?'#d1fae5':'#fef3c7'}};color:{{$p['status']==='Published'?'#065f46':'#92400e'}};">{{$p['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
