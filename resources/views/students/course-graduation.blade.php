@extends('layouts.academic')
@section('title', 'Course Graduation')
@section('heading', 'Course Graduation')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">🎓 Process Graduation</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-003','name'=>'Ravi Kumar',  'course'=>'B.Com Accounting',      'batch'=>'2022-25','cgpa'=>'3.65','credits'=>120,'status'=>'Eligible'],
    ['id'=>'STU-006','name'=>'Priya Sharma','course'=>'B.Sc Mathematics',       'batch'=>'2022-25','cgpa'=>'3.82','credits'=>120,'status'=>'Eligible'],
    ['id'=>'STU-007','name'=>'Tom Baker',   'course'=>'B.A English Literature', 'batch'=>'2022-25','cgpa'=>'2.90','credits'=>115,'status'=>'Incomplete'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Eligible','2','🎓','linear-gradient(135deg,#10b981,#34d399)'],['Incomplete','1','⚠️','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Graduated','187','✅','linear-gradient(135deg,#6366f1,#818cf8)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th><input type="checkbox"></th><th>ID</th><th>Name</th><th>Course</th><th>Batch</th><th>CGPA</th><th>Credits</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td><input type="checkbox"></td>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="color:#64748b;">{{$s['batch']}}</td>
            <td style="font-weight:700;">{{$s['cgpa']}}</td>
            <td style="text-align:center;">{{$s['credits']}}/120</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Eligible'?'#d1fae5':'#fef3c7'}};color:{{$s['status']==='Eligible'?'#065f46':'#92400e'}};">{{$s['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Process</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
