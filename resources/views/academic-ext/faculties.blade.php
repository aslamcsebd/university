@extends('layouts.academic')
@section('title', 'Faculties')
@section('heading', 'Faculties')

@section('header-actions')
    <a href="#" style="font-size:13px;font-weight:600;padding:7px 16px;background:#4f46e5;color:#fff;border-radius:7px;text-decoration:none;">+ Add Faculty</a>
@endsection

@section('content')
@php
$faculties = [
    ['id'=>'FAC-001','name'=>'Faculty of Science',       'dean'=>'Prof. Anderson','depts'=>4,'programs'=>12,'students'=>820,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'FAC-002','name'=>'Faculty of Arts',          'dean'=>'Prof. Williams','depts'=>3,'programs'=>8, 'students'=>540,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'FAC-003','name'=>'Faculty of Engineering',   'dean'=>'Prof. Chen',    'depts'=>5,'programs'=>15,'students'=>1200,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'FAC-004','name'=>'Faculty of Commerce',      'dean'=>'Prof. Okafor',  'depts'=>3,'programs'=>9, 'students'=>680,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'FAC-005','name'=>'Faculty of Social Science','dean'=>'Prof. Nair',    'depts'=>4,'programs'=>10,'students'=>460,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @foreach([['Total Faculties','5','🏛️','linear-gradient(135deg,#6366f1,#818cf8)'],['Total Programs','54','📚','linear-gradient(135deg,#10b981,#34d399)'],['Total Students','3700','🧑🎓','linear-gradient(135deg,#f59e0b,#fbbf24)']] as $s)
    <div style="background:{{$s[3]}};border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div><div style="font-size:26px;font-weight:800;">{{$s[1]}}</div><div style="font-size:12px;opacity:.9;margin-top:2px;">{{$s[0]}}</div></div>
        <div style="font-size:30px;opacity:.5;">{{$s[2]}}</div>
    </div>
    @endforeach
</div>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
@foreach($faculties as $f)
<div class="card" style="padding:20px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:{{$f['bg']}};display:flex;align-items:center;justify-content:center;font-size:20px;">🏛️</div>
        <div>
            <div style="font-size:14px;font-weight:700;color:#1e293b;">{{$f['name']}}</div>
            <div style="font-size:11px;color:#94a3b8;">{{$f['id']}}</div>
        </div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px;">
        @foreach([['Departments',$f['depts']],['Programs',$f['programs']],['Students',$f['students']]] as $stat)
        <div style="background:#f8fafc;border-radius:8px;padding:10px;text-align:center;">
            <div style="font-size:16px;font-weight:800;color:#1e293b;">{{$stat[1]}}</div>
            <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{$stat[0]}}</div>
        </div>
        @endforeach
    </div>
    <div style="font-size:12px;color:#64748b;">Dean: <span style="font-weight:600;color:#1e293b;">{{$f['dean']}}</span></div>
    <div style="display:flex;gap:8px;margin-top:12px;">
        <a href="#" style="font-size:12px;color:#6366f1;font-weight:600;text-decoration:none;">Edit</a>
        <a href="#" style="font-size:12px;color:#ef4444;font-weight:600;text-decoration:none;">Delete</a>
    </div>
</div>
@endforeach
</div>
@endsection
