@extends('layouts.academic')
@section('title', 'Payment Getaways')
@section('heading', 'Payment Getaways')
@section('content')
@php
$gateways = [
    ['name'=>'Stripe',     'icon'=>'💳','enabled'=>true],
    ['name'=>'PayPal',     'icon'=>'🅿️','enabled'=>true],
    ['name'=>'Razorpay',   'icon'=>'💰','enabled'=>false],
    ['name'=>'SSLCommerz', 'icon'=>'🔒','enabled'=>false],
];
@endphp
<div style="display:flex;flex-direction:column;gap:16px;">
    @foreach($gateways as $g)
    <div class="card" style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <span style="font-size:24px;">{{$g['icon']}}</span>
            <div>
                <div style="font-weight:700;font-size:14px;color:#1e293b;">{{$g['name']}}</div>
                <div style="font-size:12px;color:#94a3b8;">Payment gateway integration</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <span style="padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;background:{{$g['enabled']?'#d1fae5':'#f1f5f9'}};color:{{$g['enabled']?'#065f46':'#64748b'}};">{{$g['enabled']?'Enabled':'Disabled'}}</span>
            <a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Configure</a>
        </div>
    </div>
    @endforeach
</div>
@endsection
