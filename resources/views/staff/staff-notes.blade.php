@extends('layouts.academic')
@section('title', 'Staff Notes')
@section('heading', 'Staff Notes')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Note</a>
@endsection
@section('content')
@php
$notes = [
    ['staff'=>'Dr. Mitchell','id'=>'STF-001','note'=>'Nominated for Best Teacher Award 2025.','by'=>'Dean','date'=>'Jul 10, 2025','type'=>'Achievement','color'=>'#10b981','bg'=>'#d1fae5'],
    ['staff'=>'Prof. Okafor','id'=>'STF-002','note'=>'Requested 2-week research leave in August.','by'=>'Admin','date'=>'Jul 11, 2025','type'=>'Leave','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['staff'=>'Dr. Nair',   'id'=>'STF-003','note'=>'Published paper in IEEE journal.','by'=>'Dean','date'=>'Jul 12, 2025','type'=>'Publication','color'=>'#6366f1','bg'=>'#eef2ff'],
];
@endphp
<div style="display:flex;flex-direction:column;gap:14px;">
@foreach($notes as $n)
<div class="card" style="padding:18px 20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:10px;background:{{$n['bg']}};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:{{$n['color']}};">{{substr($n['staff'],0,2)}}</div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#1e293b;">{{$n['staff']}} <span style="font-size:11px;color:#94a3b8;font-weight:400;">{{$n['id']}}</span></div>
                <div style="font-size:13px;color:#475569;margin-top:4px;">{{$n['note']}}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:6px;">By {{$n['by']}} · {{$n['date']}}</div>
            </div>
        </div>
        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$n['bg']}};color:{{$n['color']}};white-space:nowrap;">{{$n['type']}}</span>
    </div>
</div>
@endforeach
</div>
@endsection
