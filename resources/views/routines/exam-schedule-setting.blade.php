@extends('layouts.academic')
@section('title', 'Exam Schedule Setting')
@section('heading', 'Exam Schedule Setting')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Exam Schedule Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Exam Start Time (Morning)</label><input type="time" class="form-input" value="09:00"></div>
            <div><label class="form-label">Exam Start Time (Afternoon)</label><input type="time" class="form-input" value="14:00"></div>
        </div>
        <div><label class="form-label">Default Exam Duration (hrs)</label><input type="number" class="form-input" value="3"></div>
        <div><label class="form-label">Gap Between Exams (days)</label><input type="number" class="form-input" value="1"></div>
        <div><label class="form-label">Seating Arrangement</label><select class="form-select"><option>Roll Number Order</option><option>Random</option><option>Alphabetical</option></select></div>
        <div>
            <label class="form-label">Allowed Items in Exam Hall</label>
            <div style="display:flex;flex-direction:column;gap:6px;margin-top:6px;">
                @foreach(['Pen/Pencil','Calculator (Non-programmable)','Ruler','Eraser','Water Bottle'] as $item)
                <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> {{$item}}</label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">📋 Exam Slots</div>
    <div style="display:flex;flex-direction:column;gap:8px;">
        @foreach([['Morning Slot','09:00 AM – 12:00 PM','3 hours','#6366f1','#eef2ff'],['Afternoon Slot','02:00 PM – 05:00 PM','3 hours','#10b981','#d1fae5'],['Short Slot','09:00 AM – 11:00 AM','2 hours','#f59e0b','#fef3c7']] as $slot)
        <div style="padding:14px 16px;background:{{$slot[4]}};border-radius:10px;border-left:4px solid {{$slot[3]}};">
            <div style="font-size:13px;font-weight:700;color:{{$slot[3]}};">{{$slot[0]}}</div>
            <div style="font-size:12px;color:#475569;margin-top:3px;">{{$slot[1]}} · {{$slot[2]}}</div>
        </div>
        @endforeach
    </div>
</div>
</div>
@endsection
