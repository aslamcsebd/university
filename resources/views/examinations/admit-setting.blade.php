@extends('layouts.academic')
@section('title', 'Admit Setting')
@section('heading', 'Admit Setting')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ Admit Card Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div><label class="form-label">Institution Name</label><input class="form-input" value="Academy University"></div>
        <div><label class="form-label">Exam Title</label><input class="form-input" value="Mid-Term Examination 2025"></div>
        <div><label class="form-label">Header Note</label><textarea class="form-input" rows="2">This card must be presented at the examination hall.</textarea></div>
        <div><label class="form-label">Footer Note</label><textarea class="form-input" rows="2">No admit card = No entry. Mobile phones are strictly prohibited.</textarea></div>
        <div>
            <label class="form-label">Show Fields on Card</label>
            <div style="display:flex;flex-direction:column;gap:6px;margin-top:6px;">
                @foreach(['Student Photo','Roll Number','Course','Semester','Exam Schedule','Venue','Barcode','Signature Line'] as $item)
                <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;"><input type="checkbox" checked> {{$item}}</label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-primary">Save Settings</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:16px;">🖨 Print Settings</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Paper Size</label><select class="form-select"><option>A4</option><option>A5</option><option>Letter</option></select></div>
        <div><label class="form-label">Cards Per Page</label><select class="form-select"><option>1</option><option>2</option><option>4</option></select></div>
        <div><label class="form-label">Border Style</label><select class="form-select"><option>Solid</option><option>Dashed</option><option>None</option></select></div>
        <div><label class="form-label">Header Color</label><input type="color" class="form-input" value="#1e1b4b" style="height:40px;cursor:pointer;"></div>
        <button class="btn btn-secondary">Preview</button>
    </div>
</div>
</div>
@endsection
