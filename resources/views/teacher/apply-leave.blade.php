@extends('layouts.academic')
@section('title', 'Apply Leave')
@section('heading', 'Apply Leave')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div class="card" style="padding:24px;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">📋 Leave Application</div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div><label class="form-label">Leave Type</label>
                <select class="form-select"><option>Medical Leave</option><option>Casual Leave</option><option>Personal Leave</option><option>Emergency Leave</option></select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div><label class="form-label">From Date</label><input type="date" class="form-input"></div>
                <div><label class="form-label">To Date</label><input type="date" class="form-input"></div>
            </div>
            <div><label class="form-label">Reason</label><textarea class="form-input" rows="4" placeholder="Describe the reason for leave..."></textarea></div>
            <div><label class="form-label">Attach Document (optional)</label><input type="file" class="form-input" style="padding:5px;"></div>
            <button class="btn btn-primary">Submit Application</button>
        </div>
    </div>
    <div class="card" style="padding:24px;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">📊 Leave Balance</div>
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach([['Medical Leave','#ef4444','#fee2e2',12,4],['Casual Leave','#f59e0b','#fef3c7',10,3],['Personal Leave','#6366f1','#eef2ff',6,1],['Emergency Leave','#10b981','#d1fae5',3,0]] as $l)
            @php $used=$l[4]; $total=$l[3]; $rem=$total-$used; $pct=round($used/$total*100); @endphp
            <div style="padding:14px;background:#f8fafc;border-radius:10px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $l[0] }}</span>
                    <span style="font-size:12px;font-weight:700;color:{{ $l[1] }};">{{ $rem }} / {{ $total }} remaining</span>
                </div>
                <div style="height:6px;background:#e5e7eb;border-radius:9999px;"><div style="height:100%;width:{{ $pct }}%;background:{{ $l[1] }};border-radius:9999px;"></div></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
