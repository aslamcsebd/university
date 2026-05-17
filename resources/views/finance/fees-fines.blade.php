@extends('layouts.academic')
@section('title', 'Fees Fines')
@section('heading', 'Fees Fines')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Fine</a>
@endsection
@section('content')
@php
$fines = [
    ['id'=>1,'name'=>'Late Payment Fine',  'type'=>'Percentage','value'=>'2%/month','applicable'=>'All Fees',   'status'=>'Active'],
    ['id'=>2,'name'=>'Library Late Return','type'=>'Fixed',     'value'=>'$1/day',  'applicable'=>'Library Fee','status'=>'Active'],
    ['id'=>3,'name'=>'ID Card Loss',       'type'=>'Fixed',     'value'=>'$20',     'applicable'=>'One-time',   'status'=>'Active'],
    ['id'=>4,'name'=>'Damage Fine',        'type'=>'Fixed',     'value'=>'Variable','applicable'=>'Property',   'status'=>'Active'],
    ['id'=>5,'name'=>'Exam Absentee',      'type'=>'Fixed',     'value'=>'$50',     'applicable'=>'Exam Fee',   'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Type</th><th>Value</th><th>Applicable On</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($fines as $f)
        <tr>
            <td style="color:#64748b;">{{$f['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$f['name']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fef3c7;color:#92400e;">{{$f['type']}}</span></td>
            <td style="font-weight:700;color:#ef4444;">{{$f['value']}}</td>
            <td style="color:#64748b;">{{$f['applicable']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$f['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$f['status']==='Active'?'#065f46':'#991b1b'}};">{{$f['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
