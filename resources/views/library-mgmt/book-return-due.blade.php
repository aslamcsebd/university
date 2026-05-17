@extends('layouts.academic')
@section('title', 'Book Return Due')
@section('heading', 'Book Return Due')
@section('content')
@php
$dues = [
    ['id'=>'ISS-003','member'=>'Carol White', 'book'=>'Database Systems',   'issued'=>'2023-12-20','due'=>'2024-01-03','days'=>18,'fine'=>'$18'],
    ['id'=>'ISS-007','member'=>'Tom Harris',  'book'=>'Operating Systems',  'issued'=>'2023-12-25','due'=>'2024-01-08','days'=>13,'fine'=>'$13'],
    ['id'=>'ISS-009','member'=>'Sara Lee',    'book'=>'Computer Networks',  'issued'=>'2024-01-02','due'=>'2024-01-16','days'=>5, 'fine'=>'$5'],
    ['id'=>'ISS-011','member'=>'Mike Chen',   'book'=>'Algorithms Design',  'issued'=>'2024-01-05','due'=>'2024-01-19','days'=>2, 'fine'=>'$2'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Issue ID</th><th>Member</th><th>Book</th><th>Issued</th><th>Due Date</th><th>Days Late</th><th>Fine</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($dues as $d)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$d['id']}}</td>
            <td style="font-weight:600;">{{$d['member']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$d['book']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$d['issued']}}</td>
            <td style="color:#ef4444;font-weight:600;font-size:12px;">{{$d['due']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$d['days']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$d['fine']}}</td>
            <td><a href="#" style="font-size:12px;color:#10b981;font-weight:600;text-decoration:none;">Mark Returned</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
