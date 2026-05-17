@extends('layouts.academic')
@section('title', 'Assignments')
@section('heading', 'Assignments')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Create Assignment</a>
@endsection

@section('content')
@php
$assignments = [
    ['id'=>'ASN-001','title'=>'Binary Tree Implementation','subject'=>'CS201','staff'=>'Dr. Mitchell','given'=>'Jul 10','due'=>'Jul 17','submissions'=>38,'total'=>42,'status'=>'Active'],
    ['id'=>'ASN-002','title'=>'Integration Problems Set 3', 'subject'=>'MATH202','staff'=>'Prof. Okafor','given'=>'Jul 11','due'=>'Jul 18','submissions'=>30,'total'=>42,'status'=>'Active'],
    ['id'=>'ASN-003','title'=>'Lab Report – Optics',        'subject'=>'PHY101', 'staff'=>'Dr. Nair',   'given'=>'Jul 08','due'=>'Jul 15','submissions'=>42,'total'=>42,'status'=>'Closed'],
    ['id'=>'ASN-004','title'=>'ER Diagram Design',          'subject'=>'CS301',  'staff'=>'Dr. Yusuf',  'given'=>'Jul 12','due'=>'Jul 20','submissions'=>15,'total'=>42,'status'=>'Active'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total','4','📋','linear-gradient(135deg,#6366f1,#818cf8)'],['Active','3','✅','linear-gradient(135deg,#10b981,#34d399)'],['Closed','1','🔒','linear-gradient(135deg,#94a3b8,#cbd5e1)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Subject</th><th>Staff</th><th>Given</th><th>Due</th><th>Submissions</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($assignments as $a)
        @php $pct=round($a['submissions']/$a['total']*100); @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$a['id']}}</td>
            <td style="font-weight:600;">{{$a['title']}}</td>
            <td><span style="padding:2px 8px;background:#eef2ff;color:#6366f1;border-radius:6px;font-size:11px;font-weight:700;">{{$a['subject']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$a['staff']}}</td>
            <td style="color:#64748b;">{{$a['given']}}</td>
            <td style="color:#64748b;font-weight:600;">{{$a['due']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="flex:1;height:5px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:#6366f1;border-radius:9999px;"></div></div>
                    <span style="font-size:11px;color:#64748b;">{{$a['submissions']}}/{{$a['total']}}</span>
                </div>
            </td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$a['status']==='Active'?'#d1fae5':'#f3f4f6'}};color:{{$a['status']==='Active'?'#065f46':'#374151'}};">{{$a['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
