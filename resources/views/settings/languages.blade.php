@extends('layouts.academic')
@section('title', 'Languages')
@section('heading', 'Languages')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Language</a>
@endsection
@section('content')
@php
$langs = [
    ['id'=>1,'name'=>'English','code'=>'en','direction'=>'LTR','default'=>true, 'status'=>'Active'],
    ['id'=>2,'name'=>'Spanish','code'=>'es','direction'=>'LTR','default'=>false,'status'=>'Active'],
    ['id'=>3,'name'=>'French', 'code'=>'fr','direction'=>'LTR','default'=>false,'status'=>'Active'],
    ['id'=>4,'name'=>'Arabic', 'code'=>'ar','direction'=>'RTL','default'=>false,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Code</th><th>Direction</th><th>Default</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($langs as $l)
        <tr>
            <td style="color:#64748b;">{{$l['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$l['name']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$l['code']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$l['direction']}}</span></td>
            <td>@if($l['default'])<span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">Default</span>@endif</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$l['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$l['status']==='Active'?'#065f46':'#991b1b'}};">{{$l['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
