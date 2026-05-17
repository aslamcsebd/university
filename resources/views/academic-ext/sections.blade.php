@extends('layouts.academic')
@section('title', 'Sections')
@section('heading', 'Sections')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Section</a>
@endsection

@section('content')
@php
$sections = [
    ['id'=>'SEC-001','name'=>'Section A','program'=>'B.Sc CS',   'semester'=>'Sem 1','capacity'=>40,'enrolled'=>38,'room'=>'Room 101'],
    ['id'=>'SEC-002','name'=>'Section B','program'=>'B.Sc CS',   'semester'=>'Sem 1','capacity'=>40,'enrolled'=>35,'room'=>'Room 102'],
    ['id'=>'SEC-003','name'=>'Section A','program'=>'B.A English','semester'=>'Sem 2','capacity'=>35,'enrolled'=>30,'room'=>'Room 201'],
    ['id'=>'SEC-004','name'=>'Section A','program'=>'B.E Civil',  'semester'=>'Sem 3','capacity'=>45,'enrolled'=>44,'room'=>'Lab 3'],
    ['id'=>'SEC-005','name'=>'Section B','program'=>'B.E Civil',  'semester'=>'Sem 3','capacity'=>45,'enrolled'=>40,'room'=>'Lab 4'],
];
@endphp
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Section</th><th>Program</th><th>Semester</th><th>Room</th><th>Capacity</th><th>Enrolled</th><th>Fill %</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($sections as $s)
        @php $pct=round($s['enrolled']/$s['capacity']*100); $c=$pct>=90?'#ef4444':($pct>=70?'#f59e0b':'#10b981'); @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:700;">{{$s['name']}}</td>
            <td style="color:#64748b;">{{$s['program']}}</td>
            <td style="color:#64748b;">{{$s['semester']}}</td>
            <td style="color:#64748b;">{{$s['room']}}</td>
            <td style="text-align:center;">{{$s['capacity']}}</td>
            <td style="text-align:center;font-weight:700;">{{$s['enrolled']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="flex:1;height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$pct}}%;background:{{$c}};border-radius:9999px;"></div></div>
                    <span style="font-size:11px;font-weight:700;color:{{$c}};">{{$pct}}%</span>
                </div>
            </td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a><a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
