@extends('layouts.academic')
@section('title', 'New Registration')
@section('heading', 'New Registration')

@section('content')
<div style="max-width:720px;">
<div class="card" style="padding:28px;">
    <div style="font-size:15px;font-weight:700;color:#1e1b4b;margin-bottom:20px;">📋 Student Registration Form</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        @foreach([['First Name','text'],['Last Name','text'],['Email','email'],['Phone','text'],['Date of Birth','date'],['Gender','select']] as $f)
        <div>
            <label class="form-label">{{$f[0]}}</label>
            @if($f[1]==='select')
            <select class="form-select"><option>Male</option><option>Female</option><option>Other</option></select>
            @else
            <input type="{{$f[1]}}" class="form-input" placeholder="Enter {{$f[0]}}">
            @endif
        </div>
        @endforeach
        <div>
            <label class="form-label">Course</label>
            <select class="form-select"><option>B.Sc Computer Science</option><option>B.A English</option><option>B.Com Accounting</option></select>
        </div>
        <div>
            <label class="form-label">Semester</label>
            <select class="form-select"><option>Semester 1</option><option>Semester 2</option><option>Semester 3</option></select>
        </div>
        <div style="grid-column:span 2;">
            <label class="form-label">Address</label>
            <textarea class="form-input" rows="3" placeholder="Full address"></textarea>
        </div>
    </div>
    <div style="margin-top:20px;display:flex;gap:10px;">
        <button class="btn btn-primary">Submit Registration</button>
        <button class="btn btn-secondary">Reset</button>
    </div>
</div>
</div>
@endsection
