@extends('layouts.academic')
@section('title', 'Send SMS')
@section('heading', 'Send SMS')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Send To</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>All Students</option>
                <option>All Staff</option>
                <option>All Parents</option>
                <option>Specific Course</option>
                <option>Individual</option>
            </select>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Message <span style="font-weight:400;color:#94a3b8;">(max 160 chars)</span></label>
            <textarea rows="4" maxlength="160" placeholder="Write your SMS message..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;"></textarea>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="schedule" style="width:16px;height:16px;">
            <label for="schedule" style="font-size:13px;font-weight:600;color:#374151;">Schedule for later</label>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Send SMS</button>
    </form>
</div>
@endsection
