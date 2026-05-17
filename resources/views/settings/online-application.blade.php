@extends('layouts.academic')
@section('title', 'Online Application')
@section('heading', 'Online Application Settings')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="app_open" checked style="width:16px;height:16px;">
            <label for="app_open" style="font-size:13px;font-weight:600;color:#374151;">Applications Open</label>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Start Date</label>
                <input type="date" value="2024-01-01" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">End Date</label>
                <input type="date" value="2024-03-31" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Application Fee ($)</label>
            <input type="number" value="50" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Instructions</label>
            <textarea rows="4" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;">Please fill all required fields accurately. Incomplete applications will not be processed.</textarea>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Settings</button>
    </form>
</div>
@endsection
