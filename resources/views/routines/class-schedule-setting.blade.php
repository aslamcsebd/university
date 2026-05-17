@extends('layouts.academic')
@section('title', 'Class Schedule Setting')
@section('heading', 'Class Schedule Setting')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Schedule Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Working Days Start</label><select class="form-select"><option>Monday</option><option>Sunday</option></select></div>
            <div><label class="form-label">Working Days End</label><select class="form-select"><option>Friday</option><option>Saturday</option></select></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">School Start Time</label><input type="time" class="form-input" value="08:00"></div>
            <div><label class="form-label">School End Time</label><input type="time" class="form-input" value="17:00"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Period Duration (mins)</label><input type="number" class="form-input" value="60"></div>
            <div><label class="form-label">Break Duration (mins)</label><input type="number" class="form-input" value="15"></div>
        </div>
        <div><label class="form-label">Break Time</label><input type="time" class="form-input" value="12:00"></div>
        <div><label class="form-label">Max Classes Per Day</label><input type="number" class="form-input" value="6"></div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">📅 Time Slots Preview</div>
    <div style="display:flex;flex-direction:column;gap:6px;">
        @foreach(['08:00 – 09:00','09:00 – 10:00','10:00 – 11:00','11:00 – 12:00','12:00 – 12:15 (Break)','12:15 – 13:15','13:15 – 14:15','14:15 – 15:15'] as $i => $slot)
        <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;background:{{str_contains($slot,'Break')?'#fef3c7':'#f8fafc'}};border:1px solid {{str_contains($slot,'Break')?'#fde68a':'#e2e8f0'}};">
            <span style="font-size:11px;font-weight:700;color:{{str_contains($slot,'Break')?'#92400e':'#475569'}};min-width:20px;">{{str_contains($slot,'Break')?'☕':($i+1)}}</span>
            <span style="font-size:13px;font-weight:600;color:{{str_contains($slot,'Break')?'#92400e':'#1e293b'}};">{{$slot}}</span>
        </div>
        @endforeach
    </div>
</div>
</div>
@endsection
