@extends('layouts.academic')
@section('title', 'Mark Distribution')
@section('heading', 'Mark Distribution')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Distribution</a>
@endsection

@section('content')
@php
$distributions = [
    ['program'=>'B.Sc CS',    'semester'=>'All','mid'=>30,'final'=>50,'assignment'=>10,'quiz'=>10,'total'=>100],
    ['program'=>'B.E Civil',  'semester'=>'All','mid'=>30,'final'=>50,'assignment'=>10,'quiz'=>10,'total'=>100],
    ['program'=>'B.A English','semester'=>'All','mid'=>40,'final'=>40,'assignment'=>10,'quiz'=>10,'total'=>100],
    ['program'=>'B.Com',      'semester'=>'All','mid'=>35,'final'=>45,'assignment'=>10,'quiz'=>10,'total'=>100],
];
@endphp
<div class="card" style="overflow:hidden;margin-bottom:20px;">
    <table>
        <thead><tr><th>Program</th><th>Semester</th><th style="text-align:center;">Mid-Term %</th><th style="text-align:center;">Final %</th><th style="text-align:center;">Assignment %</th><th style="text-align:center;">Quiz %</th><th style="text-align:center;">Total</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($distributions as $d)
        <tr>
            <td style="font-weight:600;">{{$d['program']}}</td>
            <td style="color:#64748b;">{{$d['semester']}}</td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$d['mid']}}%</span></td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#d1fae5;color:#065f46;">{{$d['final']}}%</span></td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#fef3c7;color:#92400e;">{{$d['assignment']}}%</span></td>
            <td style="text-align:center;"><span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#f5f3ff;color:#8b5cf6;">{{$d['quiz']}}%</span></td>
            <td style="text-align:center;font-weight:800;">{{$d['total']}}%</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card" style="padding:24px;max-width:500px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">➕ Add Distribution</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Program</label><select class="form-select"><option>B.Sc CS</option></select></div>
        <div><label class="form-label">Semester</label><select class="form-select"><option>All</option><option>Semester 1</option></select></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Mid-Term %</label><input type="number" class="form-input" value="30"></div>
            <div><label class="form-label">Final %</label><input type="number" class="form-input" value="50"></div>
            <div><label class="form-label">Assignment %</label><input type="number" class="form-input" value="10"></div>
            <div><label class="form-label">Quiz %</label><input type="number" class="form-input" value="10"></div>
        </div>
        <button class="btn btn-primary">Save</button>
    </div>
</div>
@endsection
