@extends('layouts.academic')
@section('title', 'Item Stocks')
@section('heading', 'Item Stocks')
@section('content')
@php
$stocks = [
    ['id'=>'ITM-001','name'=>'Laptop',       'category'=>'Electronics','total'=>20,'issued'=>8, 'available'=>12,'store'=>'Store A','status'=>'In Stock'],
    ['id'=>'ITM-002','name'=>'Projector',    'category'=>'Electronics','total'=>10,'issued'=>3, 'available'=>7, 'store'=>'Store A','status'=>'In Stock'],
    ['id'=>'ITM-003','name'=>'Calculator',   'category'=>'Stationery', 'total'=>50,'issued'=>12,'available'=>38,'store'=>'Store B','status'=>'In Stock'],
    ['id'=>'ITM-004','name'=>'Whiteboard',   'category'=>'Furniture',  'total'=>15,'issued'=>5, 'available'=>10,'store'=>'Store B','status'=>'In Stock'],
    ['id'=>'ITM-005','name'=>'Lab Coat',     'category'=>'Clothing',   'total'=>30,'issued'=>30,'available'=>0, 'store'=>'Store C','status'=>'Out of Stock'],
    ['id'=>'ITM-006','name'=>'Safety Goggles','category'=>'Safety',    'total'=>40,'issued'=>15,'available'=>25,'store'=>'Store C','status'=>'In Stock'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Total</th><th>Issued</th><th>Available</th><th>Store</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($stocks as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['category']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['total']}}</td>
            <td style="text-align:center;color:#f59e0b;font-weight:700;">{{$s['issued']}}</td>
            <td style="text-align:center;font-weight:700;color:{{$s['available']>0?'#10b981':'#ef4444'}};">{{$s['available']}}</td>
            <td style="color:#64748b;">{{$s['store']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='In Stock'?'#d1fae5':'#fee2e2'}};color:{{$s['status']==='In Stock'?'#065f46':'#991b1b'}};">{{$s['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
