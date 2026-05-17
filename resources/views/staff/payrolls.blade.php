@extends('layouts.academic')
@section('title', 'Payrolls')
@section('heading', 'Payrolls')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Generate Payroll</a>
@endsection
@section('content')
@php
$payrolls = [
    ['id'=>'PAY-001','name'=>'Dr. Mitchell',  'designation'=>'Professor',     'basic'=>5000,'allowance'=>800,'deduction'=>300,'net'=>5500,'month'=>'July 2025','status'=>'Paid'],
    ['id'=>'PAY-002','name'=>'Prof. Okafor',  'designation'=>'Assoc. Prof',   'basic'=>4200,'allowance'=>600,'deduction'=>250,'net'=>4550,'month'=>'July 2025','status'=>'Paid'],
    ['id'=>'PAY-003','name'=>'Dr. Nair',      'designation'=>'Lecturer',      'basic'=>3500,'allowance'=>500,'deduction'=>200,'net'=>3800,'month'=>'July 2025','status'=>'Pending'],
    ['id'=>'PAY-004','name'=>'Dr. Yusuf',     'designation'=>'Professor',     'basic'=>5000,'allowance'=>800,'deduction'=>300,'net'=>5500,'month'=>'July 2025','status'=>'Paid'],
    ['id'=>'PAY-005','name'=>'Mr. Hargreaves','designation'=>'Lecturer',      'basic'=>3500,'allowance'=>500,'deduction'=>200,'net'=>3800,'month'=>'July 2025','status'=>'Pending'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Payroll','$22,150','💰','linear-gradient(135deg,#6366f1,#818cf8)'],['Paid','3','✅','linear-gradient(135deg,#10b981,#34d399)'],['Pending','2','⏳','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Month','July 2025','📅','linear-gradient(135deg,#8b5cf6,#a78bfa)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:20px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:28px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Designation</th><th>Basic</th><th>Allowance</th><th>Deduction</th><th>Net Pay</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($payrolls as $p)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$p['id']}}</td>
            <td style="font-weight:600;">{{$p['name']}}</td>
            <td style="color:#64748b;">{{$p['designation']}}</td>
            <td style="color:#64748b;">${{number_format($p['basic'])}}</td>
            <td style="color:#10b981;font-weight:600;">+${{number_format($p['allowance'])}}</td>
            <td style="color:#ef4444;font-weight:600;">-${{number_format($p['deduction'])}}</td>
            <td style="font-weight:800;color:#1e293b;">${{number_format($p['net'])}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$p['status']==='Paid'?'#d1fae5':'#fef3c7'}};color:{{$p['status']==='Paid'?'#065f46':'#92400e'}};">{{$p['status']}}</span></td>
            <td><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">🖨 Slip</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
