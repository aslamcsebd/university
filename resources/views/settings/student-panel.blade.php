@extends('layouts.academic')
@section('title', 'Student Panel Settings')
@section('heading', 'Student Panel Settings')
@section('content')
<div class="card" style="max-width:600px;">
    <form style="display:flex;flex-direction:column;gap:16px;">
        <div style="font-weight:700;font-size:13px;color:#374151;padding-bottom:8px;border-bottom:1px solid #f1f5f9;">Visible Modules</div>
        @foreach(['Class Schedules','Exam Schedules','Attendances','Apply Leaves','Fees Reports','Library','Notices','Assignments','Downloads','Transcript','My Profile'] as $module)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f8fafc;">
            <label style="font-size:13px;font-weight:600;color:#374151;">{{$module}}</label>
            <input type="checkbox" checked style="width:16px;height:16px;">
        </div>
        @endforeach
        <button type="submit" style="padding:10px 24px;background:#4f46e5;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;align-self:flex-start;margin-top:8px;">Save Settings</button>
    </form>
</div>
@endsection
