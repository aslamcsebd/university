@extends('layouts.academic')
@section('title', 'Attendances')
@section('heading', 'Attendances')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ Export</a>
@endsection

@section('content')
@php
$subjects = [
    ['name'=>'Data Structures',     'code'=>'CS201',  'staff'=>'Dr. Mitchell',  'total'=>24,'present'=>21,'absent'=>3, 'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['name'=>'Calculus II',          'code'=>'MATH202','staff'=>'Prof. Okafor',  'total'=>20,'present'=>18,'absent'=>2, 'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['name'=>'Physics Lab',          'code'=>'PHY101', 'staff'=>'Dr. Nair',      'total'=>16,'present'=>12,'absent'=>4, 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['name'=>'Database Systems',     'code'=>'CS301',  'staff'=>'Dr. Yusuf',     'total'=>22,'present'=>21,'absent'=>1, 'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['name'=>'Software Engineering', 'code'=>'CS302',  'staff'=>'Mr. Hargreaves','total'=>18,'present'=>14,'absent'=>4, 'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];

// daily log for current month (July 2025), 1=present, 0=absent, null=no class
$log = [
    'CS201'  => [1=>1,2=>1,3=>null,4=>null,5=>null,7=>1,8=>0,9=>1,10=>1,11=>null,14=>1,15=>1,16=>1,17=>0,18=>null,21=>1,22=>1,23=>null,24=>1,25=>null],
    'MATH202'=> [1=>1,2=>null,3=>1,4=>1,5=>null,7=>0,8=>1,9=>null,10=>1,11=>1,14=>1,15=>null,16=>1,17=>1,18=>null,21=>1,22=>null,23=>1,24=>1,25=>null],
    'PHY101' => [1=>null,2=>1,3=>1,4=>null,5=>null,7=>1,8=>null,9=>0,10=>null,11=>1,14=>null,15=>0,16=>1,17=>null,18=>1,21=>null,22=>1,23=>0,24=>null,25=>1],
    'CS301'  => [1=>1,2=>1,3=>null,4=>1,5=>1,7=>null,8=>1,9=>1,10=>null,11=>1,14=>1,15=>1,16=>null,17=>1,18=>1,21=>null,22=>1,23=>1,24=>null,25=>1],
    'CS302'  => [1=>1,2=>null,3=>0,4=>1,5=>null,7=>1,8=>1,9=>null,10=>0,11=>1,14=>1,15=>null,16=>0,17=>1,18=>null,21=>1,22=>1,23=>null,24=>0,25=>1],
];

$days = range(1, 25);
$totalPresent = array_sum(array_column($subjects, 'present'));
$totalClasses = array_sum(array_column($subjects, 'total'));
$overallPct   = round($totalPresent / $totalClasses * 100);
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Overall Attendance','value'=>$overallPct.'%','sub'=>'all subjects avg',  'icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Classes Attended',  'value'=>$totalPresent, 'sub'=>'out of '.$totalClasses,'icon'=>'📖','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Total Absent',      'value'=>array_sum(array_column($subjects,'absent')),'sub'=>'this semester','icon'=>'❌','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'At Risk Subjects',  'value'=>count(array_filter($subjects,fn($s)=>round($s['present']/$s['total']*100)<75)),'sub'=>'below 75%','icon'=>'⚠️','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
    ] as $k)
    <div style="background:{{ $k['grad'] }};border-radius:14px;padding:18px 20px;color:#fff;box-shadow:0 4px 18px {{ $k['sh'] }};display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:26px;font-weight:800;line-height:1;">{{ $k['value'] }}</div>
            <div style="font-size:11px;font-weight:600;margin-top:3px;opacity:.9;">{{ $k['label'] }}</div>
            <div style="font-size:10px;opacity:.65;margin-top:2px;">{{ $k['sub'] }}</div>
        </div>
        <div style="font-size:30px;opacity:.55;">{{ $k['icon'] }}</div>
    </div>
    @endforeach
</div>

{{-- ② Subject Attendance Bars --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📊 Subject-wise Attendance</div>
    </div>
    <div style="padding:16px 20px;display:flex;flex-direction:column;gap:14px;">
        @foreach($subjects as $sub)
        @php
            $pct      = round($sub['present'] / $sub['total'] * 100);
            $barColor = $pct >= 85 ? '#10b981' : ($pct >= 75 ? '#f59e0b' : '#ef4444');
            $badge    = $pct >= 85 ? ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Good']
                      : ($pct >= 75 ? ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Average']
                      : ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'At Risk']);
        @endphp
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:40px;height:40px;border-radius:10px;background:{{ $sub['bg'] }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{ $sub['color'] }};flex-shrink:0;">{{ substr($sub['code'],0,2) }}</div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                    <div>
                        <span style="font-size:13px;font-weight:700;color:#1e293b;">{{ $sub['name'] }}</span>
                        <span style="font-size:10px;color:#94a3b8;margin-left:6px;">{{ $sub['staff'] }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                        <span style="font-size:11px;color:#64748b;">{{ $sub['present'] }}/{{ $sub['total'] }}</span>
                        <span style="font-size:12px;font-weight:800;color:{{ $barColor }};">{{ $pct }}%</span>
                        <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $badge['bg'] }};color:{{ $badge['color'] }};">{{ $badge['label'] }}</span>
                    </div>
                </div>
                <div style="height:8px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $barColor }};border-radius:9999px;transition:width .3s;"></div>
                </div>
                {{-- min 75% marker --}}
                <div style="position:relative;height:6px;">
                    <div style="position:absolute;left:75%;top:0;width:1px;height:6px;background:#94a3b8;"></div>
                    <span style="position:absolute;left:75%;top:0;font-size:8px;color:#94a3b8;transform:translateX(-50%);margin-top:1px;">75%</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ③ Monthly Log Heatmap + Summary Table --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;">

    {{-- Heatmap --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📅 July 2025 — Daily Log</div>
            <div style="display:flex;gap:10px;align-items:center;">
                <span style="display:flex;align-items:center;gap:4px;font-size:10px;color:#64748b;"><span style="width:10px;height:10px;border-radius:3px;background:#d1fae5;display:inline-block;"></span>Present</span>
                <span style="display:flex;align-items:center;gap:4px;font-size:10px;color:#64748b;"><span style="width:10px;height:10px;border-radius:3px;background:#fee2e2;display:inline-block;"></span>Absent</span>
                <span style="display:flex;align-items:center;gap:4px;font-size:10px;color:#64748b;"><span style="width:10px;height:10px;border-radius:3px;background:#f1f5f9;border:1px dashed #e2e8f0;display:inline-block;"></span>No Class</span>
            </div>
        </div>
        <div style="padding:14px 16px;overflow-x:auto;">
            <table style="border-collapse:separate;border-spacing:3px;width:100%;">
                <thead>
                    <tr>
                        <th style="font-size:10px;color:#94a3b8;font-weight:600;text-align:left;padding:4px 6px;background:transparent;border:none;white-space:nowrap;">Subject</th>
                        @foreach($days as $d)
                        <th style="font-size:9px;color:#94a3b8;font-weight:600;text-align:center;padding:2px;background:transparent;border:none;min-width:22px;">{{ $d }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $sub)
                    <tr>
                        <td style="padding:3px 6px;border:none;white-space:nowrap;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <div style="width:8px;height:8px;border-radius:50%;background:{{ $sub['color'] }};flex-shrink:0;"></div>
                                <span style="font-size:10px;font-weight:600;color:#475569;">{{ $sub['code'] }}</span>
                            </div>
                        </td>
                        @foreach($days as $d)
                        @php $val = $log[$sub['code']][$d] ?? null; @endphp
                        <td style="padding:2px;border:none;text-align:center;">
                            <div style="width:20px;height:20px;border-radius:4px;margin:auto;
                                background:{{ $val === 1 ? '#d1fae5' : ($val === 0 ? '#fee2e2' : '#f1f5f9') }};
                                border:1px solid {{ $val === 1 ? '#6ee7b7' : ($val === 0 ? '#fca5a5' : '#e2e8f0') }};
                                display:flex;align-items:center;justify-content:center;font-size:8px;"
                                title="Day {{ $d }}: {{ $val === 1 ? 'Present' : ($val === 0 ? 'Absent' : 'No Class') }}">
                                @if($val === 1)<span style="color:#065f46;">✓</span>
                                @elseif($val === 0)<span style="color:#991b1b;">✗</span>
                                @endif
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Summary Table --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 Summary</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th style="text-align:center;">Total</th>
                        <th style="text-align:center;">Present</th>
                        <th style="text-align:center;">Absent</th>
                        <th style="text-align:center;">%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $sub)
                    @php $pct = round($sub['present']/$sub['total']*100); $c = $pct>=85?'#10b981':($pct>=75?'#f59e0b':'#ef4444'); @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div style="width:8px;height:8px;border-radius:50%;background:{{ $sub['color'] }};flex-shrink:0;"></div>
                                <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $sub['code'] }}</span>
                            </div>
                        </td>
                        <td style="text-align:center;font-size:12px;color:#64748b;">{{ $sub['total'] }}</td>
                        <td style="text-align:center;font-size:12px;font-weight:600;color:#10b981;">{{ $sub['present'] }}</td>
                        <td style="text-align:center;font-size:12px;font-weight:600;color:#ef4444;">{{ $sub['absent'] }}</td>
                        <td style="text-align:center;">
                            <span style="font-size:11px;font-weight:800;color:{{ $c }};">{{ $pct }}%</span>
                        </td>
                    </tr>
                    @endforeach
                    {{-- Total row --}}
                    <tr style="background:#f8fafc;">
                        <td style="font-size:12px;font-weight:800;color:#1e1b4b;">Total</td>
                        <td style="text-align:center;font-size:12px;font-weight:800;color:#1e293b;">{{ $totalClasses }}</td>
                        <td style="text-align:center;font-size:12px;font-weight:800;color:#10b981;">{{ $totalPresent }}</td>
                        <td style="text-align:center;font-size:12px;font-weight:800;color:#ef4444;">{{ $totalClasses - $totalPresent }}</td>
                        <td style="text-align:center;"><span style="font-size:12px;font-weight:800;color:{{ $overallPct>=85?'#10b981':($overallPct>=75?'#f59e0b':'#ef4444') }};">{{ $overallPct }}%</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- Warning --}}
        @if(count(array_filter($subjects,fn($s)=>round($s['present']/$s['total']*100)<75)) > 0)
        <div style="margin:12px 16px;padding:10px 14px;background:#fef2f2;border-radius:9px;border-left:3px solid #ef4444;">
            <div style="font-size:11px;font-weight:700;color:#991b1b;">⚠ Warning</div>
            <div style="font-size:10px;color:#b91c1c;margin-top:2px;">You have subject(s) below 75% attendance. You may be barred from exams.</div>
        </div>
        @endif
    </div>

</div>
@endsection
