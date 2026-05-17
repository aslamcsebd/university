@extends('layouts.academic')
@section('title', 'Send Email')
@section('heading', 'Send Email')
@section('content')
<div class="card" style="max-width:700px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Send To</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>All Students</option>
                <option>All Staff</option>
                <option>Specific Course</option>
                <option>Individual</option>
            </select>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Subject</label>
            <input type="text" placeholder="Email subject..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Message</label>
            <textarea rows="6" placeholder="Write your message here..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;"></textarea>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Send Email</button>
            <button type="button" style="padding:10px 24px;background:#f1f5f9;color:#374151;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Save Draft</button>
        </div>
    </form>
</div>
@endsection
