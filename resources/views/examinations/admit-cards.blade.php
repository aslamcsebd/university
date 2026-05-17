@extends('layouts.academic')
@section('title', 'Admit Cards')
@section('heading', 'Admit Cards')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">🖨 Print Selected</a>
@endsection

@section('content')
@php
$students = [
    ['id'=>'STU-001','name'=>'Alex Johnson', 'roll'=>'CS3-001','course'=>'B.Sc CS','sem'=>'Sem 3','issued'=>true],
    ['id'=>'STU-002','name'=>'Sara Ahmed',   'roll'=>'CS3-002','course'=>'B.Sc CS','sem'=>'Sem 3','issued'=>true],
    ['id'=>'STU-003','name'=>'Ravi Kumar',   'roll'=>'CS3-003','course'=>'B.Sc CS','sem'=>'Sem 3','issued'=>false],
    ['id'=>'STU-004','name'=>'Emily Clark',  'roll'=>'CS3-004','course'=>'B.Sc CS','sem'=>'Sem 3','issued'=>true],
    ['id'=>'STU-005','name'=>'Omar Hassan',  'roll'=>'CS3-005','course'=>'B.Sc CS','sem'=>'Sem 3','issued'=>false],
];
@endphp
{{-- Sample Admit Card --}}
<div style="margin-bottom:20px;">
    <div style="font-size:13px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">Admit Card Preview</div>
    <div style="max-width:480px;border:2px solid #1e1b4b;border-radius:12px;overflow:hidden;">
        <div style="background:#1e1b4b;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;">
            <div><div style="font-size:14px;font-weight:800;color:#fff;">🎓 Academy</div><div style="font-size:10px;color:#a5b4fc;margin-top:2px;">Mid-Term Examination 2025</div></div>
            <div style="font-size:10px;color:#a5b4fc;">ADMIT CARD</div>
        </div>
        <div style="padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:12px;">
            @foreach([['Student Name','Alex Johnson'],['Roll Number','CS3-001'],['Course','B.Sc Computer Science'],['Semester','Semester 3'],['Exam Date','Jul 18 – Jul 25, 2025'],['Venue','Main Examination Hall']] as $f)
            <div><div style="color:#94a3b8;font-size:10px;">{{$f[0]}}</div><div style="font-weight:700;color:#1e293b;margin-top:2px;">{{$f[1]}}</div></div>
            @endforeach
        </div>
        <div style="padding:10px 20px;background:#f8fafc;border-top:1px dashed #e2e8f0;font-size:10px;color:#94a3b8;">This card must be presented at the examination hall. No card = No entry.</div>
    </div>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th><input type="checkbox"></th><th>ID</th><th>Name</th><th>Roll No</th><th>Course</th><th>Semester</th><th>Issued</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($students as $s)
        <tr>
            <td><input type="checkbox"></td>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="font-weight:700;color:#1e293b;">{{$s['roll']}}</td>
            <td style="color:#64748b;">{{$s['course']}}</td>
            <td style="color:#64748b;">{{$s['sem']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['issued']?'#d1fae5':'#fef3c7'}};color:{{$s['issued']?'#065f46':'#92400e'}};">{{$s['issued']?'Issued':'Pending'}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">🖨 Print</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
