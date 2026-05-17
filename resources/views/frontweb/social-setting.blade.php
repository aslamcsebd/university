@extends('layouts.academic')
@section('title', 'Social Setting')
@section('heading', 'Social Setting')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        @foreach([['Facebook','🔵'],['Twitter / X','🐦'],['Instagram','📸'],['LinkedIn','💼'],['YouTube','▶️'],['WhatsApp','💬']] as $s)
        <div>
            <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">{{$s[1]}} {{$s[0]}}</label>
            <input type="url" placeholder="https://..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;">
        </div>
        @endforeach
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;">Save Settings</button>
    </form>
</div>
@endsection
