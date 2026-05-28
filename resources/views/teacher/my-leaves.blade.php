@extends('layouts.academic')
@section('title', 'My Leaves')
@section('heading', 'My Leaves')
@section('header-actions')
    <a href="/teacher/apply-leave" class="btn btn-primary">+ Apply Leave</a>
@endsection
@section('content')
@php
$leaves = [
    ['type'=>'Medical',  'from'=>'Jul 05, 2025','to'=>'Jul 06, 2025','days'=>2,'reason'=>'Doctor appointment',    'status'=>'Approved', 'applied'=>'Jul 03, 2025'],
    ['type'=>'Casual',   'from'=>'Jun 20, 2025','to'=>'Jun 20, 2025','days'=>1,'reason'=>'Personal work',         'status'=>'Approved', 'applied'=>'Jun 18, 2025'],
    ['type'=>'Personal', 'from'=>'May 10, 2025','to'=>'May 11, 2025','days'=>2,'reason'=>'Family function',       'status'=>'Rejected', 'applied'=>'May 08, 2025'],
    ['type'=>'Medical',  'from'=>'Apr 02, 2025','to'=>'Apr 03, 2025','days'=>2,'reason'=>'Fever and rest',        'status'=>'Approved', 'applied'=>'Apr 01, 2025'],
    ['type'=>'Casual',   'from'=>'Jul 18, 2025','to'=>'Jul 18, 2025','days'=>1,'reason'=>'Personal errand',       'status'=>'Pending',  'applied'=>'Jul 15, 2025'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Reason</th><th>Applied On</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($leaves as $l)
        @php $sc = $l['status']==='Approved'?['#d1fae5','#065f46']:($l['status']==='Rejected'?['#fee2e2','#991b1b']:['#fef3c7','#92400e']); @endphp
        <tr>
            <td style="font-weight:600;">{{ $l['type'] }}</td>
            <td style="color:#64748b;">{{ $l['from'] }}</td>
            <td style="color:#64748b;">{{ $l['to'] }}</td>
            <td style="text-align:center;font-weight:700;">{{ $l['days'] }}</td>
            <td style="color:#64748b;font-size:12px;">{{ $l['reason'] }}</td>
            <td style="color:#94a3b8;font-size:12px;">{{ $l['applied'] }}</td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $sc[0] }};color:{{ $sc[1] }};">{{ $l['status'] }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
