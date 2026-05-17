@extends('layouts.academic')
@section('title', 'ID Card Setting')
@section('heading', 'ID Card Setting')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:18px;">⚙️ ID Card Configuration</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        @foreach(['Institution Name','Institution Logo URL','Card Background Color','Card Text Color','Valid From Year','Valid To Year','Footer Text','Website URL'] as $f)
        <div>
            <label class="form-label">{{$f}}</label>
            <input class="form-input" placeholder="Enter {{$f}}">
        </div>
        @endforeach
        <div>
            <label class="form-label">Show Fields</label>
            <div style="display:flex;flex-direction:column;gap:8px;margin-top:4px;">
                @foreach(['Student ID','Course','Batch','Department','Photo','Barcode','QR Code'] as $opt)
                <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;">
                    <input type="checkbox" checked> {{$opt}}
                </label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-primary" style="margin-top:6px;">Save Settings</button>
    </div>
</div>
<div>
    <div style="font-size:13px;font-weight:700;color:#1e1b4b;margin-bottom:12px;">Live Preview</div>
    <div style="width:100%;background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:24px;color:#fff;box-shadow:0 8px 30px rgba(79,70,229,.3);">
        <div style="font-size:11px;font-weight:700;letter-spacing:.1em;opacity:.7;margin-bottom:14px;">🎓 ACADEMY — STUDENT ID</div>
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
            <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;">AJ</div>
            <div>
                <div style="font-size:17px;font-weight:800;">Student Name</div>
                <div style="font-size:11px;opacity:.7;margin-top:3px;">STU-XXXX · Course Name</div>
                <div style="font-size:11px;opacity:.7;">Batch XXXX–XXXX</div>
            </div>
        </div>
        <div style="padding-top:12px;border-top:1px solid rgba(255,255,255,.2);font-size:10px;opacity:.6;">Valid: XXXX – XXXX · academy.edu</div>
    </div>
</div>
</div>
@endsection
