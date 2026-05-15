@extends('layouts.academic')
@section('title', 'Academic Rooms')
@section('heading', 'Academic Rooms')

@section('header-actions')
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ New Room</button>
@endsection

@section('content')
@php
$rooms = [
    ['id'=>1,'name'=>'Lecture Hall A','label'=>'Block A / Ground Floor','capacity'=>120,'org'=>'Faculty of Engineering','status'=>'Available'],
    ['id'=>2,'name'=>'Lecture Hall B','label'=>'Block A / Level 1','capacity'=>80,'org'=>'Faculty of Engineering','status'=>'Available'],
    ['id'=>3,'name'=>'Computer Lab 1','label'=>'Block B / Level 2','capacity'=>40,'org'=>'Faculty of Engineering','status'=>'Available'],
    ['id'=>4,'name'=>'Computer Lab 2','label'=>'Block B / Level 2','capacity'=>40,'org'=>'Faculty of Engineering','status'=>'Maintenance'],
    ['id'=>5,'name'=>'Physics Lab','label'=>'Science Block / Level 1','capacity'=>30,'org'=>'Faculty of Science','status'=>'Available'],
    ['id'=>6,'name'=>'Seminar Room 1','label'=>'Admin Block / Level 3','capacity'=>25,'org'=>'Faculty of Science','status'=>'Available'],
    ['id'=>7,'name'=>'Workshop Room','label'=>'Block C / Ground Floor','capacity'=>35,'org'=>'Faculty of Engineering','status'=>'Available'],
];
$statusColor = ['Available'=>'badge-green','Maintenance'=>'badge-yellow','Unavailable'=>'badge-red'];
@endphp

<div class="card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; gap:12px;">
        <span style="font-size:13px; color:#6b7280;">{{ count($rooms) }} rooms</span>
        <div style="display:flex; gap:10px;">
            <select class="form-select" style="width:180px;"><option>All Organisations</option><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
            <input class="form-input" style="width:200px;" placeholder="Search rooms…" type="text">
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Room Name</th>
                <th>Label / Floor</th>
                <th>Organisation</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $r)
            <tr>
                <td style="font-weight:600;">{{ $r['name'] }}</td>
                <td style="color:#6b7280; font-size:12px;">{{ $r['label'] }}</td>
                <td style="color:#6b7280;">{{ $r['org'] }}</td>
                <td>
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:13px;">
                        👥 {{ $r['capacity'] }}
                    </span>
                </td>
                <td><span class="badge {{ $statusColor[$r['status']] }}">{{ $r['status'] }}</span></td>
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
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">New Room</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Organisation</label>
                <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
            </div>
            <div>
                <label class="form-label">Room Name</label>
                <input class="form-input" placeholder="e.g. Lecture Hall A">
            </div>
            <div>
                <label class="form-label">Label / Floor</label>
                <input class="form-input" placeholder="e.g. Block A / Ground Floor">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Capacity</label>
                    <input class="form-input" type="number" placeholder="e.g. 80">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select"><option>Available</option><option>Maintenance</option><option>Unavailable</option></select>
                </div>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Create Room</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Room</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Room Name</label>
                <input class="form-input" value="Lecture Hall A">
            </div>
            <div>
                <label class="form-label">Label / Floor</label>
                <input class="form-input" value="Block A / Ground Floor">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Capacity</label>
                    <input class="form-input" type="number" value="120">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select"><option selected>Available</option><option>Maintenance</option><option>Unavailable</option></select>
                </div>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</div>
@endsection
