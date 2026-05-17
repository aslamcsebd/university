@extends('layouts.academic')
@section('title', 'Manage Leave')
@section('heading', 'Manage Leave — Staff')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection
@section('content')
@php
$leaves = [
    ['id'=>'LV-S01','name'=>'Dr. Mitchell',  'type'=>'Conference','from'=>'Jul 20','to'=>'Jul 22','days'=>3,'status'=>'Pending'],
    ['id'=>'LV-S02','name'=>'Prof. Okafor',  'type'=>'Medical',   'from'=>'Jul 14','to'=>'Jul 15','days'=>2,'status'=>'Approved'],
    ['id'=>'LV-S03','name'=>'Dr. Nair',      'type'=>'Personal',  'from'=>'Jul 18','to'=>'Jul 18','days'=>1,'status'=>'Approved'],
    ['id'=>'LV-S04','name'=>'Mr. Hargreaves','type'=>'Medical',   'from'=>'Jul 10','to'=>'Jul 12','days'=>3,'status'=>'Rejected'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total','4','📋','linear-gradient(135deg,#6366f1,#818cf8)'],['Approved','2','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','1','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Rejected','1','❌','linear-gradient(135deg,#ef4444,#f87171)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Staff</th><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($leaves as $l)
        @php $colors=['Approved'=>['#d1fae5','#065f46'],'Pending'=>['#fef3c7','#92400e'],'Rejected'=>['#fee2e2','#991b1b']]; $c=$colors[$l['status']]; @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$l['id']}}</td>
            <td style="font-weight:600;">{{$l['name']}}</td>
            <td style="color:#64748b;">{{$l['type']}}</td>
            <td style="color:#64748b;">{{$l['from']}}</td>
            <td style="color:#64748b;">{{$l['to']}}</td>
            <td style="text-align:center;font-weight:700;">{{$l['days']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c[0]}};color:{{$c[1]}};">{{$l['status']}}</span></td>
            <td style="display:flex;gap:6px;">
                @if($l['status']==='Pending')
                <a href="#" style="font-size:11px;color:#10b981;font-weight:700;text-decoration:none;">✅ Approve</a>
                <a href="#" style="font-size:11px;color:#ef4444;font-weight:700;text-decoration:none;">❌ Reject</a>
                @else
                <a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
