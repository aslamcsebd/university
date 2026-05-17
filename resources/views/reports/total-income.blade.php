@extends('layouts.academic')
@section('title', 'Total Income')
@section('heading', 'Total Income Report')
@section('content')
@php
$monthly = [
    ['month'=>'Aug 2023','fees'=>'$58,000','rent'=>'$1,500','donation'=>'$2,000','other'=>'$1,200','total'=>'$62,700'],
    ['month'=>'Sep 2023','fees'=>'$60,000','rent'=>'$1,500','donation'=>'$0',    'other'=>'$800', 'total'=>'$62,300'],
    ['month'=>'Oct 2023','fees'=>'$61,000','rent'=>'$1,500','donation'=>'$3,000','other'=>'$1,000','total'=>'$66,500'],
    ['month'=>'Nov 2023','fees'=>'$59,000','rent'=>'$1,500','donation'=>'$0',    'other'=>'$500', 'total'=>'$61,000'],
    ['month'=>'Dec 2023','fees'=>'$55,000','rent'=>'$1,500','donation'=>'$5,000','other'=>'$2,000','total'=>'$63,500'],
    ['month'=>'Jan 2024','fees'=>'$63,700','rent'=>'$1,500','donation'=>'$3,000','other'=>'$1,500','total'=>'$69,700'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Month</th><th>Fees</th><th>Rent</th><th>Donation</th><th>Other</th><th>Total</th></tr></thead>
        <tbody>
        @foreach($monthly as $m)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$m['month']}}</td>
            <td style="color:#64748b;">{{$m['fees']}}</td>
            <td style="color:#64748b;">{{$m['rent']}}</td>
            <td style="color:#64748b;">{{$m['donation']}}</td>
            <td style="color:#64748b;">{{$m['other']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$m['total']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
