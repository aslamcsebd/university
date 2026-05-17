@extends('layouts.academic')
@section('title', 'Calendar')
@section('heading', 'Calendar')
@section('content')
@php
$events = [
    ['date'=>'Feb 10','title'=>'Annual Sports Day',   'type'=>'Sports',   'color'=>'#6366f1'],
    ['date'=>'Feb 15','title'=>'Science Exhibition',  'type'=>'Academic', 'color'=>'#10b981'],
    ['date'=>'Mar 01','title'=>'Alumni Meet',         'type'=>'Social',   'color'=>'#f59e0b'],
    ['date'=>'Mar 15','title'=>'Graduation Ceremony', 'type'=>'Academic', 'color'=>'#10b981'],
    ['date'=>'Mar 20','title'=>'Semester Exams Begin','type'=>'Exam',     'color'=>'#ef4444'],
    ['date'=>'Apr 05','title'=>'Results Published',   'type'=>'Academic', 'color'=>'#10b981'],
];
@endphp
<div class="card" style="padding:20px;">
    <div style="font-weight:700;font-size:16px;color:#1e293b;margin-bottom:16px;">Upcoming Events</div>
    <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach($events as $e)
        <div style="display:flex;align-items:center;gap:14px;padding:12px 16px;background:#f8fafc;border-radius:10px;border-left:4px solid {{$e['color']}};">
            <div style="min-width:60px;font-weight:700;font-size:13px;color:{{$e['color']}};">{{$e['date']}}</div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:13px;color:#1e293b;">{{$e['title']}}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{$e['type']}}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
