@extends('layouts.academic')
@section('title', 'About Us')
@section('heading', 'About Us — Web Content')
@section('content')
<div class="card" style="max-width:700px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Heading</label>
            <input type="text" value="About Grand University" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Sub Heading</label>
            <input type="text" value="Excellence in Education Since 1985" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Description</label>
            <textarea rows="6" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;">Grand University has been a beacon of academic excellence for over three decades. We offer world-class education across multiple disciplines with state-of-the-art facilities and experienced faculty.</textarea>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Vision</label>
            <textarea rows="3" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;">To be a globally recognized institution of higher learning.</textarea>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Mission</label>
            <textarea rows="3" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;">To provide quality education that empowers students to excel in their chosen fields.</textarea>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Content</button>
    </form>
</div>
@endsection
