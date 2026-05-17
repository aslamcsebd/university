@extends('layouts.academic')
@section('title', 'Fees Types')
@section('heading', 'Fees Types')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Type</a>
@endsection
@section('content')
@php
$types = [
    ['id'=>1,'name'=>'Tuition Fee',  'description'=>'Semester tuition charges',    'amount'=>'$1,200','frequency'=>'Per Semester','status'=>'Active'],
    ['id'=>2,'name'=>'Exam Fee',     'description'=>'Examination registration fee', 'amount'=>'$200', 'frequency'=>'Per Exam',    'status'=>'Active'],
    ['id'=>3,'name'=>'Library Fee',  'description'=>'Library access and services',  'amount'=>'$150', 'frequency'=>'Per Year',    'status'=>'Active'],
    ['id'=>4,'name'=>'Transport Fee','description'=>'Bus/van transport service',    'amount'=>'$480', 'frequency'=>'Per Year',    'status'=>'Active'],
    ['id'=>5,'name'=>'Hostel Fee',   'description'=>'Hostel accommodation charges', 'amount'=>'$3,600','frequency'=>'Per Year',   'status'=>'Active'],
    ['id'=>6,'name'=>'Lab Fee',      'description'=>'Laboratory usage charges',     'amount'=>'$100', 'frequency'=>'Per Semester','status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Amount</th><th>Frequency</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($types as $t)
        <tr>
            <td style="color:#64748b;">{{$t['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$t['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$t['description']}}</td>
            <td style="font-weight:700;">{{$t['amount']}}</td>
            <td style="color:#64748b;">{{$t['frequency']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$t['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$t['status']==='Active'?'#065f46':'#991b1b'}};">{{$t['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
