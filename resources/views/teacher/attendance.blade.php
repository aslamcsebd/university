@extends('layouts.academic')
@section('title', 'Mark Attendance')
@section('heading', 'Mark Attendance')
@section('content')
@php
$students = [
    ['id'=>'STU-101','name'=>'Alice Johnson', 'avatar'=>'AJ','color'=>'#6366f1','bg'=>'#eef2ff','status'=>'present'],
    ['id'=>'STU-102','name'=>'Bob Smith',     'avatar'=>'BS','color'=>'#10b981','bg'=>'#d1fae5','status'=>'present'],
    ['id'=>'STU-103','name'=>'Carol White',   'avatar'=>'CW','color'=>'#8b5cf6','bg'=>'#f5f3ff','status'=>'absent'],
    ['id'=>'STU-104','name'=>'David Brown',   'avatar'=>'DB','color'=>'#f59e0b','bg'=>'#fef3c7','status'=>'present'],
    ['id'=>'STU-105','name'=>'Eva Green',     'avatar'=>'EG','color'=>'#0ea5e9','bg'=>'#e0f2fe','status'=>'late'],
    ['id'=>'STU-106','name'=>'Frank Lee',     'avatar'=>'FL','color'=>'#ef4444','bg'=>'#fee2e2','status'=>'present'],
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
        <div><label class="form-label">Section</label>
            <select class="form-select"><option>Section A</option><option>Section B</option><option>Section C</option></select>
        </div>
        <div><label class="form-label">Date</label>
            <input type="date" class="form-input" value="{{ date('Y-m-d') }}">
        </div>
        <button class="btn btn-primary" style="width:100%;">Load Students</button>
        <div style="border-top:1px solid #f1f5f9;padding-top:12px;display:flex;flex-direction:column;gap:8px;">
            <div style="font-size:12px;font-weight:700;color:#374151;">Quick Actions</div>
            <button class="btn btn-secondary btn-sm" style="width:100%;">✅ Mark All Present</button>
            <button class="btn btn-secondary btn-sm" style="width:100%;">❌ Mark All Absent</button>
        </div>
    </div>

    {{-- Attendance Grid --}}
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">✅ Data Structures — Section A · {{ date('M d, Y') }}</div>
            <div style="display:flex;gap:10px;font-size:12px;">
                <span style="color:#10b981;font-weight:700;">✅ Present: 4</span>
                <span style="color:#ef4444;font-weight:700;">❌ Absent: 1</span>
                <span style="color:#f59e0b;font-weight:700;">⏰ Late: 1</span>
            </div>
        </div>
        <div style="padding:16px;display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
            @foreach($students as $s)
            @php
                $sc = $s['status']==='present'?['#d1fae5','#065f46','✅']:($s['status']==='absent'?['#fee2e2','#991b1b','❌']:['#fef3c7','#92400e','⏰']);
            @endphp
            <div style="border:2px solid {{ $s['status']==='present'?'#10b981':($s['status']==='absent'?'#ef4444':'#f59e0b') }};border-radius:10px;padding:14px;display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:50%;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:{{ $s['color'] }};flex-shrink:0;">{{ $s['avatar'] }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $s['name'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;">{{ $s['id'] }}</div>
                </div>
                <select style="font-size:11px;padding:3px 6px;border:1px solid #d1d5db;border-radius:6px;background:#fff;">
                    <option {{ $s['status']==='present'?'selected':'' }}>present</option>
                    <option {{ $s['status']==='absent'?'selected':'' }}>absent</option>
                    <option {{ $s['status']==='late'?'selected':'' }}>late</option>
                </select>
            </div>
            @endforeach
        </div>
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;">
            <button class="btn btn-secondary">Save Draft</button>
            <button class="btn btn-primary">✅ Submit Attendance</button>
        </div>
    </div>

</div>
@endsection
