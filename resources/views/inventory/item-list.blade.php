@extends('layouts.academic')
@section('title', 'Item List')
@section('heading', 'Item List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Item</a>
@endsection
@section('content')
@php
$items = [
    ['id'=>'ITM-001','name'=>'Laptop',        'category'=>'Electronics','supplier'=>'TechCorp',   'unit'=>'Piece','price'=>'$800','status'=>'Active'],
    ['id'=>'ITM-002','name'=>'Projector',     'category'=>'Electronics','supplier'=>'TechCorp',   'unit'=>'Piece','price'=>'$350','status'=>'Active'],
    ['id'=>'ITM-003','name'=>'Calculator',    'category'=>'Stationery', 'supplier'=>'OfficeSupply','unit'=>'Piece','price'=>'$15', 'status'=>'Active'],
    ['id'=>'ITM-004','name'=>'Whiteboard',    'category'=>'Furniture',  'supplier'=>'FurnishCo',  'unit'=>'Piece','price'=>'$120','status'=>'Active'],
    ['id'=>'ITM-005','name'=>'Lab Coat',      'category'=>'Clothing',   'supplier'=>'UniWear',    'unit'=>'Piece','price'=>'$25', 'status'=>'Active'],
    ['id'=>'ITM-006','name'=>'Safety Goggles','category'=>'Safety',     'supplier'=>'SafetyFirst', 'unit'=>'Piece','price'=>'$8',  'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Supplier</th><th>Unit</th><th>Unit Price</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($items as $i)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$i['id']}}</td>
            <td style="font-weight:600;">{{$i['name']}}</td>
            <td style="color:#64748b;">{{$i['category']}}</td>
            <td style="color:#64748b;">{{$i['supplier']}}</td>
            <td style="color:#64748b;">{{$i['unit']}}</td>
            <td style="font-weight:700;">{{$i['price']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$i['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
