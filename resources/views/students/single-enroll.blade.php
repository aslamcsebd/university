@extends('layouts.academic')
@section('title', 'Single Enroll')
@section('heading', 'Single Enroll')

@section('content')
<div style="max-width:680px;">
<div class="card" style="padding:28px;">
    <div style="font-size:15px;font-weight:700;color:#1e1b4b;margin-bottom:20px;">📋 Enroll Single Student</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div>
            <label class="form-label">Student</label>
            <select class="form-select"><option>Select Student</option><option>Alex Johnson (STU-001)</option><option>Sara Ahmed (STU-002)</option></select>
        </div>
        <div>
            <label class="form-label">Course</label>
            <select class="form-select"><option>Select Course</option><option>B.Sc Computer Science</option><option>B.A English</option></select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div>
                <label class="form-label">Semester</label>
                <select class="form-select"><option>Semester 1</option><option>Semester 2</option><option>Semester 3</option></select>
            </div>
            <div>
                <label class="form-label">Section</label>
                <select class="form-select"><option>Section A</option><option>Section B</option></select>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div><label class="form-label">Enrollment Date</label><input type="date" class="form-input" value="2025-07-15"></div>
            <div><label class="form-label">Batch</label><input class="form-input" value="2025-2028"></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:6px;">
            <button class="btn btn-primary">Enroll Student</button>
            <button class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>
</div>
@endsection
