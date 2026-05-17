@extends('layouts.academic')
@section('title', 'Assigned History')
@section('heading', 'Assigned History')
@section('content')
@php
$history = [
    ['id'=>'ASN-001','group'=>'B.Sc CS — Sem 3','type'=>'Tuition Fee','amount'=>'$1,200','students'=>42,'assigned_by'=>'Admin','date'=>'2024-01-05'],
    ['id'=>'ASN-002','group'=>'B.Com — Sem 1',  'type'=>'Tuition Fee','amount'=>'$900', 'students'=>38,'assigned_by'=>'Admin','date'=>'2024-01-05'],
    ['id'=>'ASN-003','group'=>'MBA — Sem 2',    'type'=>'Exam Fee',   'amount'=>'$300', 'students'=>25,'assigned_by'=>'Admin','date'=>'2024-01-10'],
    ['id'=>'ASN-004','group'=>'B.A Eng — Sem 4','type'=>'Library Fee','amount'=>'$150', 'students'=>30,'assigned_by'=>'Admin','date'=>'2024-01-12'],
    ['id'=>'ASN-005','group'=>'B.Sc CS — Sem 1','type'=>'Transport',  'amount'=>'$480', 'students'=>15,'assigned_by'=>'Admin','date'=>'2024-01-15'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Group</th><th>Fees Type</th><th>Amount</th><th>Students</th><th>Assigned By</th><th>Date</th></tr></thead>
        <tbody>
        @foreach($history as $h)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$h['id']}}</td>
            <td style="font-weight:600;">{{$h['group']}}</td>
            <td style="color:#64748b;">{{$h['type']}}</td>
            <td style="font-weight:700;">{{$h['amount']}}</td>
            <td style="text-align:center;font-weight:700;">{{$h['students']}}</td>
            <td style="color:#64748b;">{{$h['assigned_by']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$h['date']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
