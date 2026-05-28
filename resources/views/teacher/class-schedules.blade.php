@extends('layouts.academic')
@section('title', 'My Class Schedule')
@section('heading', 'My Class Schedule')
@section('content')
@php
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
$slots = ['8–9 AM','9–10 AM','10–11 AM','11–12 PM','12–1 PM','1–2 PM','2–3 PM','3–4 PM'];
$timetable = [
    'Monday'    => ['9–10 AM'=>['sub'=>'Data Structures','code'=>'CS201','room'=>'Lab 3',  'color'=>'#6366f1','bg'=>'#eef2ff'],
                    '2–3 PM' =>['sub'=>'Algorithms',     'code'=>'CS401','room'=>'Room 5', 'color'=>'#0ea5e9','bg'=>'#e0f2fe']],
    'Tuesday'   => ['11–12 PM'=>['sub'=>'Database Systems','code'=>'CS301','room'=>'Room 12','color'=>'#10b981','bg'=>'#d1fae5']],
    'Wednesday' => ['9–10 AM'=>['sub'=>'Data Structures','code'=>'CS201','room'=>'Lab 3',  'color'=>'#6366f1','bg'=>'#eef2ff'],
                    '2–3 PM' =>['sub'=>'Algorithms',     'code'=>'CS401','room'=>'Room 5', 'color'=>'#0ea5e9','bg'=>'#e0f2fe']],
    'Thursday'  => ['11–12 PM'=>['sub'=>'Database Systems','code'=>'CS301','room'=>'Room 12','color'=>'#10b981','bg'=>'#d1fae5']],
    'Friday'    => ['2–4 PM'  =>['sub'=>'Software Engineering','code'=>'CS302','room'=>'Room 7','color'=>'#8b5cf6','bg'=>'#f5f3ff']],
];
@endphp
<div class="card" style="overflow:auto;">
    <table style="min-width:700px;">
        <thead>
            <tr>
                <th style="width:90px;">Time</th>
                @foreach($days as $d)<th>{{ $d }}</th>@endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($slots as $slot)
        <tr>
            <td style="font-size:11px;font-weight:700;color:#64748b;white-space:nowrap;">{{ $slot }}</td>
            @foreach($days as $d)
            <td style="padding:6px 8px;">
                @if(isset($timetable[$d][$slot]))
                @php $c = $timetable[$d][$slot]; @endphp
                <div style="background:{{ $c['bg'] }};border-left:3px solid {{ $c['color'] }};border-radius:6px;padding:7px 10px;">
                    <div style="font-size:12px;font-weight:700;color:{{ $c['color'] }};">{{ $c['sub'] }}</div>
                    <div style="font-size:10px;color:#64748b;margin-top:2px;">{{ $c['code'] }} · {{ $c['room'] }}</div>
                </div>
                @else
                <div style="height:44px;"></div>
                @endif
            </td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
