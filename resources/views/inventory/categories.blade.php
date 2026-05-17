@extends('layouts.academic')
@section('title', 'Inventory Categories')
@section('heading', 'Inventory Categories')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Category</a>
@endsection
@section('content')
@php
$cats = [
    ['id'=>1,'name'=>'Electronics','description'=>'Electronic devices and gadgets','items'=>2,'status'=>'Active'],
    ['id'=>2,'name'=>'Stationery', 'description'=>'Office and classroom supplies', 'items'=>1,'status'=>'Active'],
    ['id'=>3,'name'=>'Furniture',  'description'=>'Desks, chairs, boards',         'items'=>1,'status'=>'Active'],
    ['id'=>4,'name'=>'Clothing',   'description'=>'Uniforms and lab wear',         'items'=>1,'status'=>'Active'],
    ['id'=>5,'name'=>'Safety',     'description'=>'Safety equipment and gear',     'items'=>1,'status'=>'Active'],
    ['id'=>6,'name'=>'Sports',     'description'=>'Sports equipment',              'items'=>0,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Items</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($cats as $c)
        <tr>
            <td style="color:#64748b;">{{$c['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$c['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$c['description']}}</td>
            <td style="text-align:center;font-weight:700;">{{$c['items']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$c['status']==='Active'?'#065f46':'#991b1b'}};">{{$c['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
