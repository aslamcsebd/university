@extends('layouts.academic')
@section('title', 'Exam Types')
@section('heading', 'Exam Types')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Type</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Exam Type</th><th>Max Marks</th><th>Pass Marks</th><th>Duration</th><th>Weightage</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['1','Mid-Term','100','40','3 hrs','30%','#6366f1','#eef2ff'],['2','Final Exam','100','40','3 hrs','50%','#10b981','#d1fae5'],['3','Quiz','20','8','30 mins','10%','#f59e0b','#fef3c7'],['4','Assignment','20','8','—','10%','#8b5cf6','#f5f3ff'],['5','Practical','50','20','2 hrs','—','#0ea5e9','#e0f2fe']] as $t)
        <tr>
            <td style="color:#94a3b8;">{{$t[0]}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:{{$t[7]}};color:{{$t[6]}};">{{$t[1]}}</span></td>
            <td style="text-align:center;font-weight:700;">{{$t[2]}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$t[3]}}</td>
            <td style="color:#64748b;">{{$t[4]}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$t[5]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Exam Type</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Type Name</label><input class="form-input" placeholder="e.g. Mid-Term"></div>
        <div><label class="form-label">Max Marks</label><input type="number" class="form-input" placeholder="100"></div>
        <div><label class="form-label">Pass Marks</label><input type="number" class="form-input" placeholder="40"></div>
        <div><label class="form-label">Duration</label><input class="form-input" placeholder="e.g. 3 hrs"></div>
        <div><label class="form-label">Weightage (%)</label><input type="number" class="form-input" placeholder="30"></div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
</div>
@endsection
