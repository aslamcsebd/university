@extends('layouts.academic')
@section('title', 'Teacher Dashboard')
@section('heading', 'Teacher Dashboard')
@section('content')
@php
$teacher = ['name'=>'Dr. Sarah Mitchell','id'=>'STF-2019-0015','dept'=>'Computer Science','designation'=>'Associate Professor'];
$classes = [
    ['subject'=>'Data Structures',      'code'=>'CS201','students'=>32,'next'=>'Mon 9 AM',  'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['subject'=>'Database Systems',     'code'=>'CS301','students'=>28,'next'=>'Tue 11 AM', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['subject'=>'Software Engineering', 'code'=>'CS302','students'=>30,'next'=>'Fri 2 PM',  'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['subject'=>'Algorithms',           'code'=>'CS401','students'=>30,'next'=>'Mon 2 PM',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];
$activity = [
    ['icon'=>'📝','text'=>'Marks submitted — CS201 Mid-Term',     'time'=>'Today, 10:30 AM','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['icon'=>'✅','text'=>'Attendance marked — CS301',             'time'=>'Today, 9:00 AM', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['icon'=>'📋','text'=>'Assignment created — Binary Trees',     'time'=>'Jul 03, 2025',   'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['icon'=>'🏖️','text'=>'Leave approved — Medical (2 days)',    'time'=>'Jul 01, 2025',   'color'=>'#f59e0b','bg'=>'#fef3c7'],
];
@endphp

{{-- KPI --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;">
    @foreach([
        ['label'=>'My Classes',    'value'=>4,    'icon'=>'📖','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)'],
        ['label'=>'My Students',   'value'=>120,  'icon'=>'👨🎓','grad'=>'linear-gradient(135deg,#10b981,#34d399)'],
        ['label'=>'Pending Marks', 'value'=>2,    'icon'=>'📝','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)'],
        ['label'=>'Leave Balance', 'value'=>'8d', 'icon'=>'🏖️','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)'],
    ] as $k)
    <div style="background:{{ $k['grad'] }};border-radius:14px;padding:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:28px;font-weight:800;">{{ $k['value'] }}</div>
            <div style="font-size:12px;font-weight:600;opacity:.9;margin-top:2px;">{{ $k['label'] }}</div>
        </div>
        <div style="font-size:32px;opacity:.5;">{{ $k['icon'] }}</div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;">

    {{-- My Classes --}}
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📖 My Classes</div>
            <a href="/teacher/my-classes" style="font-size:11px;color:#6366f1;font-weight:600;text-decoration:none;">View All →</a>
        </div>
        <table>
            <thead><tr><th>Subject</th><th>Students</th><th>Next Class</th><th>Action</th></tr></thead>
            <tbody>
            @foreach($classes as $c)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:30px;height:30px;border-radius:8px;background:{{ $c['bg'] }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:{{ $c['color'] }};">{{ substr($c['code'],0,2) }}</div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $c['subject'] }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $c['code'] }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-weight:700;color:#6366f1;">{{ $c['students'] }}</td>
                <td style="font-size:12px;color:#64748b;">{{ $c['next'] }}</td>
                <td><a href="/teacher/attendance" style="font-size:11px;color:#6366f1;font-weight:600;text-decoration:none;">Mark Attendance</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Recent Activity --}}
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🕐 Recent Activity</div>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:12px;">
            @foreach($activity as $a)
            <div style="display:flex;align-items:flex-start;gap:10px;">
                <div style="width:32px;height:32px;border-radius:8px;background:{{ $a['bg'] }};display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;">{{ $a['icon'] }}</div>
                <div>
                    <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ $a['text'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $a['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
