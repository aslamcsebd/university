@extends('layouts.academic')
@section('title', 'Class Schedules')
@section('heading', 'Class Schedules')

@section('content')
@php
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
$slots = ['08:00-09:00','09:00-10:00','10:00-11:00','11:00-12:00','12:00-13:00','14:00-15:00','15:00-16:00'];
$schedule = [
    'Monday'    => ['09:00-10:00'=>['CS201','Data Structures','Dr. Mitchell','Room 101','#6366f1'],'14:00-15:00'=>['CS301','Database Systems','Dr. Yusuf','Room 102','#f59e0b']],
    'Tuesday'   => ['10:00-11:00'=>['MATH202','Calculus II','Prof. Okafor','Hall B','#0ea5e9'],'15:00-16:00'=>['CS302','Software Eng','Mr. Hargreaves','Room 103','#8b5cf6']],
    'Wednesday' => ['09:00-10:00'=>['PHY101','Physics Lab','Dr. Nair','Lab 1','#10b981'],'11:00-12:00'=>['CS201','Data Structures','Dr. Mitchell','Room 101','#6366f1']],
    'Thursday'  => ['10:00-11:00'=>['CS302','Software Eng','Mr. Hargreaves','Room 103','#8b5cf6'],'14:00-15:00'=>['MATH202','Calculus II','Prof. Okafor','Hall B','#0ea5e9']],
    'Friday'    => ['09:00-10:00'=>['CS301','Database Systems','Dr. Yusuf','Room 102','#f59e0b']],
];
@endphp
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;align-items:center;">
        <select class="form-select" style="width:180px;"><option>B.Sc CS — Sem 3</option></select>
        <select class="form-select" style="width:160px;"><option>Section A</option></select>
    </div>
    <div style="overflow-x:auto;padding:16px;">
        <table style="border-collapse:separate;border-spacing:4px;min-width:700px;">
            <thead>
                <tr>
                    <th style="background:#f8fafc;color:#64748b;font-size:11px;padding:8px 12px;border-radius:6px;border:none;width:100px;">Time</th>
                    @foreach($days as $d)
                    <th style="background:#1e1b4b;color:#e0e7ff;font-size:12px;padding:8px 12px;border-radius:6px;border:none;">{{$d}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($slots as $slot)
            <tr>
                <td style="font-size:11px;font-weight:600;color:#64748b;padding:6px 10px;background:#f8fafc;border-radius:6px;text-align:center;border:none;">{{$slot}}</td>
                @foreach($days as $d)
                <td style="padding:3px;border:none;">
                    @if(isset($schedule[$d][$slot]))
                    @php $cls=$schedule[$d][$slot]; @endphp
                    <div style="background:{{$cls[4]}}18;border-left:3px solid {{$cls[4]}};border-radius:6px;padding:8px 10px;min-height:56px;">
                        <div style="font-size:11px;font-weight:700;color:{{$cls[4]}};">{{$cls[0]}}</div>
                        <div style="font-size:11px;font-weight:600;color:#1e293b;margin-top:1px;">{{$cls[1]}}</div>
                        <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{$cls[2]}} · {{$cls[3]}}</div>
                    </div>
                    @else
                    <div style="min-height:56px;background:#f8fafc;border-radius:6px;border:1px dashed #e2e8f0;"></div>
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
