@extends('layouts.academic')
@section('title', 'Designations')
@section('heading', 'Designations')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Designation</a>
@endsection
@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Designation</th><th>Department</th><th>Level</th><th>Staff Count</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','Professor','Academic','Senior',6],['2','Associate Professor','Academic','Mid',5],['3','Lecturer','Academic','Junior',8],['4','Lab Instructor','Academic','Junior',3],['5','Admin Officer','Administration','Mid',2]] as $d)
        <tr>
            <td style="color:#94a3b8;">{{$d[0]}}</td>
            <td style="font-weight:600;">{{$d[1]}}</td>
            <td style="color:#64748b;">{{$d[2]}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$d[3]==='Senior'?'#eef2ff':($d[3]==='Mid'?'#fef3c7':'#d1fae5')}};color:{{$d[3]==='Senior'?'#6366f1':($d[3]==='Mid'?'#92400e':'#065f46')}};">{{$d[3]}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$d[4]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Designation</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Designation Name</label><input class="form-input" placeholder="e.g. Professor"></div>
        <div><label class="form-label">Department</label><select class="form-select"><option>Academic</option><option>Administration</option></select></div>
        <div><label class="form-label">Level</label><select class="form-select"><option>Senior</option><option>Mid</option><option>Junior</option></select></div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
