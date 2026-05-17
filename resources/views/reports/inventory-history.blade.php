@extends('layouts.academic')
@section('title', 'Inventory History')
@section('heading', 'Inventory History Report')
@section('content')
@php
$records = [
    ['id'=>'INV-I001','person'=>'Mr. Adams',   'item'=>'Laptop',    'qty'=>1,'issued'=>'2024-01-10','returned'=>'—',         'status'=>'Issued'],
    ['id'=>'INV-I002','person'=>'Ms. Rivera',  'item'=>'Projector', 'qty'=>1,'issued'=>'2024-01-12','returned'=>'2024-01-19','status'=>'Returned'],
    ['id'=>'INV-I003','person'=>'Alice Johnson','item'=>'Calculator','qty'=>2,'issued'=>'2024-01-08','returned'=>'—',         'status'=>'Overdue'],
    ['id'=>'INV-I004','person'=>'Mr. Hassan',  'item'=>'Whiteboard','qty'=>1,'issued'=>'2024-01-15','returned'=>'—',         'status'=>'Issued'],
    ['id'=>'INV-I005','person'=>'Bob Smith',   'item'=>'Lab Coat',  'qty'=>1,'issued'=>'2024-01-05','returned'=>'2024-01-20','status'=>'Returned'],
];
$colors = ['Issued'=>['#dbeafe','#1e40af'],'Returned'=>['#d1fae5','#065f46'],'Overdue'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Person</th><th>Item</th><th>Qty</th><th>Issued</th><th>Returned</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['person']}}</td>
            <td style="color:#64748b;">{{$r['item']}}</td>
            <td style="text-align:center;font-weight:700;">{{$r['qty']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['issued']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['returned']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$r['status']][0]}};color:{{$colors[$r['status']][1]}};">{{$r['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
