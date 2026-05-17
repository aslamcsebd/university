@extends('layouts.academic')
@section('title', 'Downloads')
@section('heading', 'Downloads')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Download</a>
@endsection

@section('content')
@php
$files = [
    ['id'=>'DL-001','title'=>'Academic Calendar 2025-26',    'category'=>'Academic','type'=>'PDF', 'size'=>'1.2 MB','date'=>'Jul 01, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'DL-002','title'=>'Exam Timetable Mid-Term 2025', 'category'=>'Exam',    'type'=>'PDF', 'size'=>'0.5 MB','date'=>'Jul 05, 2025','color'=>'#ef4444','bg'=>'#fee2e2'],
    ['id'=>'DL-003','title'=>'Fee Structure 2025-26',        'category'=>'Finance', 'type'=>'PDF', 'size'=>'0.8 MB','date'=>'Jun 20, 2025','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'DL-004','title'=>'Student Handbook',             'category'=>'General', 'type'=>'PDF', 'size'=>'3.4 MB','date'=>'Jun 01, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'DL-005','title'=>'Scholarship Application Form', 'category'=>'Finance', 'type'=>'DOCX','size'=>'0.3 MB','date'=>'Jul 10, 2025','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;">
    @foreach([['Total Files','5','📁','linear-gradient(135deg,#6366f1,#818cf8)'],['Academic','1','📚','linear-gradient(135deg,#10b981,#34d399)'],['Exam','1','📝','linear-gradient(135deg,#ef4444,#f87171)'],['Finance','2','💳','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:16px 18px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:22px;font-weight:800;">{{$s[1]}}</div><div style="font-size:11px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:26px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;">
@foreach($files as $f)
<div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:14px;">
    <div style="width:48px;height:48px;border-radius:12px;background:{{$f['bg']}};display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">📄</div>
    <div style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:700;color:#1e293b;">{{$f['title']}}</div>
        <div style="display:flex;gap:8px;margin-top:4px;align-items:center;">
            <span style="padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;background:{{$f['bg']}};color:{{$f['color']}};">{{$f['category']}}</span>
            <span style="font-size:11px;color:#94a3b8;">{{$f['type']}} · {{$f['size']}}</span>
        </div>
        <div style="font-size:11px;color:#94a3b8;margin-top:3px;">{{$f['date']}}</div>
    </div>
    <a href="#" style="font-size:12px;font-weight:700;color:#6366f1;text-decoration:none;white-space:nowrap;">⬇ Download</a>
</div>
@endforeach
</div>
@endsection
