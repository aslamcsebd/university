@extends('layouts.academic')
@section('title', 'Fees Reports')
@section('heading', 'Fees Reports')
@section('content')
@php
$records = [
    ['id'=>'INV-001','student'=>'Alice Johnson','type'=>'Tuition Fee','amount'=>'$1,200','paid'=>'$1,200','balance'=>'$0',   'date'=>'2024-01-10','status'=>'Paid'],
    ['id'=>'INV-002','student'=>'Bob Smith',    'type'=>'Exam Fee',   'amount'=>'$200', 'paid'=>'$200', 'balance'=>'$0',   'date'=>'2024-01-12','status'=>'Paid'],
    ['id'=>'INV-003','student'=>'Carol White',  'type'=>'Tuition Fee','amount'=>'$1,200','paid'=>'$600','balance'=>'$600', 'date'=>'2024-01-15','status'=>'Partial'],
    ['id'=>'INV-004','student'=>'David Brown',  'type'=>'Library Fee','amount'=>'$150', 'paid'=>'$0',  'balance'=>'$150', 'date'=>'2024-01-20','status'=>'Unpaid'],
    ['id'=>'INV-005','student'=>'Eva Green',    'type'=>'Transport',  'amount'=>'$480', 'paid'=>'$480','balance'=>'$0',   'date'=>'2024-01-22','status'=>'Paid'],
];
$colors = ['Paid'=>['#d1fae5','#065f46'],'Partial'=>['#fef3c7','#92400e'],'Unpaid'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Invoice</th><th>Student</th><th>Type</th><th>Amount</th><th>Paid</th><th>Balance</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['student']}}</td>
            <td style="color:#64748b;">{{$r['type']}}</td>
            <td style="font-weight:700;">{{$r['amount']}}</td>
            <td style="color:#10b981;font-weight:700;">{{$r['paid']}}</td>
            <td style="color:#ef4444;font-weight:700;">{{$r['balance']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$r['status']][0]}};color:{{$colors[$r['status']][1]}};">{{$r['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
