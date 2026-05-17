@extends('layouts.academic')
@section('title', 'Issue & Return')
@section('heading', 'Issue & Return')
@section('content')
@php
$records = [
    ['id'=>'ISS-001','member'=>'Alice Johnson','book'=>'Introduction to Algorithms','issued'=>'2024-01-05','due'=>'2024-01-19','status'=>'Returned','fine'=>'$0'],
    ['id'=>'ISS-002','member'=>'Bob Smith',    'book'=>'Data Structures',           'issued'=>'2024-01-08','due'=>'2024-01-22','status'=>'Issued',  'fine'=>'$0'],
    ['id'=>'ISS-003','member'=>'Carol White',  'book'=>'Database Systems',          'issued'=>'2023-12-20','due'=>'2024-01-03','status'=>'Overdue', 'fine'=>'$14'],
    ['id'=>'ISS-004','member'=>'Mr. Adams',    'book'=>'Operating Systems',         'issued'=>'2024-01-10','due'=>'2024-01-24','status'=>'Issued',  'fine'=>'$0'],
    ['id'=>'ISS-005','member'=>'David Brown',  'book'=>'Computer Networks',         'issued'=>'2024-01-12','due'=>'2024-01-26','status'=>'Issued',  'fine'=>'$0'],
];
$colors = ['Returned'=>['#d1fae5','#065f46'],'Issued'=>['#dbeafe','#1e40af'],'Overdue'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Member</th><th>Book</th><th>Issued</th><th>Due</th><th>Status</th><th>Fine</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['member']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['book']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['issued']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$r['due']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$r['status']][0]}};color:{{$colors[$r['status']][1]}};">{{$r['status']}}</span></td>
            <td style="font-weight:700;color:{{$r['fine']==='$0'?'#64748b':'#ef4444'}};">{{$r['fine']}}</td>
            <td><a href="#" style="font-size:12px;color:#10b981;font-weight:600;text-decoration:none;">Return</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
