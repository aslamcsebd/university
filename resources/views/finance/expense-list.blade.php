@extends('layouts.academic')
@section('title', 'Expense List')
@section('heading', 'Expense List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Expense</a>
@endsection
@section('content')
@php
$expenses = [
    ['id'=>'EXP-001','title'=>'Staff Salaries — Jan', 'category'=>'Salary',      'amount'=>'$32,000','date'=>'2024-01-31','note'=>'Monthly payroll'],
    ['id'=>'EXP-002','title'=>'Electricity Bill',     'category'=>'Utilities',   'amount'=>'$2,400', 'date'=>'2024-01-28','note'=>'January'],
    ['id'=>'EXP-003','title'=>'Lab Equipment',        'category'=>'Equipment',   'amount'=>'$5,800', 'date'=>'2024-01-15','note'=>'New purchase'],
    ['id'=>'EXP-004','title'=>'Maintenance',          'category'=>'Maintenance', 'amount'=>'$1,200', 'date'=>'2024-01-20','note'=>'Building repair'],
    ['id'=>'EXP-005','title'=>'Stationery',           'category'=>'Supplies',    'amount'=>'$450',   'date'=>'2024-01-10','note'=>'Office supplies'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Category</th><th>Amount</th><th>Date</th><th>Note</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($expenses as $e)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$e['id']}}</td>
            <td style="font-weight:600;">{{$e['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fee2e2;color:#991b1b;">{{$e['category']}}</span></td>
            <td style="font-weight:700;color:#ef4444;">{{$e['amount']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$e['date']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$e['note']}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
