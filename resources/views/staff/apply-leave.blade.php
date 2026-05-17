@extends('layouts.academic')
@section('title', 'Apply Leave')
@section('heading', 'Apply Leave')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">🏖️ Leave Application</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Leave Type</label><select class="form-select"><option>Medical Leave</option><option>Personal Leave</option><option>Family Emergency</option><option>Conference/Training</option></select></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">From Date</label><input type="date" class="form-input"></div>
            <div><label class="form-label">To Date</label><input type="date" class="form-input"></div>
        </div>
        <div><label class="form-label">Reason</label><textarea class="form-input" rows="4" placeholder="Describe the reason for leave..."></textarea></div>
        <div><label class="form-label">Attach Document (optional)</label><input type="file" class="form-input"></div>
        <button class="btn btn-primary">Submit Application</button>
    </div>
</div>
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:14px;font-weight:700;color:#1e1b4b;">My Leave Balance</div>
    <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
        @foreach([['Medical Leave',12,8,4,'#ef4444'],['Personal Leave',6,4,2,'#6366f1'],['Annual Leave',20,15,5,'#10b981'],['Emergency Leave',3,1,2,'#f59e0b']] as $l)
        @php $used=$l[2]; $total=$l[1]; $pct=round($used/$total*100); @endphp
        <div style="padding:12px 14px;background:#f8fafc;border-radius:10px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:13px;font-weight:600;color:#1e293b;">{{$l[0]}}</span>
                <span style="font-size:12px;color:#64748b;">{{$l[2]}} used / {{$l[1]}} total</span>
            </div>
            <div style="height:6px;background:#e2e8f0;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:{{$l[4]}};border-radius:9999px;"></div></div>
            <div style="font-size:11px;color:#10b981;font-weight:600;margin-top:4px;">{{$l[3]}} days remaining</div>
        </div>
        @endforeach
    </div>
</div>
</div>
@endsection
