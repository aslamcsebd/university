@extends('layouts.academic')
@section('title', 'Academic Courses')
@section('heading', 'Academic Courses')

@section('header-actions')
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ New Course</button>
@endsection

@section('content')
@php
$courses = [
    ['id'=>1,'code'=>'CS101','name'=>'Introduction to Programming','dept'=>'Computer Science','type'=>'Lecture','status'=>'Active'],
    ['id'=>2,'code'=>'CS201','name'=>'Data Structures & Algorithms','dept'=>'Computer Science','type'=>'Lecture','status'=>'Active'],
    ['id'=>3,'code'=>'CS301','name'=>'Database Systems','dept'=>'Computer Science','type'=>'Lab','status'=>'Active'],
    ['id'=>4,'code'=>'MATH101','name'=>'Calculus I','dept'=>'Mathematics','type'=>'Lecture','status'=>'Active'],
    ['id'=>5,'code'=>'MATH201','name'=>'Linear Algebra','dept'=>'Mathematics','type'=>'Lecture','status'=>'Inactive'],
    ['id'=>6,'code'=>'PHY101','name'=>'Physics Fundamentals','dept'=>'Physics','type'=>'Lecture','status'=>'Active'],
    ['id'=>7,'code'=>'PHY201','name'=>'Physics Lab','dept'=>'Physics','type'=>'Lab','status'=>'Active'],
    ['id'=>8,'code'=>'DS401','name'=>'Machine Learning','dept'=>'Data Science','type'=>'Workshop','status'=>'Active'],
];
$typeColor = ['Lecture'=>'badge-blue','Lab'=>'badge-yellow','Workshop'=>'badge-green','Tutorial'=>'badge-gray'];
@endphp

<div class="card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; gap:12px;">
        <span style="font-size:13px; color:#6b7280;">{{ count($courses) }} courses</span>
        <div style="display:flex; gap:10px;">
            <select class="form-select" style="width:160px;"><option>All Departments</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option></select>
            <input class="form-input" style="width:200px;" placeholder="Search courses…" type="text">
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Module Name</th>
                <th>Department</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $c)
            <tr>
                <td style="font-weight:700; font-family:monospace; color:#4f46e5;">{{ $c['code'] }}</td>
                <td>{{ $c['name'] }}</td>
                <td style="color:#6b7280;">{{ $c['dept'] }}</td>
                <td><span class="badge {{ $typeColor[$c['type']] }}">{{ $c['type'] }}</span></td>
                <td><span class="badge {{ $c['status']==='Active' ? 'badge-green' : 'badge-red' }}">{{ $c['status'] }}</span></td>
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
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">New Course / Module</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Organisation</label>
                    <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
                </div>
                <div>
                    <label class="form-label">Department</label>
                    <select class="form-select"><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 2fr; gap:12px;">
                <div>
                    <label class="form-label">Module Code</label>
                    <input class="form-input" placeholder="e.g. CS101">
                </div>
                <div>
                    <label class="form-label">Module Name</label>
                    <input class="form-input" placeholder="e.g. Introduction to Programming">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Lecture Type</label>
                    <select class="form-select"><option>Lecture</option><option>Lab</option><option>Workshop</option><option>Tutorial</option></select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select"><option>Active</option><option>Inactive</option></select>
                </div>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Create Course</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Course</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 2fr; gap:12px;">
                <div>
                    <label class="form-label">Module Code</label>
                    <input class="form-input" value="CS101">
                </div>
                <div>
                    <label class="form-label">Module Name</label>
                    <input class="form-input" value="Introduction to Programming">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Lecture Type</label>
                    <select class="form-select"><option selected>Lecture</option><option>Lab</option><option>Workshop</option></select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select"><option selected>Active</option><option>Inactive</option></select>
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
