@extends('layouts.academic')
@section('title', 'My Exam Schedules')
@section('heading', 'My Exam Schedules')
@section('content')
@php
$exams = [
    ['subject'=>'Data Structures',      'code'=>'CS201','type'=>'Mid-Term', 'date'=>'Jul 20, 2025','time'=>'9:00 AM','room'=>'Hall A','students'=>32,'status'=>'Upcoming','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['subject'=>'Database Systems',     'code'=>'CS301','type'=>'Mid-Term', 'date'=>'Jul 22, 2025','time'=>'11:00 AM','room'=>'Hall B','students'=>28,'status'=>'Upcoming','color'=>'#10b981','bg'=>'#d1fae5'],
    ['subject'=>'Software Engineering', 'code'=>'CS302','type'=>'Quiz',     'date'=>'Jul 18, 2025','time'=>'2:00 PM', 'room'=>'Room 7','students'=>30,'status'=>'Upcoming','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['subject'=>'Algorithms',           'code'=>'CS401','type'=>'Final',    'date'=>'Aug 10, 2025','time'=>'9:00 AM','room'=>'Hall C','students'=>30,'status'=>'Scheduled','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['subject'=>'Data Structures',      'code'=>'CS201','type'=>'Quiz',     'date'=>'Jun 15, 2025','time'=>'9:00 AM','room'=>'Lab 3', 'students'=>32,'status'=>'Completed','color'=>'#6366f1','bg'=>'#eef2ff'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Subject</th><th>Type</th><th>Date</th><th>Time</th><th>Room</th><th>Students</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($exams as $e)
        @php
            $sc = $e['status']==='Completed'?['#d1fae5','#065f46']:($e['status']==='Upcoming'?['#dbeafe','#1e40af']:['#fef3c7','#92400e']);
        @endphp
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:30px;height:30px;border-radius:8px;background:{{ $e['bg'] }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:{{ $e['color'] }};">{{ substr($e['code'],0,2) }}</div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $e['subject'] }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $e['code'] }}</div>
                    </div>
                </div>
            </td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $e['bg'] }};color:{{ $e['color'] }};">{{ $e['type'] }}</span></td>
            <td style="font-weight:600;color:#1e293b;">{{ $e['date'] }}</td>
            <td style="color:#64748b;">{{ $e['time'] }}</td>
            <td style="color:#64748b;">{{ $e['room'] }}</td>
            <td style="font-weight:700;color:#6366f1;">{{ $e['students'] }}</td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $sc[0] }};color:{{ $sc[1] }};">{{ $e['status'] }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
