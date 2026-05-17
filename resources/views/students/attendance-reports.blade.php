@extends('layouts.academic')
@section('title', 'Attendance Reports')
@section('heading', 'Attendance Reports')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export Report</a>
@endsection

@section('content')
@php
$rows = [
    ['name'=>'Alex Johnson', 'id'=>'STU-001','course'=>'B.Sc CS',    'total'=>100,'present'=>88,'absent'=>12],
    ['name'=>'Sara Ahmed',   'id'=>'STU-002','course'=>'B.A English','total'=>100,'present'=>92,'absent'=>8],
    ['name'=>'Ravi Kumar',   'id'=>'STU-003','course'=>'B.Com',      'total'=>100,'present'=>75,'absent'=>25],
    ['name'=>'Emily Clark',  'id'=>'STU-004','course'=>'B.Sc Physics','total'=>100,'present'=>68,'absent'=>32],
    ['name'=>'Omar Hassan',  'id'=>'STU-005','course'=>'B.E Civil',  'total'=>100,'present'=>95,'absent'=>5],
];
@endphp
<div style="display:flex;gap:10px;margin-bottom:16px;">
    <select class="form-select" style="width:180px;"><option>All Courses</option></select>
    <select class="form-select" style="width:160px;"><option>All Semesters</option></select>
    <input type="month" class="form-input" style="width:160px;" value="2025-07">
    <button class="btn btn-primary">Filter</button>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Student</th><th>ID</th><th>Course</th><th>Total Classes</th><th>Present</th><th>Absent</th><th>Attendance %</th><th>Remark</th></tr></thead>
        <tbody>
        @foreach($rows as $r)
        @php $pct=round($r['present']/$r['total']*100); $c=$pct>=85?'#10b981':($pct>=75?'#f59e0b':'#ef4444'); @endphp
        <tr>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#6366f1;font-weight:700;">{{$r['id']}}</td>
            <td style="color:#64748b;">{{$r['course']}}</td>
            <td style="text-align:center;">{{$r['total']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$r['present']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$r['absent']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="flex:1;height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:{{$c}};border-radius:9999px;"></div></div>
                    <span style="font-size:12px;font-weight:800;color:{{$c}};min-width:36px;">{{$pct}}%</span>
                </div>
            </td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$pct>=75?'#d1fae5':'#fee2e2'}};color:{{$pct>=75?'#065f46':'#991b1b'}};">{{$pct>=85?'Excellent':($pct>=75?'Good':'At Risk')}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
