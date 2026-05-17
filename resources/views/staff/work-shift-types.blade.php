@extends('layouts.academic')
@section('title', 'Work Shift Types')
@section('heading', 'Work Shift Types')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Shift</a>
@endsection
@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Shift Name</th><th>Start Time</th><th>End Time</th><th>Hours</th><th>Staff</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','Morning Shift','08:00 AM','02:00 PM','6 hrs',12,'#6366f1','#eef2ff'],['2','Afternoon Shift','02:00 PM','08:00 PM','6 hrs',8,'#f59e0b','#fef3c7'],['3','Full Day','08:00 AM','05:00 PM','9 hrs',4,'#10b981','#d1fae5']] as $s)
        <tr>
            <td style="color:#94a3b8;">{{$s[0]}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:{{$s[7]}};color:{{$s[6]}};">{{$s[1]}}</span></td>
            <td style="font-weight:600;color:#1e293b;">{{$s[2]}}</td>
            <td style="font-weight:600;color:#1e293b;">{{$s[3]}}</td>
            <td style="color:#64748b;">{{$s[4]}}</td>
            <td style="text-align:center;font-weight:700;">{{$s[5]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Shift</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Shift Name</label><input class="form-input" placeholder="e.g. Morning Shift"></div>
        <div><label class="form-label">Start Time</label><input type="time" class="form-input" value="08:00"></div>
        <div><label class="form-label">End Time</label><input type="time" class="form-input" value="14:00"></div>
        <div><label class="form-label">Break (mins)</label><input type="number" class="form-input" value="30"></div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
