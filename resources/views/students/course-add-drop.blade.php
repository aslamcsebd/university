@extends('layouts.academic')
@section('title', 'Course Add Drop')
@section('heading', 'Course Add Drop')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#10b981;margin-bottom:16px;">➕ Add Course</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Student</label><select class="form-select"><option>Alex Johnson (STU-001)</option></select></div>
        <div><label class="form-label">Course to Add</label><select class="form-select"><option>CS401 - AI Fundamentals</option><option>CS402 - Cloud Computing</option></select></div>
        <div><label class="form-label">Reason</label><textarea class="form-input" rows="3" placeholder="Reason for adding..."></textarea></div>
        <button class="btn btn-primary">Add Course</button>
    </div>
</div>
<div class="card" style="padding:24px;">
    <div style="font-size:14px;font-weight:700;color:#ef4444;margin-bottom:16px;">➖ Drop Course</div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div><label class="form-label">Student</label><select class="form-select"><option>Alex Johnson (STU-001)</option></select></div>
        <div><label class="form-label">Course to Drop</label><select class="form-select"><option>CS201 - Data Structures</option><option>MATH202 - Calculus II</option></select></div>
        <div><label class="form-label">Reason</label><textarea class="form-input" rows="3" placeholder="Reason for dropping..."></textarea></div>
        <button class="btn btn-danger">Drop Course</button>
    </div>
</div>
</div>
@php
$history = [
    ['student'=>'Alex Johnson','action'=>'Add','course'=>'CS401 - AI Fundamentals','date'=>'Jul 10, 2025','status'=>'Approved'],
    ['student'=>'Sara Ahmed',  'action'=>'Drop','course'=>'MATH202 - Calculus II', 'date'=>'Jul 11, 2025','status'=>'Pending'],
];
@endphp
<div class="card" style="overflow:hidden;margin-top:20px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:14px;font-weight:700;color:#1e1b4b;">Recent Requests</div>
    <table>
        <thead><tr><th>Student</th><th>Action</th><th>Course</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($history as $h)
        <tr>
            <td style="font-weight:600;">{{$h['student']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$h['action']==='Add'?'#d1fae5':'#fee2e2'}};color:{{$h['action']==='Add'?'#065f46':'#991b1b'}};">{{$h['action']}}</span></td>
            <td style="color:#64748b;">{{$h['course']}}</td>
            <td style="color:#64748b;">{{$h['date']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$h['status']==='Approved'?'#d1fae5':'#fef3c7'}};color:{{$h['status']==='Approved'?'#065f46':'#92400e'}};">{{$h['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
