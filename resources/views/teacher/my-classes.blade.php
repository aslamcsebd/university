@extends('layouts.academic')
@section('title', 'My Classes')
@section('heading', 'My Classes')
@section('content')
@php
$classes = [
    ['subject'=>'Data Structures',      'code'=>'CS201','batch'=>'2023','section'=>'A','students'=>32,'schedule'=>'Mon/Wed 9–10 AM',  'room'=>'Lab 3',  'color'=>'#6366f1','bg'=>'#eef2ff','att'=>88],
    ['subject'=>'Database Systems',     'code'=>'CS301','batch'=>'2022','section'=>'B','students'=>28,'schedule'=>'Tue/Thu 11–12 PM', 'room'=>'Room 12','color'=>'#10b981','bg'=>'#d1fae5','att'=>92],
    ['subject'=>'Software Engineering', 'code'=>'CS302','batch'=>'2022','section'=>'A','students'=>30,'schedule'=>'Fri 2–4 PM',       'room'=>'Room 7', 'color'=>'#8b5cf6','bg'=>'#f5f3ff','att'=>85],
    ['subject'=>'Algorithms',           'code'=>'CS401','batch'=>'2021','section'=>'C','students'=>30,'schedule'=>'Mon/Wed 2–3 PM',   'room'=>'Room 5', 'color'=>'#0ea5e9','bg'=>'#e0f2fe','att'=>90],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Subject</th><th>Batch</th><th>Section</th><th>Students</th><th>Schedule</th><th>Room</th><th>Avg Attendance</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($classes as $c)
        @php $attColor = $c['att']>=85?'#10b981':($c['att']>=75?'#f59e0b':'#ef4444'); @endphp
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:{{ $c['bg'] }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{ $c['color'] }};">{{ substr($c['code'],0,2) }}</div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $c['subject'] }}</div>
                        <div style="font-size:11px;color:#94a3b8;">{{ $c['code'] }}</div>
                    </div>
                </div>
            </td>
            <td style="color:#64748b;">{{ $c['batch'] }}</td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $c['bg'] }};color:{{ $c['color'] }};">{{ $c['section'] }}</span></td>
            <td style="font-weight:700;color:#6366f1;">{{ $c['students'] }}</td>
            <td style="font-size:12px;color:#64748b;">{{ $c['schedule'] }}</td>
            <td style="font-size:12px;color:#64748b;">{{ $c['room'] }}</td>
            <td style="font-weight:700;color:{{ $attColor }};">{{ $c['att'] }}%</td>
            <td>
                <div style="display:flex;gap:6px;">
                    <a href="/teacher/attendance" class="btn btn-primary btn-sm">Attendance</a>
                    <a href="/teacher/mark-entry" class="btn btn-secondary btn-sm">Marks</a>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
