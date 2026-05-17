@extends('layouts.academic')
@section('title', 'Call To Action')
@section('heading', 'Call To Action — Web Content')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Heading</label>
            <input type="text" value="Start Your Journey Today" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Sub Text</label>
            <input type="text" value="Join thousands of students building their future at Grand University" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Button Text</label>
                <input type="text" value="Apply Now" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Button URL</label>
                <input type="url" value="/apply" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="cta_active" checked style="width:16px;height:16px;">
            <label for="cta_active" style="font-size:13px;font-weight:600;color:#374151;">Show on Website</label>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Content</button>
    </form>
</div>
@endsection
