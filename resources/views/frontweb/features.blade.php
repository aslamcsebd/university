@extends('layouts.academic')
@section('title', 'Features')
@section('heading', 'Features — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Feature</a>
@endsection
@section('content')
@php
$features = [
    ['id'=>1,'icon'=>'🎓','title'=>'Expert Faculty',       'description'=>'Experienced professors from top institutions','order'=>1,'status'=>'Active'],
    ['id'=>2,'icon'=>'🏛️','title'=>'Modern Campus',        'description'=>'State-of-the-art facilities and infrastructure','order'=>2,'status'=>'Active'],
    ['id'=>3,'icon'=>'📚','title'=>'Rich Library',         'description'=>'Extensive collection of books and digital resources','order'=>3,'status'=>'Active'],
    ['id'=>4,'icon'=>'🔬','title'=>'Research Labs',        'description'=>'Cutting-edge research and innovation centers','order'=>4,'status'=>'Active'],
    ['id'=>5,'icon'=>'🌍','title'=>'Global Connections',   'description'=>'International partnerships and exchange programs','order'=>5,'status'=>'Active'],
    ['id'=>6,'icon'=>'💼','title'=>'Career Support',       'description'=>'Dedicated placement and career guidance cell','order'=>6,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($features as $f)
        <tr>
            <td style="color:#64748b;">{{$f['id']}}</td>
            <td style="font-size:20px;">{{$f['icon']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$f['title']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$f['description']}}</td>
            <td style="text-align:center;font-weight:700;">{{$f['order']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$f['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
