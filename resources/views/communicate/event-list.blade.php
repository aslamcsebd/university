@extends('layouts.academic')
@section('title', 'Event List')
@section('heading', 'Event List')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Event</a>
@endsection
@section('content')
@php
$events = [
    ['id'=>'EVT-001','title'=>'Annual Sports Day',      'category'=>'Sports',   'date'=>'2024-02-10','venue'=>'Sports Ground','organizer'=>'Sports Dept','status'=>'Upcoming'],
    ['id'=>'EVT-002','title'=>'Science Exhibition',     'category'=>'Academic', 'date'=>'2024-02-15','venue'=>'Main Hall',    'organizer'=>'Science Dept','status'=>'Upcoming'],
    ['id'=>'EVT-003','title'=>'Cultural Fest',          'category'=>'Cultural', 'date'=>'2024-01-20','venue'=>'Auditorium',   'organizer'=>'Student Union','status'=>'Completed'],
    ['id'=>'EVT-004','title'=>'Alumni Meet',            'category'=>'Social',   'date'=>'2024-03-01','venue'=>'Conference Hall','organizer'=>'Admin',     'status'=>'Upcoming'],
    ['id'=>'EVT-005','title'=>'Graduation Ceremony',    'category'=>'Academic', 'date'=>'2024-03-15','venue'=>'Auditorium',   'organizer'=>'Principal',  'status'=>'Upcoming'],
];
$colors = ['Upcoming'=>['#dbeafe','#1e40af'],'Completed'=>['#d1fae5','#065f46'],'Cancelled'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Category</th><th>Date</th><th>Venue</th><th>Organizer</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($events as $e)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$e['id']}}</td>
            <td style="font-weight:600;">{{$e['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$e['category']}}</span></td>
            <td style="color:#64748b;font-size:12px;">{{$e['date']}}</td>
            <td style="color:#64748b;">{{$e['venue']}}</td>
            <td style="color:#64748b;">{{$e['organizer']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$e['status']][0]}};color:{{$colors[$e['status']][1]}};">{{$e['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
