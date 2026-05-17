@extends('layouts.academic')
@section('title', 'Staff List')
@section('heading', 'Staff List')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Staff</a>
@endsection

@section('content')
@php
$staff = [
    ['id'=>'STF-001','name'=>'Dr. Mitchell',   'dept'=>'Computer Science','designation'=>'Professor',      'email'=>'mitchell@academy.edu','phone'=>'+1-555-0101','status'=>'Active','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'STF-002','name'=>'Prof. Okafor',   'dept'=>'Mathematics',     'designation'=>'Associate Prof', 'email'=>'okafor@academy.edu',  'phone'=>'+1-555-0102','status'=>'Active','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'STF-003','name'=>'Dr. Nair',       'dept'=>'Physics',         'designation'=>'Lecturer',       'email'=>'nair@academy.edu',    'phone'=>'+1-555-0103','status'=>'Active','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'STF-004','name'=>'Dr. Yusuf',      'dept'=>'Computer Science','designation'=>'Professor',      'email'=>'yusuf@academy.edu',   'phone'=>'+1-555-0104','status'=>'Active','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'STF-005','name'=>'Mr. Hargreaves', 'dept'=>'Computer Science','designation'=>'Lecturer',       'email'=>'hargreaves@academy.edu','phone'=>'+1-555-0105','status'=>'On Leave','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Staff','24','👥','linear-gradient(135deg,#6366f1,#818cf8)'],['Active','21','✅','linear-gradient(135deg,#10b981,#34d399)'],['On Leave','2','🏖️','linear-gradient(135deg,#f59e0b,#fbbf24)'],['Departments','6','🏛️','linear-gradient(135deg,#8b5cf6,#a78bfa)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div class="card" style="overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;">
        <input placeholder="Search staff..." class="form-input" style="max-width:260px;">
        <select class="form-select" style="width:200px;"><option>All Departments</option></select>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Department</th><th>Designation</th><th>Email</th><th>Phone</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($staff as $s)
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:{{$s['bg']}};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{$s['color']}};">{{substr($s['name'],0,2)}}</div>
                    <span style="font-weight:600;">{{$s['name']}}</span>
                </div>
            </td>
            <td style="color:#64748b;">{{$s['dept']}}</td>
            <td style="color:#64748b;">{{$s['designation']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['email']}}</td>
            <td style="color:#64748b;font-size:12px;">{{$s['phone']}}</td>
            <td><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{$s['status']==='Active'?'#d1fae5':'#fef3c7'}};color:{{$s['status']==='Active'?'#065f46':'#92400e'}};">{{$s['status']}}</span></td>
            <td style="display:flex;gap:8px;"><a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">View</a><a href="#" style="font-size:12px;color:#f59e0b;font-weight:600;text-decoration:none;">Edit</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
