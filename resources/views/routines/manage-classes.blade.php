@extends('layouts.academic')
@section('title', 'Manage Classes')
@section('heading', 'Manage Classes')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Class</a>
@endsection

@section('content')
@php
$classes = [
    ['id'=>'CLS-001','subject'=>'Data Structures','code'=>'CS201','staff'=>'Dr. Mitchell','room'=>'Room 101','day'=>'Monday',   'time'=>'09:00-11:00','section'=>'Sec A','status'=>'Active'],
    ['id'=>'CLS-002','subject'=>'Calculus II',    'code'=>'MATH202','staff'=>'Prof. Okafor','room'=>'Hall B', 'day'=>'Tuesday',  'time'=>'11:00-12:00','section'=>'Sec A','status'=>'Active'],
    ['id'=>'CLS-003','subject'=>'Physics Lab',    'code'=>'PHY101', 'staff'=>'Dr. Nair',   'room'=>'Lab 1',  'day'=>'Wednesday','time'=>'14:00-16:00','section'=>'Sec B','status'=>'Active'],
    ['id'=>'CLS-004','subject'=>'Database Systems','code'=>'CS301', 'staff'=>'Dr. Yusuf',  'room'=>'Room 102','day'=>'Thursday', 'time'=>'10:00-11:00','section'=>'Sec A','status'=>'Cancelled'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <select class="form-select" style="width:160px;"><option>All Days</option></select>
        <select class="form-select" style="width:180px;"><option>All Sections</option></select>
        <input placeholder="Search..." class="form-input" style="max-width:200px;">
    </div>
    <table>
        <thead><tr><th>ID</th><th>Subject</th><th>Staff</th><th>Room</th><th>Day</th><th>Time</th><th>Section</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($classes as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['id']}}</td>
            <td><div style="font-weight:600;">{{$c['subject']}}</div><div style="font-size:11px;color:#94a3b8;">{{$c['code']}}</div></td>
            <td style="color:#64748b;font-size:12px;">{{$c['staff']}}</td>
            <td style="color:#64748b;">{{$c['room']}}</td>
            <td style="color:#64748b;">{{$c['day']}}</td>
            <td style="font-weight:600;color:#1e293b;">{{$c['time']}}</td>
            <td style="color:#64748b;">{{$c['section']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$c['status']==='Active'?'#d1fae5':'#fee2e2'}};color:{{$c['status']==='Active'?'#065f46':'#991b1b'}};">{{$c['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
