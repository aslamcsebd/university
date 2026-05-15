@extends('layouts.academic')
@section('title', 'Academic Staff')
@section('heading', 'Academic Staff')

@section('header-actions')
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ Assign Staff</button>
@endsection

@section('content')
@php
$staff = [
    ['id'=>1,'name'=>'Dr. Sarah Mitchell','email'=>'s.mitchell@uni.edu','dept'=>'Computer Science','org'=>'Faculty of Engineering','manager'=>true,'status'=>'Active'],
    ['id'=>2,'name'=>'Prof. James Okafor','email'=>'j.okafor@uni.edu','dept'=>'Mathematics','org'=>'Faculty of Science','manager'=>false,'status'=>'Active'],
    ['id'=>3,'name'=>'Dr. Priya Nair','email'=>'p.nair@uni.edu','dept'=>'Physics','org'=>'Faculty of Science','manager'=>true,'status'=>'Active'],
    ['id'=>4,'name'=>'Mr. Tom Hargreaves','email'=>'t.hargreaves@uni.edu','dept'=>'Software Engineering','org'=>'Faculty of Engineering','manager'=>false,'status'=>'Inactive'],
    ['id'=>5,'name'=>'Dr. Amina Yusuf','email'=>'a.yusuf@uni.edu','dept'=>'Data Science','org'=>'Faculty of Engineering','manager'=>false,'status'=>'Active'],
];
@endphp

<div class="card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:13px; color:#6b7280;">{{ count($staff) }} staff assigned</span>
        <input class="form-input" style="width:220px;" placeholder="Search staff…" type="text">
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Organisation</th>
                <th>Manager</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>
                    <div style="font-weight:600; font-size:13px;">{{ $s['name'] }}</div>
                    <div style="font-size:11px; color:#9ca3af;">{{ $s['email'] }}</div>
                </td>
                <td>{{ $s['dept'] }}</td>
                <td>{{ $s['org'] }}</td>
                <td>
                    @if($s['manager'])
                        <span class="badge badge-blue">Manager</span>
                    @else
                        <span class="badge badge-gray">Staff</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $s['status']==='Active' ? 'badge-green' : 'badge-red' }}">{{ $s['status'] }}</span>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button>
                        <button class="btn btn-danger btn-sm">Remove</button>
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
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Assign Academic Staff</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Organisation</label>
                <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
            </div>
            <div>
                <label class="form-label">Employee</label>
                <select class="form-select"><option>Select employee…</option><option>Dr. Linda Chow</option><option>Mr. Kevin Patel</option></select>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="is-manager" style="width:15px;height:15px;">
                <label for="is-manager" style="font-size:13px;">Assign as Manager</label>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Assign</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Staff Assignment</h2>
        <div style="display:grid; gap:14px;">
            <div>
                <label class="form-label">Staff Member</label>
                <input class="form-input" value="Dr. Sarah Mitchell" readonly style="background:#f9fafb;">
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="edit-manager" checked style="width:15px;height:15px;">
                <label for="edit-manager" style="font-size:13px;">Manager</label>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select class="form-select"><option>Active</option><option>Inactive</option></select>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
@endsection
