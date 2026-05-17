@extends('layouts.academic')
@section('title', 'Marksheet Setting')
@section('heading', 'Marksheet Setting')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Marksheet Title</label>
            <input type="text" value="Academic Transcript" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Institution Name</label>
            <input type="text" value="Grand University" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Pass Mark (%)</label>
                <input type="number" value="40" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Full Mark</label>
                <input type="number" value="100" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="show_rank" checked style="width:16px;height:16px;">
            <label for="show_rank" style="font-size:13px;font-weight:600;color:#374151;">Show Class Rank</label>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="show_sign" checked style="width:16px;height:16px;">
            <label for="show_sign" style="font-size:13px;font-weight:600;color:#374151;">Show Principal Signature</label>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Settings</button>
    </form>
</div>
@endsection
