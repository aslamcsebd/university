@extends('layouts.academic')
@section('title', 'My Leaves')
@section('heading', 'My Leaves')
@section('content')
@php
$leaves = [
    ['id'=>'LV-001','type'=>'Medical',  'from'=>'Jun 10','to'=>'Jun 12','days'=>3,'status'=>'Approved','reason'=>'Fever and rest'],
    ['id'=>'LV-002','type'=>'Personal', 'from'=>'Jun 25','to'=>'Jun 25','days'=>1,'status'=>'Approved','reason'=>'Personal work'],
    ['id'=>'LV-003','type'=>'Conference','from'=>'Jul 20','to'=>'Jul 22','days'=>3,'status'=>'Pending', 'reason'=>'IEEE Conference'],
    ['id'=>'LV-004','type'=>'Medical',  'from'=>'Aug 05','to'=>'Aug 06','days'=>2,'status'=>'Pending', 'reason'=>'Dental surgery'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Applied','4','📋','linear-gradient(135deg,#6366f1,#818cf8)'],['Approved','2','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','2','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Days Used','9','📅','linear-gradient(135deg,#8b5cf6,#a78bfa)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Reason</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($leaves as $l)
        @php $colors=['Approved'=>['#d1fae5','#065f46'],'Pending'=>['#fef3c7','#92400e'],'Rejected'=>['#fee2e2','#991b1b']]; $c=$colors[$l['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$l['id']}}</td>
            <td style="color:#64748b;">{{$l['type']}}</td>
            <td style="color:#64748b;">{{$l['from']}}</td>
            <td style="color:#64748b;">{{$l['to']}}</td>
            <td style="text-align:center;font-weight:700;">{{$l['days']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$l['reason']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$l['status']}}</span></td>
            <td>@if($l['status']==='Pending')<a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Cancel</a>@else<span style="font-size:12px;color:#94a3b8;">—</span>@endif</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
