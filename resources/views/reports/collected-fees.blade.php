@extends('layouts.academic')
@section('title', 'Collected Fees')
@section('heading', 'Collected Fees Report')
@section('content')
@php
$stats = [
    ['label'=>'Total Collected','value'=>'$69,700','icon'=>'💰','grad'=>'linear-gradient(135deg,#10b981,#34d399)'],
    ['label'=>'Pending',        'value'=>'$12,400','icon'=>'⏳','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)'],
    ['label'=>'Overdue',        'value'=>'$4,800', 'icon'=>'⚠️','grad'=>'linear-gradient(135deg,#ef4444,#f87171)'],
    ['label'=>'This Month',     'value'=>'$18,200','icon'=>'📅','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)'],
];
$records = [
    ['type'=>'Tuition Fee','collected'=>'$48,000','pending'=>'$6,000','total'=>'$54,000','pct'=>'89%'],
    ['type'=>'Exam Fee',   'collected'=>'$8,000', 'pending'=>'$2,000','total'=>'$10,000','pct'=>'80%'],
    ['type'=>'Library Fee','collected'=>'$4,500', 'pending'=>'$1,500','total'=>'$6,000', 'pct'=>'75%'],
    ['type'=>'Transport',  'collected'=>'$7,200', 'pending'=>'$2,400','total'=>'$9,600', 'pct'=>'75%'],
    ['type'=>'Hostel',     'collected'=>'$2,000', 'pending'=>'$500',  'total'=>'$2,500', 'pct'=>'80%'],
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
    <table>
        <thead><tr><th>Fee Type</th><th>Collected</th><th>Pending</th><th>Total</th><th>Collection %</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:600;">{{$r['type']}}</td>
            <td style="font-weight:700;color:#10b981;">{{$r['collected']}}</td>
            <td style="font-weight:700;color:#ef4444;">{{$r['pending']}}</td>
            <td style="font-weight:700;">{{$r['total']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$r['pct']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
