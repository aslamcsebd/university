@extends('layouts.academic')
@section('title', 'Exam Results')
@section('heading', 'Exam Results')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export Results</a>
@endsection

@section('content')
@php
$results = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'total'=>394,'pct'=>79,'grade'=>'B+','status'=>'Pass','rank'=>3],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'total'=>435,'pct'=>87,'grade'=>'A', 'status'=>'Pass','rank'=>2],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'total'=>339,'pct'=>68,'grade'=>'B', 'status'=>'Pass','rank'=>4],
    ['id'=>'STU-004','name'=>'Emily Clark',  'total'=>448,'pct'=>90,'grade'=>'A+','status'=>'Pass','rank'=>1],
    ['id'=>'STU-005','name'=>'Omar Hassan',  'total'=>300,'pct'=>60,'grade'=>'C', 'status'=>'Pass','rank'=>5],
    ['id'=>'STU-006','name'=>'Priya Sharma', 'total'=>220,'pct'=>44,'grade'=>'F', 'status'=>'Fail','rank'=>6],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Students','6','🧑🎓','linear-gradient(135deg,#6366f1,#818cf8)'],['Passed','5','✅','linear-gradient(135deg,#10b981,#34d399)'],['Failed','1','❌','linear-gradient(135deg,#ef4444,#f87171)'],['Pass Rate','83%','📊','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Rank</th><th>Student</th><th>Total (500)</th><th>Percentage</th><th>Grade</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach(collect($results)->sortBy('rank') as $r)
        @php $gc=$r['status']==='Pass'?'#10b981':'#ef4444'; @endphp
        <tr>
            <td style="text-align:center;font-weight:800;font-size:16px;color:{{$r['rank']<=3?'#f59e0b':'#94a3b8'}};">{{$r['rank']<=3?['🥇','🥈','🥉'][$r['rank']-1]:$r['rank']}}</td>
            <td><div style="font-weight:600;">{{$r['name']}}</div><div style="font-size:11px;color:#94a3b8;">{{$r['id']}}</div></td>
            <td style="text-align:center;font-weight:700;">{{$r['total']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="flex:1;height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$r['pct']}}%;background:{{$gc}};border-radius:9999px;"></div></div>
                    <span style="font-size:12px;font-weight:700;color:{{$gc}};min-width:36px;">{{$r['pct']}}%</span>
                </div>
            </td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:800;background:{{$r['status']==='Pass'?'#d1fae5':'#fee2e2'}};color:{{$gc}};">{{$r['grade']}}</span></td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Pass'?'#d1fae5':'#fee2e2'}};color:{{$gc}};">{{$r['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
