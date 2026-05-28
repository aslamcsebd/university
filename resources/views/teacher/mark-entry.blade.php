@extends('layouts.academic')
@section('title', 'Mark Entry')
@section('heading', 'Mark Entry')
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson', 'mid'=>72,'assign'=>18,'attend'=>15,'total'=>null],
    ['id'=>'STU-102','name'=>'Bob Smith',     'mid'=>65,'assign'=>16,'attend'=>14,'total'=>null],
    ['id'=>'STU-103','name'=>'Carol White',   'mid'=>80,'assign'=>19,'attend'=>15,'total'=>null],
    ['id'=>'STU-104','name'=>'David Brown',   'mid'=>55,'assign'=>14,'attend'=>12,'total'=>null],
    ['id'=>'STU-105','name'=>'Eva Green',     'mid'=>78,'assign'=>17,'attend'=>15,'total'=>null],
];
@endphp

<div style="display:grid;grid-template-columns:280px 1fr;gap:16px;">

    {{-- Filter --}}
    <div class="card" style="padding:20px;display:flex;flex-direction:column;gap:14px;align-self:start;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🔍 Select Class</div>
        <div><label class="form-label">Subject</label>
            <select class="form-select">
                <option>Data Structures (CS201)</option>
                <option>Database Systems (CS301)</option>
                <option>Software Engineering (CS302)</option>
                <option>Algorithms (CS401)</option>
            </select>
        </div>
        <div><label class="form-label">Exam Type</label>
            <select class="form-select"><option>Mid-Term</option><option>Final</option><option>Quiz</option><option>Assignment</option></select>
        </div>
        <div><label class="form-label">Section</label>
            <select class="form-select"><option>Section A</option><option>Section B</option><option>Section C</option></select>
        </div>
        <button class="btn btn-primary" style="width:100%;">Load Students</button>
    </div>

    {{-- Mark Table --}}
    <div class="card" style="overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📝 Data Structures — Mid-Term · Section A</div>
            <div style="font-size:12px;color:#64748b;">Full Mark: 100 &nbsp;|&nbsp; Pass: 40</div>
        </div>
        <table>
            <thead><tr><th>Student ID</th><th>Name</th><th>Mid-Term <span style="font-weight:400;font-size:11px;">/80</span></th><th>Assignment <span style="font-weight:400;font-size:11px;">/20</span></th><th>Attendance <span style="font-weight:400;font-size:11px;">/15</span></th><th>Total</th></tr></thead>
            <tbody>
            @foreach($students as $s)
            @php $total = $s['mid'] + $s['assign'] + $s['attend']; $grade = $total>=90?'A+':($total>=80?'A':($total>=70?'B+':($total>=60?'B':($total>=50?'C':'F')))); $gc = $total>=60?'#10b981':'#ef4444'; @endphp
            <tr>
                <td style="font-weight:700;color:#6366f1;">{{ $s['id'] }}</td>
                <td style="font-weight:600;">{{ $s['name'] }}</td>
                <td><input type="number" value="{{ $s['mid'] }}" min="0" max="80" style="width:70px;padding:5px 8px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;text-align:center;"></td>
                <td><input type="number" value="{{ $s['assign'] }}" min="0" max="20" style="width:70px;padding:5px 8px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;text-align:center;"></td>
                <td><input type="number" value="{{ $s['attend'] }}" min="0" max="15" style="width:70px;padding:5px 8px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;text-align:center;"></td>
                <td>
                    <span style="font-size:14px;font-weight:800;color:{{ $gc }};">{{ $total }}</span>
                    <span style="margin-left:6px;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $total>=60?'#d1fae5':'#fee2e2' }};color:{{ $gc }};">{{ $grade }}</span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn btn-secondary">Save Draft</button>
            <button class="btn btn-primary">✅ Submit Marks</button>
        </div>
    </div>

</div>
@endsection
