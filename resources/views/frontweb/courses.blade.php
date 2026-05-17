@extends('layouts.academic')
@section('title', 'Courses — Web')
@section('heading', 'Courses — Web Content')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Course</a>
@endsection
@section('content')
@php
$courses = [
    ['id'=>1,'name'=>'B.Sc Computer Science','duration'=>'3 Years','seats'=>60,'fee'=>'$1,200/sem','status'=>'Active'],
    ['id'=>2,'name'=>'B.Com',               'duration'=>'3 Years','seats'=>80,'fee'=>'$900/sem',  'status'=>'Active'],
    ['id'=>3,'name'=>'MBA',                  'duration'=>'2 Years','seats'=>40,'fee'=>'$2,500/sem','status'=>'Active'],
    ['id'=>4,'name'=>'B.A English',          'duration'=>'3 Years','seats'=>50,'fee'=>'$800/sem',  'status'=>'Active'],
    ['id'=>5,'name'=>'M.Sc Computer Science','duration'=>'2 Years','seats'=>30,'fee'=>'$1,800/sem','status'=>'Active'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>#</th><th>Course Name</th><th>Duration</th><th>Seats</th><th>Fee</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($courses as $c)
        <tr>
            <td style="color:#64748b;">{{$c['id']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$c['name']}}</td>
            <td style="color:#64748b;">{{$c['duration']}}</td>
            <td style="text-align:center;font-weight:700;">{{$c['seats']}}</td>
            <td style="font-weight:700;color:#6366f1;">{{$c['fee']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d1fae5;color:#065f46;">{{$c['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
