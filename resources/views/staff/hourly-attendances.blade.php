@extends('layouts.academic')
@section('title', 'Hourly Attendances')
@section('heading', 'Hourly Attendances')
@section('content')
@php
$records = [
    ['id'=>'STF-001','name'=>'Dr. Mitchell',  'date'=>'Jul 15','slot'=>'08:00-09:00','subject'=>'CS201','room'=>'Room 101','status'=>'Present'],
    ['id'=>'STF-001','name'=>'Dr. Mitchell',  'date'=>'Jul 15','slot'=>'09:00-10:00','subject'=>'CS201','room'=>'Room 101','status'=>'Present'],
    ['id'=>'STF-002','name'=>'Prof. Okafor',  'date'=>'Jul 15','slot'=>'10:00-11:00','subject'=>'MATH202','room'=>'Hall B','status'=>'Present'],
    ['id'=>'STF-003','name'=>'Dr. Nair',      'date'=>'Jul 15','slot'=>'14:00-15:00','subject'=>'PHY101','room'=>'Lab 1','status'=>'Absent'],
    ['id'=>'STF-004','name'=>'Dr. Yusuf',     'date'=>'Jul 15','slot'=>'10:00-11:00','subject'=>'CS301','room'=>'Room 102','status'=>'Present'],
];
@endphp
<div style="display:flex;gap:10px;margin-bottom:16px;">
    <input type="date" class="form-input" style="width:180px;" value="2025-07-15">
    <select class="form-select" style="width:200px;"><option>All Staff</option></select>
    <button class="btn btn-primary">Filter</button>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Staff ID</th><th>Name</th><th>Date</th><th>Time Slot</th><th>Subject</th><th>Room</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($records as $r)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$r['id']}}</td>
            <td style="font-weight:600;">{{$r['name']}}</td>
            <td style="color:#64748b;">{{$r['date']}}</td>
            <td style="font-weight:600;color:#1e293b;">{{$r['slot']}}</td>
            <td><span style="padding:2px 8px;background:#eef2ff;color:#6366f1;border-radius:6px;font-size:11px;font-weight:700;">{{$r['subject']}}</span></td>
            <td style="color:#64748b;">{{$r['room']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$r['status']==='Present'?'#d1fae5':'#fee2e2'}};color:{{$r['status']==='Present'?'#065f46':'#991b1b'}};">{{$r['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
