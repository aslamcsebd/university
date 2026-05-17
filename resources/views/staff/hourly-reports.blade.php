@extends('layouts.academic')
@section('title', 'Hourly Reports')
@section('heading', 'Hourly Reports')
@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">⬇ Export</a>
@endsection
@section('content')
@php
$staff = [
    ['id'=>'STF-001','name'=>'Dr. Mitchell',  'assigned'=>16,'conducted'=>15,'missed'=>1,'pct'=>94],
    ['id'=>'STF-002','name'=>'Prof. Okafor',  'assigned'=>12,'conducted'=>12,'missed'=>0,'pct'=>100],
    ['id'=>'STF-003','name'=>'Dr. Nair',      'assigned'=>10,'conducted'=>8, 'missed'=>2,'pct'=>80],
    ['id'=>'STF-004','name'=>'Dr. Yusuf',     'assigned'=>14,'conducted'=>14,'missed'=>0,'pct'=>100],
    ['id'=>'STF-005','name'=>'Mr. Hargreaves','assigned'=>12,'conducted'=>9, 'missed'=>3,'pct'=>75],
];
@endphp
<div style="display:flex;gap:10px;margin-bottom:16px;">
    <input type="month" class="form-input" style="width:180px;" value="2025-07">
    <select class="form-select" style="width:200px;"><option>All Departments</option></select>
    <button class="btn btn-primary">Filter</button>
</div>
<div class="card" style="overflow:hidden;">
    <table>
        <thead><tr><th>ID</th><th>Staff Name</th><th>Assigned Classes</th><th>Conducted</th><th>Missed</th><th>Completion %</th></tr></thead>
        <tbody>
        @foreach($staff as $s)
        @php $c=$s['pct']>=90?'#10b981':($s['pct']>=75?'#f59e0b':'#ef4444'); @endphp
        <tr>
            <td style="font-weight:700;color:#6366f1;">{{$s['id']}}</td>
            <td style="font-weight:600;">{{$s['name']}}</td>
            <td style="text-align:center;">{{$s['assigned']}}</td>
            <td style="text-align:center;font-weight:700;color:#10b981;">{{$s['conducted']}}</td>
            <td style="text-align:center;font-weight:700;color:#ef4444;">{{$s['missed']}}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="flex:1;height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;"><div style="height:100%;width:{{$s['pct']}}%;background:{{$c}};border-radius:9999px;"></div></div>
                    <span style="font-size:12px;font-weight:700;color:{{$c}};">{{$s['pct']}}%</span>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
