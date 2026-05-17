@extends('layouts.academic')
@section('title', 'Leave Types')
@section('heading', 'Leave Types')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Type</a>
@endsection
@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Leave Type</th><th>Days Allowed</th><th>Paid</th><th>Carry Forward</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','Medical Leave',12,true,false,'#ef4444','#fee2e2'],['2','Personal Leave',6,true,false,'#6366f1','#eef2ff'],['3','Annual Leave',20,true,true,'#10b981','#d1fae5'],['4','Emergency Leave',3,true,false,'#f59e0b','#fef3c7'],['5','Unpaid Leave',30,false,false,'#94a3b8','#f3f4f6']] as $t)
        <tr>
            <td style="color:#94a3b8;">{{$t[0]}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:{{$t[7]}};color:{{$t[6]}};">{{$t[1]}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$t[2]}}</td>
            <td style="text-align:center;"><span style="font-size:16px;">{{$t[3]?'✅':'❌'}}</span></td>
            <td style="text-align:center;"><span style="font-size:16px;">{{$t[4]?'✅':'❌'}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Leave Type</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Type Name</label><input class="form-input" placeholder="e.g. Medical Leave"></div>
        <div><label class="form-label">Days Allowed</label><input type="number" class="form-input" placeholder="12"></div>
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> Paid Leave</label>
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox"> Carry Forward</label>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
