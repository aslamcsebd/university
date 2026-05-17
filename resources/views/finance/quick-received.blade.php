@extends('layouts.academic')
@section('title', 'Quick Received')
@section('heading', 'Quick Received Fees')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Student</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Select Student</option>
                <option>Alice Johnson (STU-101)</option>
                <option>Bob Smith (STU-102)</option>
                <option>Carol White (STU-103)</option>
            </select>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Invoice / Fee</label>
            <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                <option>Select Invoice</option>
                <option>INV-001 — Tuition Fee $1,200</option>
                <option>INV-002 — Exam Fee $200</option>
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Amount Received ($)</label>
                <input type="number" placeholder="0.00" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Payment Method</label>
                <select style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;">
                    <option>Cash</option>
                    <option>Bank Transfer</option>
                    <option>Card</option>
                    <option>Online</option>
                </select>
            </div>
        </div>
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Transaction ID</label>
            <input type="text" placeholder="Optional" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        <button type="submit" style="padding:10px 24px;background:#10b981;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Record Payment</button>
    </form>
</div>
@endsection
