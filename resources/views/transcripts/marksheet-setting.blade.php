@extends('layouts.academic')
@section('title', 'Marksheet Setting')
@section('heading', 'Marksheet Setting')
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Marksheet Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Marksheet Title</label><input class="form-input" value="Academic Transcript"></div>
        <div><label class="form-label">Institution Name</label><input class="form-input" value="Grand University"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div><label class="form-label">Pass Mark (%)</label><input type="number" class="form-input" value="40"></div>
            <div><label class="form-label">Full Mark</label><input type="number" class="form-input" value="100"></div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            <label class="form-label">Display Options</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> Show Class Rank</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> Show Principal Signature</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> Show GPA</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox"> Show Remarks</label>
        </div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">🖨 Print Settings</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Paper Size</label><select class="form-select"><option>A4</option><option>A5</option><option>Letter</option></select></div>
        <div><label class="form-label">Orientation</label><select class="form-select"><option>Portrait</option><option>Landscape</option></select></div>
        <div><label class="form-label">Header Color</label><input type="color" class="form-input" value="#1e1b4b" style="height:40px;cursor:pointer;"></div>
        <div><label class="form-label">Footer Note</label><textarea class="form-input" rows="3">This is an official academic transcript issued by the institution.</textarea></div>
        <button class="btn btn-secondary">Preview</button>
    </div>
</div>
</div>
@endsection
