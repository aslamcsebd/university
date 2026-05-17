@extends('layouts.academic')
@section('title', 'Outcome Overview')
@section('heading', 'Outcome Overview')
@section('content')
@php
$stats = [
    ['label'=>'Total Income',  'value'=>'$69,700','icon'=>'💰','grad'=>'linear-gradient(135deg,#10b981,#34d399)'],
    ['label'=>'Total Expense', 'value'=>'$41,850','icon'=>'💸','grad'=>'linear-gradient(135deg,#ef4444,#f87171)'],
    ['label'=>'Net Balance',   'value'=>'$27,850','icon'=>'📊','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)'],
    ['label'=>'This Month',    'value'=>'$5,200', 'icon'=>'📅','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)'],
];
$monthly = [
    ['month'=>'Sep','income'=>'$62,000','expense'=>'$38,000','net'=>'$24,000'],
    ['month'=>'Oct','income'=>'$64,500','expense'=>'$39,500','net'=>'$25,000'],
    ['month'=>'Nov','income'=>'$61,000','expense'=>'$40,000','net'=>'$21,000'],
    ['month'=>'Dec','income'=>'$58,000','expense'=>'$37,000','net'=>'$21,000'],
    ['month'=>'Jan','income'=>'$69,700','expense'=>'$41,850','net'=>'$27,850'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach($stats as $s)
    <div style="background:{{$s['grad']}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s['value']}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s['label']}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s['icon']}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <div style="padding:16px 20px;font-weight:700;font-size:14px;color:#1e293b;border-bottom:1px solid #f1f5f9;">Monthly Summary</div>
    <table>
        <thead><tr><th>Month</th><th>Income</th><th>Expense</th><th>Net Balance</th></tr></thead>
        <tbody>
        @foreach($monthly as $m)
        <tr>
            <td style="font-weight:700;color:#1e293b;">{{$m['month']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$m['income']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$m['expense']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$m['net']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
