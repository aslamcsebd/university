@extends('layouts.academic')
@section('title', 'My Assignments')
@section('heading', 'My Assignments')
@section('header-actions')
    <button onclick="openModal('modal-add')" class="btn btn-primary">+ New Assignment</button>
@endsection
@section('content')
@php
$assignments = [
    ['title'=>'Binary Tree Implementation','subject'=>'Data Structures','code'=>'CS201','due'=>'Jul 20, 2025','submitted'=>28,'total'=>32,'status'=>'Active',  'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['title'=>'ER Diagram Design',         'subject'=>'Database Systems','code'=>'CS301','due'=>'Jul 22, 2025','submitted'=>20,'total'=>28,'status'=>'Active',  'color'=>'#10b981','bg'=>'#d1fae5'],
    ['title'=>'UML Class Diagram',         'subject'=>'Soft. Engineering','code'=>'CS302','due'=>'Jul 15, 2025','submitted'=>30,'total'=>30,'status'=>'Closed', 'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['title'=>'Sorting Algorithm Analysis','subject'=>'Algorithms',      'code'=>'CS401','due'=>'Aug 01, 2025','submitted'=>5, 'total'=>30,'status'=>'Active',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['title'=>'SQL Query Optimization',    'subject'=>'Database Systems','code'=>'CS301','due'=>'Jun 30, 2025','submitted'=>28,'total'=>28,'status'=>'Closed', 'color'=>'#10b981','bg'=>'#d1fae5'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>Title</th><th>Subject</th><th>Due Date</th><th>Submissions</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($assignments as $a)
        @php $pct = round($a['submitted']/$a['total']*100); @endphp
        <tr>
            <td style="font-weight:600;color:#1e293b;">{{ $a['title'] }}</td>
            <td>
                <span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $a['bg'] }};color:{{ $a['color'] }};">{{ $a['code'] }}</span>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{ $a['subject'] }}</div>
            </td>
            <td style="color:#64748b;font-size:12px;">{{ $a['due'] }}</td>
            <td>
                <div style="font-size:12px;font-weight:600;color:#1e293b;margin-bottom:4px;">{{ $a['submitted'] }}/{{ $a['total'] }} <span style="color:#94a3b8;font-weight:400;">({{ $pct }}%)</span></div>
                <div style="height:5px;background:#f1f5f9;border-radius:9999px;width:100px;"><div style="height:100%;width:{{ $pct }}%;background:{{ $a['color'] }};border-radius:9999px;"></div></div>
            </td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $a['status']==='Active'?'#d1fae5':'#f3f4f6' }};color:{{ $a['status']==='Active'?'#065f46':'#374151' }};">{{ $a['status'] }}</span></td>
            <td><div style="display:flex;gap:6px;"><a href="#" class="btn btn-secondary btn-sm">View</a><a href="#" class="btn btn-primary btn-sm">Edit</a></div></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div id="modal-add" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">+ New Assignment</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div><label class="form-label">Title</label><input class="form-input" placeholder="Assignment title"></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div><label class="form-label">Subject</label>
                    <select class="form-select"><option>Data Structures (CS201)</option><option>Database Systems (CS301)</option><option>Software Engineering (CS302)</option><option>Algorithms (CS401)</option></select>
                </div>
                <div><label class="form-label">Due Date</label><input type="date" class="form-input"></div>
            </div>
            <div><label class="form-label">Description</label><textarea class="form-input" rows="3" placeholder="Assignment details..."></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">Create Assignment</button>
            </div>
        </div>
    </div>
</div>
@endsection
