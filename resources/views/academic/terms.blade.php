@extends('layouts.academic')
@section('title', 'Academic Terms')
@section('heading', 'Academic Terms')

@section('header-actions')
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ New Term</button>
@endsection

@section('content')
@php
$terms = [
    ['id'=>1,'year'=>2025,'name'=>'Semester 1','start'=>'2025-01-13','end'=>'2025-05-09','status'=>'Active'],
    ['id'=>2,'year'=>2025,'name'=>'Semester 2','start'=>'2025-06-02','end'=>'2025-09-26','status'=>'Upcoming'],
    ['id'=>3,'year'=>2024,'name'=>'Semester 2','start'=>'2024-06-03','end'=>'2024-09-27','status'=>'Completed'],
    ['id'=>4,'year'=>2024,'name'=>'Semester 1','start'=>'2024-01-15','end'=>'2024-05-10','status'=>'Completed'],
    ['id'=>5,'year'=>2025,'name'=>'Short Course Term','start'=>'2025-07-07','end'=>'2025-08-15','status'=>'Upcoming'],
];
$statusColor = ['Active'=>'badge-green','Upcoming'=>'badge-blue','Completed'=>'badge-gray'];
@endphp

<div class="card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:13px; color:#6b7280;">{{ count($terms) }} terms</span>
        <select class="form-select" style="width:160px;"><option>All Years</option><option>2025</option><option>2024</option></select>
    </div>
    <table>
        <thead>
            <tr>
                <th>Year</th>
                <th>Term Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($terms as $t)
            @php
                $weeks = round((strtotime($t['end']) - strtotime($t['start'])) / 604800);
            @endphp
            <tr>
                <td style="font-weight:600;">{{ $t['year'] }}</td>
                <td>{{ $t['name'] }}</td>
                <td>{{ date('d M Y', strtotime($t['start'])) }}</td>
                <td>{{ date('d M Y', strtotime($t['end'])) }}</td>
                <td style="color:#6b7280;">{{ $weeks }} weeks</td>
                <td><span class="badge {{ $statusColor[$t['status']] }}">{{ $t['status'] }}</span></td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Add Modal --}}
<div id="modal-add" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">New Academic Term</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Organisation</label>
                <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Year</label>
                    <input class="form-input" type="number" value="2025">
                </div>
                <div>
                    <label class="form-label">Term Name</label>
                    <input class="form-input" type="text" placeholder="e.g. Semester 1">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Start Date</label>
                    <input class="form-input" type="date">
                </div>
                <div>
                    <label class="form-label">End Date</label>
                    <input class="form-input" type="date">
                </div>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select class="form-select"><option>Upcoming</option><option>Active</option><option>Completed</option></select>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Create Term</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Term</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Year</label>
                    <input class="form-input" type="number" value="2025">
                </div>
                <div>
                    <label class="form-label">Term Name</label>
                    <input class="form-input" value="Semester 1">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Start Date</label>
                    <input class="form-input" type="date" value="2025-01-13">
                </div>
                <div>
                    <label class="form-label">End Date</label>
                    <input class="form-input" type="date" value="2025-05-09">
                </div>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select class="form-select"><option selected>Active</option><option>Upcoming</option><option>Completed</option></select>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</div>
@endsection
