@extends('layouts.academic')
@section('title', 'Income List')
@section('heading', 'Income List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Income</a>
@endsection
@section('content')
@php
$incomes = [
    ['id'=>'INC-001','title'=>'Tuition Fees — Jan','category'=>'Fees',      'amount'=>'$48,000','date'=>'2024-01-31','note'=>'January batch'],
    ['id'=>'INC-002','title'=>'Exam Fees',          'category'=>'Fees',      'amount'=>'$8,000', 'date'=>'2024-01-20','note'=>'Mid-term'],
    ['id'=>'INC-003','title'=>'Canteen Rent',        'category'=>'Rent',      'amount'=>'$1,500', 'date'=>'2024-01-05','note'=>'Monthly'],
    ['id'=>'INC-004','title'=>'Donation — Alumni',   'category'=>'Donation',  'amount'=>'$5,000', 'date'=>'2024-01-18','note'=>'Annual fund'],
    ['id'=>'INC-005','title'=>'Transport Fees',      'category'=>'Transport', 'amount'=>'$7,200', 'date'=>'2024-01-31','note'=>'January'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Category</th><th>Amount</th><th>Date</th><th>Note</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($incomes as $i)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$i['id']}}</td>
            <td style="font-weight:600;">{{$i['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$i['category']}}</span></td>
            <td style="font-weight:700;color:#10b981;">{{$i['amount']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$i['date']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$i['note']}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
