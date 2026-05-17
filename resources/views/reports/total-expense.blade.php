@extends('layouts.academic')
@section('title', 'Total Expense')
@section('heading', 'Total Expense Report')
@section('content')
@php
$monthly = [
    ['month'=>'Aug 2023','salary'=>'$30,000','utilities'=>'$2,200','equipment'=>'$1,500','maintenance'=>'$800','other'=>'$500','total'=>'$35,000'],
    ['month'=>'Sep 2023','salary'=>'$30,000','utilities'=>'$2,400','equipment'=>'$0',    'maintenance'=>'$600','other'=>'$300','total'=>'$33,300'],
    ['month'=>'Oct 2023','salary'=>'$31,000','utilities'=>'$2,300','equipment'=>'$3,000','maintenance'=>'$700','other'=>'$400','total'=>'$37,400'],
    ['month'=>'Nov 2023','salary'=>'$31,000','utilities'=>'$2,500','equipment'=>'$0',    'maintenance'=>'$900','other'=>'$200','total'=>'$34,600'],
    ['month'=>'Dec 2023','salary'=>'$32,000','utilities'=>'$2,600','equipment'=>'$1,000','maintenance'=>'$500','other'=>'$600','total'=>'$36,700'],
    ['month'=>'Jan 2024','salary'=>'$32,000','utilities'=>'$2,400','equipment'=>'$5,800','maintenance'=>'$1,200','other'=>'$450','total'=>'$41,850'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Month</th><th>Salary</th><th>Utilities</th><th>Equipment</th><th>Maintenance</th><th>Other</th><th>Total</th></tr></thead>
        <tbody>
        @foreach($monthly as $m)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$m['month']}}</td>
            <td style="color:#64748b;">{{$m['salary']}}</td>
            <td style="color:#64748b;">{{$m['utilities']}}</td>
            <td style="color:#64748b;">{{$m['equipment']}}</td>
            <td style="color:#64748b;">{{$m['maintenance']}}</td>
            <td style="color:#64748b;">{{$m['other']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$m['total']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
