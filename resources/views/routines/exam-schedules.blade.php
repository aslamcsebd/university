@extends('layouts.academic')
@section('title', 'Exam Schedules')
@section('heading', 'Exam Schedules')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Download Schedule</a>
@endsection

@section('content')
@php
$schedule = [
    ['date'=>'Jul 18, 2025','day'=>'Friday',   'subject'=>'Data Structures',     'code'=>'CS201',  'time'=>'09:00 AM','duration'=>'3 hrs','room'=>'Hall A','invigilator'=>'Dr. Nair'],
    ['date'=>'Jul 20, 2025','day'=>'Sunday',   'subject'=>'Calculus II',          'code'=>'MATH202','time'=>'11:00 AM','duration'=>'3 hrs','room'=>'Hall B','invigilator'=>'Prof. Chen'],
    ['date'=>'Jul 22, 2025','day'=>'Tuesday',  'subject'=>'Physics Lab',          'code'=>'PHY101', 'time'=>'02:00 PM','duration'=>'2 hrs','room'=>'Physics Lab','invigilator'=>'Dr. Nair'],
    ['date'=>'Jul 24, 2025','day'=>'Thursday', 'subject'=>'Database Systems',     'code'=>'CS301',  'time'=>'09:00 AM','duration'=>'3 hrs','room'=>'Hall A','invigilator'=>'Dr. Mitchell'],
    ['date'=>'Jul 25, 2025','day'=>'Friday',   'subject'=>'Software Engineering', 'code'=>'CS302',  'time'=>'11:00 AM','duration'=>'3 hrs','room'=>'Hall C','invigilator'=>'Prof. Okafor'],
];
@endphp
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:14px;padding:18px 24px;margin-bottom:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
    <div>
        <div style="font-size:16px;font-weight:800;">Mid-Term Examination — Semester 3</div>
        <div style="font-size:12px;opacity:.7;margin-top:4px;">B.Sc Computer Science · July 18–25, 2025</div>
    </div>
    <span style="padding:6px 16px;background:rgba(255,255,255,.15);border-radius:20px;font-size:12px;font-weight:700;">Upcoming</span>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Date</th><th>Day</th><th>Subject</th><th>Code</th><th>Time</th><th>Duration</th><th>Room</th><th>Invigilator</th></tr></thead>
        <tbody>
        @foreach($schedule as $i => $s)
        <tr style="background:{{$i%2===0?'#fff':'#fafafa'}};">
            <td style="font-weight:700;color:#1e293b;">{{$s['date']}}</td>
            <td style="color:#64748b;">{{$s['day']}}</td>
            <td style="font-weight:600;">{{$s['subject']}}</td>
            <td><span style="padding:2px 8px;background:#eef2ff;color:#6366f1;border-radius:6px;font-size:11px;font-weight:700;">{{$s['code']}}</span></td>
            <td style="font-weight:600;color:#6366f1;">{{$s['time']}}</td>
            <td style="color:#64748b;">{{$s['duration']}}</td>
            <td style="color:#64748b;">{{$s['room']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['invigilator']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
