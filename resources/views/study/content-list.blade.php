@extends('layouts.academic')
@section('title', 'Content List')
@section('heading', 'Content List')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Upload Content</a>
@endsection

@section('content')
@php
$contents = [
    ['id'=>'CNT-001','title'=>'Data Structures Lecture Notes Ch.1','subject'=>'CS201','type'=>'PDF',  'size'=>'2.4 MB','uploaded'=>'Jul 10, 2025','downloads'=>124,'color'=>'#ef4444'],
    ['id'=>'CNT-002','title'=>'Calculus II Formula Sheet',          'subject'=>'MATH202','type'=>'PDF','size'=>'0.8 MB','uploaded'=>'Jul 11, 2025','downloads'=>98, 'color'=>'#ef4444'],
    ['id'=>'CNT-003','title'=>'Physics Lab Manual',                 'subject'=>'PHY101','type'=>'PDF', 'size'=>'5.1 MB','uploaded'=>'Jul 08, 2025','downloads'=>76, 'color'=>'#ef4444'],
    ['id'=>'CNT-004','title'=>'Database Design Tutorial Video',     'subject'=>'CS301', 'type'=>'Video','size'=>'145 MB','uploaded'=>'Jul 12, 2025','downloads'=>55,'color'=>'#6366f1'],
    ['id'=>'CNT-005','title'=>'Software Engineering Slides',        'subject'=>'CS302', 'type'=>'PPT', 'size'=>'8.2 MB','uploaded'=>'Jul 09, 2025','downloads'=>88, 'color'=>'#f59e0b'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <input placeholder="Search content..." class="form-input" style="max-width:260px;">
        <select class="form-select" style="width:160px;"><option>All Types</option><option>PDF</option><option>Video</option><option>PPT</option></select>
        <select class="form-select" style="width:180px;"><option>All Subjects</option></select>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Subject</th><th>Type</th><th>Size</th><th>Uploaded</th><th>Downloads</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($contents as $c)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$c['id']}}</td>
            <td style="font-weight:600;">{{$c['title']}}</td>
            <td><span style="padding:2px 8px;background:#eef2ff;color:#6366f1;border-radius:6px;font-size:11px;font-weight:700;">{{$c['subject']}}</span></td>
            <td><span style="padding:2px 8px;border-radius:6px;font-size:11px;font-weight:700;background:{{$c['color']}}22;color:{{$c['color']}};">{{$c['type']}}</span></td>
            <td style="color:#64748b;">{{$c['size']}}</td>
            <td style="color:#64748b;">{{$c['uploaded']}}</td>
            <td style="text-align:center;font-weight:700;">{{$c['downloads']}}</td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">⬇ Download</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
