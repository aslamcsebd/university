@extends('layouts.academic')
@section('title', 'Grading Systems')
@section('heading', 'Grading Systems')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Grade</a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:14px;font-weight:700;color:#1e1b4b;">📊 Grading Scale</div>
    <table>
        <thead><tr><th>Grade</th><th>Marks Range</th><th>GPA Points</th><th>Remark</th><th>Action</th></tr></thead>
        <tbody>
        @foreach([['A+','90-100','4.0','Outstanding','#10b981','#d1fae5'],['A','80-89','3.7','Excellent','#6366f1','#eef2ff'],['B+','70-79','3.3','Very Good','#0ea5e9','#e0f2fe'],['B','60-69','3.0','Good','#f59e0b','#fef3c7'],['C','50-59','2.0','Average','#8b5cf6','#f5f3ff'],['F','0-49','0.0','Fail','#ef4444','#fee2e2']] as $g)
        <tr>
            <td><span style="padding:4px 12px;border-radius:20px;font-size:13px;font-weight:800;background:{{$g[5]}};color:{{$g[4]}};">{{$g[0]}}</span></td>
            <td style="font-weight:600;">{{$g[1]}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$g[2]}}</td>
            <td style="color:#64748b;">{{$g[3]}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">➕ Add / Edit Grade</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Grade Letter</label><input class="form-input" placeholder="e.g. A+"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Marks From</label><input type="number" class="form-input" placeholder="0"></div>
            <div><label class="form-label">Marks To</label><input type="number" class="form-input" placeholder="100"></div>
        </div>
        <div><label class="form-label">GPA Points</label><input type="number" step="0.1" class="form-input" placeholder="4.0"></div>
        <div><label class="form-label">Remark</label><input class="form-input" placeholder="e.g. Outstanding"></div>
        <div><label class="form-label">Color</label><input type="color" class="form-input" value="#10b981" style="height:40px;cursor:pointer;"></div>
        <button class="btn btn-primary">Save Grade</button>
    </div>
</div>
</div>
@endsection
