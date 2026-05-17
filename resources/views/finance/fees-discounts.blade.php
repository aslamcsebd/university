@extends('layouts.academic')
@section('title', 'Fees Discounts')
@section('heading', 'Fees Discounts')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Discount</a>
@endsection
@section('content')
@php
$discounts = [
    ['id'=>1,'name'=>'Merit Scholarship',  'type'=>'Percentage','value'=>'25%', 'applicable'=>'Tuition Fee','status'=>'Active'],
    ['id'=>2,'name'=>'Need-Based Aid',     'type'=>'Percentage','value'=>'50%', 'applicable'=>'Tuition Fee','status'=>'Active'],
    ['id'=>3,'name'=>'Staff Ward',         'type'=>'Percentage','value'=>'100%','applicable'=>'All Fees',   'status'=>'Active'],
    ['id'=>4,'name'=>'Early Payment',      'type'=>'Fixed',     'value'=>'$50', 'applicable'=>'Tuition Fee','status'=>'Active'],
    ['id'=>5,'name'=>'Sibling Discount',   'type'=>'Percentage','value'=>'10%', 'applicable'=>'Tuition Fee','status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Type</th><th>Value</th><th>Applicable On</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($discounts as $d)
        <tr>
            <td style="color:#64748b;">{{$d['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$d['name']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$d['type']}}</span></td>
            <td style="font-weight:700;color:#10b981;">{{$d['value']}}</td>
            <td style="color:#64748b;">{{$d['applicable']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$d['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$d['status']==='Active'?'#065f46':'#991b1b'}};">{{$d['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
