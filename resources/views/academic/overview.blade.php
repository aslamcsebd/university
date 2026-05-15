@extends('layouts.academic')
@section('title', 'Academic Overview')
@section('heading', 'Academic Overview')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ CSV</a>
    <a href="#" style="font-size:12px;color:#fff;text-decoration:none;padding:7px 14px;border-radius:7px;font-weight:600;background:linear-gradient(135deg,#6366f1,#8b5cf6);box-shadow:0 2px 8px rgba(99,102,241,.35);">⬇ PDF</a>
@endsection

@section('content')
@php
// ── Shared data ──────────────────────────────────────────────
$staffList = [
    ['name'=>'Dr. Sarah Mitchell', 'dept'=>'Computer Science',    'slots'=>12,'hours'=>24,'subjects'=>2,'status'=>'Active',  'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['name'=>'Prof. James Okafor', 'dept'=>'Mathematics',         'slots'=>8, 'hours'=>16,'subjects'=>2,'status'=>'Active',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['name'=>'Dr. Priya Nair',     'dept'=>'Physics',             'slots'=>10,'hours'=>20,'subjects'=>1,'status'=>'Active',  'color'=>'#10b981','bg'=>'#d1fae5'],
    ['name'=>'Dr. Amina Yusuf',    'dept'=>'Data Science',        'slots'=>6, 'hours'=>12,'subjects'=>1,'status'=>'Active',  'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['name'=>'Mr. Tom Hargreaves', 'dept'=>'Software Engineering','slots'=>0, 'hours'=>0, 'subjects'=>0,'status'=>'Inactive','color'=>'#94a3b8','bg'=>'#f1f5f9'],
];

$semesters = [
    ['name'=>'Sem 1 2025','course'=>'Bachelor of CS',    'dept'=>'Computer Science','subjects'=>3,'slots'=>14,'progress'=>65,'status'=>'Active'],
    ['name'=>'Sem 1 2025','course'=>'Bachelor of Maths', 'dept'=>'Mathematics',     'subjects'=>2,'slots'=>8, 'progress'=>65,'status'=>'Active'],
    ['name'=>'Sem 1 2025','course'=>'Bachelor of Physics','dept'=>'Physics',         'subjects'=>2,'slots'=>10,'progress'=>65,'status'=>'Active'],
    ['name'=>'Sem 1 2025','course'=>'Master of DS',      'dept'=>'Data Science',    'subjects'=>1,'slots'=>6, 'progress'=>65,'status'=>'Active'],
    ['name'=>'Sem 2 2025','course'=>'Bachelor of CS',    'dept'=>'Computer Science','subjects'=>1,'slots'=>0, 'progress'=>0, 'status'=>'Upcoming'],
];

$rooms = [
    ['name'=>'Lecture Hall A','building'=>'BLK-A','capacity'=>120,'used'=>2,'status'=>'Available'],
    ['name'=>'Lecture Hall B','building'=>'BLK-A','capacity'=>80, 'used'=>2,'status'=>'Available'],
    ['name'=>'Computer Lab 1','building'=>'BLK-B','capacity'=>40, 'used'=>2,'status'=>'Available'],
    ['name'=>'Computer Lab 2','building'=>'BLK-B','capacity'=>40, 'used'=>0,'status'=>'Maintenance'],
    ['name'=>'Physics Lab',   'building'=>'SCI',  'capacity'=>30, 'used'=>0,'status'=>'Available'],
    ['name'=>'Seminar Room 1','building'=>'ADM',  'capacity'=>25, 'used'=>1,'status'=>'Available'],
];

$weeklySlots = [
    'Mon' => [
        ['time'=>'09:00–11:00','subject'=>'CS101','staff'=>'Dr. Mitchell','room'=>'Hall A','color'=>'#6366f1'],
        ['time'=>'14:00–16:00','subject'=>'MATH201','staff'=>'Prof. Okafor','room'=>'Seminar 1','color'=>'#0ea5e9'],
    ],
    'Tue' => [['time'=>'10:00–12:00','subject'=>'MATH101','staff'=>'Prof. Okafor','room'=>'Hall B','color'=>'#0ea5e9']],
    'Wed' => [['time'=>'14:00–16:00','subject'=>'PHY101','staff'=>'Dr. Nair','room'=>'Hall B','color'=>'#10b981']],
    'Thu' => [['time'=>'13:00–15:00','subject'=>'DS401','staff'=>'Dr. Yusuf','room'=>'Lab 1','color'=>'#f59e0b']],
    'Fri' => [['time'=>'09:00–11:00','subject'=>'CS301','staff'=>'Dr. Mitchell','room'=>'Lab 1','color'=>'#6366f1']],
];

$totalSlots  = array_sum(array_column($staffList,'slots'));
$totalHours  = array_sum(array_column($staffList,'hours'));
$activeStaff = count(array_filter($staffList, fn($s) => $s['status']==='Active'));
$availRooms  = count(array_filter($rooms, fn($r) => $r['status']==='Available'));
@endphp

{{-- ① Top KPI strip ──────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:24px;">
    @foreach([
        ['label'=>'Active Semesters', 'value'=>4,           'sub'=>'1 upcoming',      'icon'=>'📅','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Total Slots',      'value'=>$totalSlots, 'sub'=>'this semester',    'icon'=>'🗓️','grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)','sh'=>'rgba(14,165,233,.25)'],
        ['label'=>'Teaching Hours',   'value'=>$totalHours.'h','sub'=>'across all staff','icon'=>'⏱️','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Active Staff',     'value'=>$activeStaff,'sub'=>'1 inactive',       'icon'=>'👤','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Rooms Available',  'value'=>$availRooms, 'sub'=>'1 in maintenance', 'icon'=>'🏫','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)','sh'=>'rgba(139,92,246,.25)'],
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

{{-- ② Row 1: Weekly Timetable + Semester Progress ─────────── --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;">

    {{-- Weekly Timetable --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📆 This Week's Timetable</div>
            <a href="/academic/timetable" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:16px;display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
            @foreach($weeklySlots as $day => $slots)
            @php $dayColors=['Mon'=>'#6366f1','Tue'=>'#0ea5e9','Wed'=>'#10b981','Thu'=>'#f59e0b','Fri'=>'#ec4899']; $dc=$dayColors[$day]; @endphp
            <div>
                <div style="text-align:center;font-size:11px;font-weight:800;color:#fff;background:{{ $dc }};border-radius:7px;padding:5px 4px;margin-bottom:8px;">{{ $day }}</div>
                @foreach($slots as $sl)
                <div style="background:#f8fafc;border-left:3px solid {{ $sl['color'] }};border-radius:6px;padding:8px 9px;margin-bottom:6px;">
                    <div style="font-size:10px;font-weight:700;color:{{ $sl['color'] }};">{{ $sl['time'] }}</div>
                    <div style="font-size:12px;font-weight:700;color:#1e293b;margin-top:2px;">{{ $sl['subject'] }}</div>
                    <div style="font-size:10px;color:#64748b;margin-top:1px;">{{ $sl['staff'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;">📍 {{ $sl['room'] }}</div>
                </div>
                @endforeach
                @if(empty($slots))
                <div style="background:#f8fafc;border:1.5px dashed #e2e8f0;border-radius:6px;padding:16px 8px;text-align:center;color:#cbd5e1;font-size:10px;">Free</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Semester Progress --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📅 Semester Progress</div>
            <a href="/academic/semesters" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:12px;">
            @foreach($semesters as $sem)
            @php
                $sc = $sem['status']==='Active' ? '#6366f1' : '#94a3b8';
                $sb = $sem['status']==='Active' ? '#eef2ff' : '#f1f5f9';
                $st = $sem['status']==='Active' ? '#4338ca' : '#64748b';
            @endphp
            <div style="background:{{ $sb }};border-radius:10px;padding:12px 14px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $sem['course'] }}</div>
                        <div style="font-size:10px;color:#94a3b8;">{{ $sem['dept'] }} · {{ $sem['name'] }}</div>
                    </div>
                    <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:9999px;background:{{ $sem['status']==='Active'?'#d1fae5':'#dbeafe' }};color:{{ $sem['status']==='Active'?'#065f46':'#1e40af' }};">{{ $sem['status'] }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                    <div style="flex:1;height:6px;background:#e2e8f0;border-radius:9999px;overflow:hidden;">
                        <div style="height:100%;width:{{ $sem['progress'] }}%;background:{{ $sc }};border-radius:9999px;"></div>
                    </div>
                    <span style="font-size:10px;font-weight:700;color:{{ $sc }};">{{ $sem['progress'] }}%</span>
                </div>
                <div style="display:flex;gap:12px;">
                    <span style="font-size:10px;color:#64748b;">📖 {{ $sem['subjects'] }} subjects</span>
                    <span style="font-size:10px;color:#64748b;">🗓️ {{ $sem['slots'] }} slots</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ③ Row 2: Staff Workload + Room Utilisation ───────────── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

    {{-- Staff Workload --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">👤 Staff Workload</div>
            <a href="/academic/staff" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:12px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($staffList as $s)
            @php $pct = $s['hours']>0 ? min(100,round($s['hours']/30*100)) : 0; $bc=$pct>80?'#ef4444':($pct>50?'#f59e0b':$s['color']); @endphp
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:34px;height:34px;border-radius:50%;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:{{ $s['color'] }};flex-shrink:0;">{{ strtoupper(substr($s['name'],0,1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:12px;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $s['name'] }}</span>
                        <span style="font-size:11px;font-weight:700;color:{{ $bc }};flex-shrink:0;margin-left:6px;">{{ $s['hours'] }}h · {{ $pct }}%</span>
                    </div>
                    <div style="height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $bc }};border-radius:9999px;"></div>
                    </div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $s['dept'] }} · {{ $s['slots'] }} slots · {{ $s['subjects'] }} subjects</div>
                </div>
                <span style="font-size:10px;font-weight:700;padding:2px 7px;border-radius:9999px;flex-shrink:0;background:{{ $s['status']==='Active'?'#d1fae5':'#f1f5f9' }};color:{{ $s['status']==='Active'?'#065f46':'#64748b' }};">{{ $s['status'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Room Utilisation --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🏫 Room Utilisation</div>
            <a href="/academic/rooms" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:12px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($rooms as $r)
            @php
                $usePct = $r['capacity']>0 ? round($r['used']/$r['capacity']*100*10) : 0;
                $slotPct = $r['capacity']>0 ? min(100,round($r['used']/4*100)) : 0;
                $rc = $r['status']==='Maintenance' ? '#f59e0b' : ($slotPct>70?'#ef4444':'#6366f1');
                $rb = $r['status']==='Maintenance' ? '#fef9c3' : '#eef2ff';
            @endphp
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:34px;height:34px;border-radius:8px;background:{{ $rb }};display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">🏫</div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:12px;font-weight:600;color:#1e293b;">{{ $r['name'] }}</span>
                        <span style="font-size:10px;font-weight:700;padding:2px 7px;border-radius:9999px;flex-shrink:0;margin-left:6px;background:{{ $r['status']==='Available'?'#d1fae5':($r['status']==='Maintenance'?'#fef9c3':'#fee2e2') }};color:{{ $r['status']==='Available'?'#065f46':($r['status']==='Maintenance'?'#854d0e':'#991b1b') }};">{{ $r['status'] }}</span>
                    </div>
                    <div style="height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                        <div style="height:100%;width:{{ $slotPct }}%;background:{{ $rc }};border-radius:9999px;"></div>
                    </div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $r['building'] }} · Cap: {{ $r['capacity'] }} · {{ $r['used'] }} slots/week</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ④ Row 3: Department Summary + Availability Grid ─────── --}}
<div style="display:grid;grid-template-columns:1fr 2fr;gap:16px;">

    {{-- Department Summary --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🏛️ By Department</div>
            <a href="/academic/departments" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:12px 16px;display:flex;flex-direction:column;gap:8px;">
            @foreach([
                ['dept'=>'Computer Science',    'staff'=>2,'subjects'=>4,'slots'=>14,'color'=>'#6366f1','bg'=>'#eef2ff'],
                ['dept'=>'Mathematics',         'staff'=>1,'subjects'=>2,'slots'=>8, 'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
                ['dept'=>'Physics',             'staff'=>1,'subjects'=>2,'slots'=>10,'color'=>'#10b981','bg'=>'#d1fae5'],
                ['dept'=>'Data Science',        'staff'=>1,'subjects'=>1,'slots'=>6, 'color'=>'#f59e0b','bg'=>'#fef3c7'],
                ['dept'=>'Software Engineering','staff'=>1,'subjects'=>0,'slots'=>0, 'color'=>'#94a3b8','bg'=>'#f1f5f9'],
            ] as $dep)
            <div style="background:{{ $dep['bg'] }};border-radius:10px;padding:11px 14px;display:flex;align-items:center;gap:12px;">
                <div style="width:8px;height:8px;border-radius:50%;background:{{ $dep['color'] }};flex-shrink:0;"></div>
                <div style="flex:1;">
                    <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $dep['dept'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $dep['staff'] }} staff · {{ $dep['subjects'] }} subjects</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:16px;font-weight:800;color:{{ $dep['color'] }};">{{ $dep['slots'] }}</div>
                    <div style="font-size:9px;color:#94a3b8;">slots</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Staff Availability Grid --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🟢 Staff Availability This Week</div>
        </div>
        @php
        $days  = ['Mon','Tue','Wed','Thu','Fri'];
        $times = ['08','09','10','11','12','13','14','15','16','17'];
        $busy  = [
            'Mitchell' => ['Mon-09','Mon-10','Fri-09','Fri-10'],
            'Okafor'   => ['Tue-10','Tue-11','Mon-14','Mon-15'],
            'Nair'     => ['Wed-14','Wed-15'],
            'Yusuf'    => ['Thu-13','Thu-14'],
        ];
        $sColors = ['Mitchell'=>'#6366f1','Okafor'=>'#0ea5e9','Nair'=>'#10b981','Yusuf'=>'#f59e0b'];
        $dayBg   = ['Mon'=>'#eef2ff','Tue'=>'#e0f2fe','Wed'=>'#d1fae5','Thu'=>'#fef3c7','Fri'=>'#fce7f3'];
        $dayTxt  = ['Mon'=>'#4338ca','Tue'=>'#0369a1','Wed'=>'#065f46','Thu'=>'#92400e','Fri'=>'#9d174d'];
        @endphp
        <div style="overflow-x:auto;padding:14px 16px;">
            <table style="border-collapse:separate;border-spacing:3px;width:100%;">
                <thead>
                    <tr>
                        <th style="width:80px;font-size:10px;color:#94a3b8;font-weight:600;text-align:left;padding:0 6px 6px;background:transparent;border:none;"></th>
                        @foreach($days as $d)
                            @foreach($times as $t)
                            <th style="padding:2px;text-align:center;background:transparent;border:none;min-width:26px;">
                                @if($loop->first)
                                <div style="background:{{ $dayBg[$d] }};color:{{ $dayTxt[$d] }};border-radius:5px;padding:3px 2px;font-size:9px;font-weight:800;">{{ $d }}</div>
                                @endif
                                <div style="font-size:8px;color:#cbd5e1;margin-top:1px;">{{ $t }}</div>
                            </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($busy as $name => $busySlots)
                    @php $sc = $sColors[$name]; @endphp
                    <tr>
                        <td style="padding:2px 6px 2px 0;border:none;">
                            <div style="display:flex;align-items:center;gap:5px;">
                                <div style="width:20px;height:20px;border-radius:50%;background:{{ $sc }}22;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;color:{{ $sc }};">{{ strtoupper(substr($name,0,1)) }}</div>
                                <span style="font-size:10px;font-weight:600;color:#334155;">{{ $name }}</span>
                            </div>
                        </td>
                        @foreach($days as $d)
                            @foreach($times as $t)
                            @php $key=$d.'-'.$t; $isBusy=in_array($key,$busySlots); @endphp
                            <td style="padding:2px;border:none;">
                                <div style="width:22px;height:22px;border-radius:5px;margin:auto;
                                    background:{{ $isBusy ? $sc.'25' : '#f0fdf4' }};
                                    border:1.5px solid {{ $isBusy ? $sc : '#bbf7d0' }};
                                    display:flex;align-items:center;justify-content:center;"
                                    title="{{ $isBusy ? $name.' busy' : 'Free' }}">
                                    @if($isBusy)<div style="width:8px;height:8px;border-radius:50%;background:{{ $sc }};"></div>@endif
                                </div>
                            </td>
                            @endforeach
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="display:flex;gap:16px;margin-top:10px;font-size:10px;color:#64748b;align-items:center;flex-wrap:wrap;">
                <span style="font-weight:600;">Legend:</span>
                <span style="display:flex;align-items:center;gap:4px;"><div style="width:12px;height:12px;border-radius:3px;background:#f0fdf4;border:1.5px solid #bbf7d0;"></div> Free</span>
                @foreach($sColors as $n => $c)
                <span style="display:flex;align-items:center;gap:4px;"><div style="width:12px;height:12px;border-radius:3px;background:{{ $c }}25;border:1.5px solid {{ $c }};"></div> {{ $n }}</span>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
