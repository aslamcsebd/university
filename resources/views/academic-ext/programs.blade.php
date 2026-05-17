@extends('layouts.academic')
@section('title', 'Programs')
@section('heading', 'Programs')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Program</a>
@endsection

@section('content')
@php
$programs = [
    ['id'=>'PRG-001','name'=>'B.Sc Computer Science','faculty'=>'Faculty of Science',  'duration'=>'3 Years','credits'=>120,'students'=>312,'status'=>'Active'],
    ['id'=>'PRG-002','name'=>'B.A English Literature','faculty'=>'Faculty of Arts',    'duration'=>'3 Years','credits'=>100,'students'=>180,'status'=>'Active'],
    ['id'=>'PRG-003','name'=>'B.E Civil Engineering', 'faculty'=>'Faculty of Engineering','duration'=>'4 Years','credits'=>160,'students'=>420,'status'=>'Active'],
    ['id'=>'PRG-004','name'=>'B.Com Accounting',      'faculty'=>'Faculty of Commerce','duration'=>'3 Years','credits'=>110,'students'=>240,'status'=>'Active'],
    ['id'=>'PRG-005','name'=>'B.Sc Mathematics',      'faculty'=>'Faculty of Science', 'duration'=>'3 Years','credits'=>120,'students'=>145,'status'=>'Inactive'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <input placeholder="Search programs..." class="form-input" style="max-width:260px;">
        <select class="form-select" style="width:200px;"><option>All Faculties</option></select>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Program Name</th><th>Faculty</th><th>Duration</th><th>Credits</th><th>Students</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($programs as $p)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$p['id']}}</td>
            <td style="font-weight:600;">{{$p['name']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$p['faculty']}}</td>
            <td style="color:#64748b;">{{$p['duration']}}</td>
            <td style="text-align:center;font-weight:700;">{{$p['credits']}}</td>
            <td style="text-align:center;font-weight:700;">{{$p['students']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$p['status']==='Active'?'#d1fae5':'#f3f4f6'}};color:{{$p['status']==='Active'?'#065f46':'#374151'}};">{{$p['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
