@extends('layouts.academic')
@section('title', 'SMS Getaways')
@section('heading', 'SMS Getaways')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">SMS Provider</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Twilio</option>
                <option>Nexmo / Vonage</option>
                <option>AWS SNS</option>
                <option>Custom API</option>
            </select>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">API Key</label>
            <input type="text" placeholder="<credential>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">API Secret</label>
            <input type="password" placeholder="••••••••" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Sender ID</label>
            <input type="text" value="GrandUni" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" id="sms_active" checked style="width:16px;height:16px;">
            <label for="sms_active" style="font-size:13px;font-weight:600;color:#374151;">Enable SMS Notifications</label>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Settings</button>
    </form>
</div>
@endsection
