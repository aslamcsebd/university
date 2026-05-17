@extends('layouts.academic')
@section('title', 'Batches')
@section('heading', 'Batches')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Batch</a>
@endsection

@section('content')
@php
$batches = [
    ['id'=>'BAT-001','name'=>'Batch 2025-2028','program'=>'B.Sc CS',    'start'=>'Sep 2025','end'=>'Jun 2028','students'=>85,'status'=>'Upcoming'],
    ['id'=>'BAT-002','name'=>'Batch 2024-2027','program'=>'B.Sc CS',    'start'=>'Sep 2024','end'=>'Jun 2027','students'=>92,'status'=>'Active'],
    ['id'=>'BAT-003','name'=>'Batch 2023-2026','program'=>'B.Sc CS',    'start'=>'Sep 2023','end'=>'Jun 2026','students'=>88,'status'=>'Active'],
    ['id'=>'BAT-004','name'=>'Batch 2022-2025','program'=>'B.Sc CS',    'start'=>'Sep 2022','end'=>'Jun 2025','students'=>76,'status'=>'Graduating'],
    ['id'=>'BAT-005','name'=>'Batch 2024-2027','program'=>'B.E Civil',  'start'=>'Sep 2024','end'=>'Jun 2028','students'=>110,'status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Batch Name</th><th>Program</th><th>Start</th><th>End</th><th>Students</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($batches as $b)
        @php $colors=['Active'=>['#d1fae5','#065f46'],'Upcoming'=>['#dbeafe','#1e40af'],'Graduating'=>['#fef3c7','#92400e']]; $c=$colors[$b['status']]??['#f3f4f6','#374151']; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$b['id']}}</td>
            <td style="font-weight:600;">{{$b['name']}}</td>
            <td style="color:#64748b;">{{$b['program']}}</td>
            <td style="color:#64748b;">{{$b['start']}}</td>
            <td style="color:#64748b;">{{$b['end']}}</td>
            <td style="text-align:center;font-weight:700;">{{$b['students']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$b['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
