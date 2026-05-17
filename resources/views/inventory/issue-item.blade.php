@extends('layouts.academic')
@section('title', 'Issue Item')
@section('heading', 'Issue Item')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Issued To</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Select Person</option>
                <option>Mr. Adams (Staff)</option>
                <option>Ms. Rivera (Staff)</option>
                <option>Alice Johnson (Student)</option>
            </select>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Item</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Select Item</option>
                <option>Laptop (ITM-001)</option>
                <option>Projector (ITM-002)</option>
                <option>Calculator (ITM-003)</option>
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Quantity</label>
                <input type="number" value="1" min="1" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Return Date</label>
                <input type="date" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Note</label>
            <textarea rows="2" placeholder="Optional..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;resize:vertical;"></textarea>
        </div>
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Issue Item</button>
    </form>
</div>
@endsection
