@extends('layouts.academic')
@section('title', 'Meeting Schedules')
@section('heading', 'Meeting Schedules')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Schedule Meeting</a>
@endsection
@section('content')
@php
$meetings = [
    ['id'=>'MTG-001','title'=>'Faculty Review',      'type'=>'Internal','organizer'=>'Principal',  'attendees'=>12,'date'=>'2024-01-25','time'=>'10:00 AM','venue'=>'Board Room','status'=>'Scheduled'],
    ['id'=>'MTG-002','title'=>'Parent-Teacher Meet',  'type'=>'External','organizer'=>'Dean',       'attendees'=>80,'date'=>'2024-01-27','time'=>'09:00 AM','venue'=>'Auditorium','status'=>'Scheduled'],
    ['id'=>'MTG-003','title'=>'Budget Planning',      'type'=>'Internal','organizer'=>'Finance Head','attendees'=>6, 'date'=>'2024-01-23','time'=>'02:00 PM','venue'=>'Conf Room 1','status'=>'Completed'],
    ['id'=>'MTG-004','title'=>'Accreditation Review', 'type'=>'External','organizer'=>'Principal',  'attendees'=>15,'date'=>'2024-02-05','time'=>'11:00 AM','venue'=>'Board Room','status'=>'Scheduled'],
];
$colors = ['Scheduled'=>['#dbeafe','#1e40af'],'Completed'=>['#d1fae5','#065f46'],'Cancelled'=>['#fee2e2','#991b1b']];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Type</th><th>Organizer</th><th>Attendees</th><th>Date</th><th>Time</th><th>Venue</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($meetings as $m)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$m['id']}}</td>
            <td style="font-weight:600;">{{$m['title']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eef2ff;color:#6366f1;">{{$m['type']}}</span></td>
            <td style="color:#64748b;">{{$m['organizer']}}</td>
            <td style="text-align:center;font-weight:700;">{{$m['attendees']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['date']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['time']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$m['venue']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$colors[$m['status']][0]}};color:{{$colors[$m['status']][1]}};">{{$m['status']}}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
