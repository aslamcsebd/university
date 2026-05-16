@extends('layouts.academic')
@section('title', 'Class Schedules')
@section('heading', 'Class Schedules')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ Export</a>
@endsection

@section('content')
@php
$days  = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
$times = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];

$dayColors = [
    'Monday'   =>'#6366f1','Tuesday' =>'#0ea5e9',
    'Wednesday'=>'#10b981','Thursday'=>'#f59e0b','Friday'=>'#8b5cf6',
];

$schedule = [
    'Monday'    => [
        ['start'=>'09:00','end'=>'11:00','subject'=>'Data Structures',     'code'=>'CS201',  'room'=>'Lab 1',      'staff'=>'Dr. Mitchell',  'color'=>'#6366f1','bg'=>'#eef2ff','type'=>'Lab'],
        ['start'=>'14:00','end'=>'16:00','subject'=>'Software Engineering','code'=>'CS302',  'room'=>'Hall A',     'staff'=>'Mr. Hargreaves','color'=>'#8b5cf6','bg'=>'#f5f3ff','type'=>'Lecture'],
    ],
    'Tuesday'   => [
        ['start'=>'10:00','end'=>'12:00','subject'=>'Calculus II',         'code'=>'MATH202','room'=>'Hall B',     'staff'=>'Prof. Okafor',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','type'=>'Lecture'],
        ['start'=>'15:00','end'=>'17:00','subject'=>'Database Systems',    'code'=>'CS301',  'room'=>'Lab 2',      'staff'=>'Dr. Yusuf',     'color'=>'#f59e0b','bg'=>'#fef3c7','type'=>'Lab'],
    ],
    'Wednesday' => [
        ['start'=>'09:00','end'=>'10:00','subject'=>'Data Structures',     'code'=>'CS201',  'room'=>'Hall A',     'staff'=>'Dr. Mitchell',  'color'=>'#6366f1','bg'=>'#eef2ff','type'=>'Lecture'],
        ['start'=>'14:00','end'=>'16:00','subject'=>'Physics Lab',         'code'=>'PHY101', 'room'=>'Physics Lab','staff'=>'Dr. Nair',      'color'=>'#10b981','bg'=>'#d1fae5','type'=>'Practical'],
    ],
    'Thursday'  => [
        ['start'=>'11:00','end'=>'13:00','subject'=>'Database Systems',    'code'=>'CS301',  'room'=>'Hall B',     'staff'=>'Dr. Yusuf',     'color'=>'#f59e0b','bg'=>'#fef3c7','type'=>'Lecture'],
        ['start'=>'14:00','end'=>'15:00','subject'=>'Calculus II',         'code'=>'MATH202','room'=>'Seminar 1',  'staff'=>'Prof. Okafor',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','type'=>'Tutorial'],
    ],
    'Friday'    => [
        ['start'=>'09:00','end'=>'11:00','subject'=>'Software Engineering','code'=>'CS302',  'room'=>'Lab 1',      'staff'=>'Mr. Hargreaves','color'=>'#8b5cf6','bg'=>'#f5f3ff','type'=>'Lab'],
        ['start'=>'13:00','end'=>'14:00','subject'=>'Physics Lab',         'code'=>'PHY101', 'room'=>'Hall A',     'staff'=>'Dr. Nair',      'color'=>'#10b981','bg'=>'#d1fae5','type'=>'Lecture'],
    ],
];

$typeColors = [
    'Lecture'   => ['bg'=>'#dbeafe','color'=>'#1e40af'],
    'Lab'       => ['bg'=>'#d1fae5','color'=>'#065f46'],
    'Practical' => ['bg'=>'#fce7f3','color'=>'#9d174d'],
    'Tutorial'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
];

$today        = 'Monday';
$totalClasses = array_sum(array_map('count', $schedule));
$nDays        = count($days);
$nTimes       = count($times);
$rowH         = 58;
$headerH      = 50;
$timeW        = 58;
$totalH       = $headerH + $nTimes * $rowH;
// column width as percentage of the area after the time column
// We'll use CSS calc so it fills 100% width automatically
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Classes/Week','value'=>$totalClasses,'sub'=>'across 5 days', 'icon'=>'📆','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Subjects',          'value'=>5,            'sub'=>'this semester', 'icon'=>'📖','grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)','sh'=>'rgba(14,165,233,.25)'],
        ['label'=>'Lab Sessions',      'value'=>4,            'sub'=>'per week',      'icon'=>'🔬','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Teaching Hours',    'value'=>'18h',        'sub'=>'per week',      'icon'=>'⏱️','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ② Weekly Timetable --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📅 Weekly Timetable</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @foreach($typeColors as $type => $tc)
            <span style="font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $type }}</span>
            @endforeach
        </div>
    </div>

    {{-- Grid wrapper: uses CSS custom properties so columns fill 100% --}}
    <div style="padding:16px 20px 20px;">
        <div id="tt-grid" style="position:relative;height:{{ $totalH }}px;width:100%;">

            {{-- Day headers --}}
            @foreach($days as $di => $day)
            @php $isToday = ($day === $today); $dc = $dayColors[$day]; @endphp
            <div style="position:absolute;
                        top:0;
                        left:calc({{ $timeW }}px + {{ $di }} * (100% - {{ $timeW }}px) / {{ $nDays }});
                        width:calc((100% - {{ $timeW }}px) / {{ $nDays }});
                        height:{{ $headerH }}px;
                        display:flex;align-items:center;justify-content:center;padding:0 4px;">
                <div style="width:100%;text-align:center;padding:7px 4px;border-radius:9px;font-size:12px;font-weight:800;
                    background:{{ $isToday ? $dc : '#f8fafc' }};
                    color:{{ $isToday ? '#fff' : '#64748b' }};
                    border:1.5px solid {{ $isToday ? $dc : '#e2e8f0' }};">
                    {{ $day }}
                    @if($isToday)<div style="font-size:9px;font-weight:500;opacity:.8;margin-top:1px;">Today</div>@endif
                </div>
            </div>
            @endforeach

            {{-- Time labels + horizontal dashed lines --}}
            @foreach($times as $ti => $time)
            @php $y = $headerH + $ti * $rowH; @endphp
            <div style="position:absolute;top:{{ $y }}px;left:0;width:{{ $timeW }}px;height:{{ $rowH }}px;
                        display:flex;align-items:flex-start;justify-content:flex-end;padding:7px 8px 0 0;">
                <span style="font-size:10px;font-weight:700;color:#94a3b8;">{{ $time }}</span>
            </div>
            <div style="position:absolute;top:{{ $y }}px;left:{{ $timeW }}px;right:0;height:0;
                        border-top:1px dashed #e2e8f0;"></div>
            @endforeach

            {{-- Bottom border --}}
            <div style="position:absolute;bottom:0;left:{{ $timeW }}px;right:0;height:1px;background:#e2e8f0;"></div>

            {{-- Vertical separators per day --}}
            @foreach($days as $di => $day)
            <div style="position:absolute;
                        top:{{ $headerH }}px;
                        left:calc({{ $timeW }}px + {{ $di }} * (100% - {{ $timeW }}px) / {{ $nDays }});
                        width:0;height:{{ $nTimes * $rowH }}px;
                        border-left:1px dashed #e2e8f0;"></div>
            @endforeach
            {{-- Right border --}}
            <div style="position:absolute;top:{{ $headerH }}px;right:0;width:0;height:{{ $nTimes * $rowH }}px;border-left:1px solid #e2e8f0;"></div>

            {{-- Dot pattern for empty cells --}}
            @foreach($days as $di => $day)
            @foreach($times as $ti => $time)
            @php
                $occupied = false;
                foreach(($schedule[$day] ?? []) as $s) {
                    $si = array_search($s['start'], $times);
                    $ei = array_search($s['end'],   $times);
                    if ($ti >= $si && $ti < $ei) { $occupied = true; break; }
                }
            @endphp
            @if(!$occupied)
            <div style="position:absolute;
                        top:{{ $headerH + $ti * $rowH + 3 }}px;
                        left:calc({{ $timeW }}px + {{ $di }} * (100% - {{ $timeW }}px) / {{ $nDays }} + 4px);
                        width:calc((100% - {{ $timeW }}px) / {{ $nDays }} - 8px);
                        height:{{ $rowH - 6 }}px;
                        background-image:radial-gradient(circle, #cbd5e1 1px, transparent 1px);
                        background-size:10px 10px;
                        border-radius:6px;opacity:.4;"></div>
            @endif
            @endforeach
            @endforeach

            {{-- Class slot cards --}}
            @foreach($schedule as $day => $slots)
            @php $di = array_search($day, $days); @endphp
            @foreach($slots as $s)
            @php
                $si    = array_search($s['start'], $times);
                $ei    = array_search($s['end'],   $times);
                $span  = $ei - $si;
                $cardT = $headerH + $si * $rowH + 4;
                $cardH = $span * $rowH - 8;
                $tc    = $typeColors[$s['type']];
            @endphp
            <div style="position:absolute;
                        top:{{ $cardT }}px;
                        left:calc({{ $timeW }}px + {{ $di }} * (100% - {{ $timeW }}px) / {{ $nDays }} + 5px);
                        width:calc((100% - {{ $timeW }}px) / {{ $nDays }} - 10px);
                        height:{{ $cardH }}px;
                        background:{{ $s['bg'] }};
                        border:1.5px solid {{ $s['color'] }}33;
                        border-left:4px solid {{ $s['color'] }};
                        border-radius:9px;padding:8px 9px;
                        box-sizing:border-box;
                        display:flex;flex-direction:column;justify-content:space-between;
                        overflow:hidden;
                        box-shadow:0 2px 8px {{ $s['color'] }}22;">
                <div>
                    <div style="font-size:10px;font-weight:800;color:{{ $s['color'] }};letter-spacing:.04em;">{{ $s['code'] }}</div>
                    <div style="font-size:11px;font-weight:700;color:#1e293b;margin-top:2px;line-height:1.3;">{{ $s['subject'] }}</div>
                </div>
                <div>
                    <div style="font-size:10px;color:#64748b;">{{ $s['staff'] }}</div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:3px;">
                        <span style="font-size:9px;color:#94a3b8;">📍 {{ $s['room'] }}</span>
                        <span style="font-size:9px;font-weight:700;padding:1px 5px;border-radius:9999px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $s['type'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach

        </div>
    </div>
</div>

{{-- ③ List View + Subject Summary --}}
<div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;">

    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 All Classes — List View</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Day</th><th>Time</th><th>Subject</th><th>Code</th><th>Staff</th><th>Room</th><th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedule as $day => $slots)
                    @foreach($slots as $i => $s)
                    @php $tc = $typeColors[$s['type']]; @endphp
                    <tr>
                        @if($i === 0)
                        <td rowspan="{{ count($slots) }}" style="font-size:12px;font-weight:700;color:#1e1b4b;vertical-align:top;padding-top:14px;white-space:nowrap;">
                            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:{{ $dayColors[$day] }};margin-right:6px;"></span>{{ $day }}
                        </td>
                        @endif
                        <td style="white-space:nowrap;font-size:12px;color:#475569;">{{ $s['start'] }} – {{ $s['end'] }}</td>
                        <td style="font-size:12px;font-weight:600;color:#1e293b;">{{ $s['subject'] }}</td>
                        <td><span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $s['bg'] }};color:{{ $s['color'] }};">{{ $s['code'] }}</span></td>
                        <td style="font-size:12px;color:#64748b;">{{ $s['staff'] }}</td>
                        <td style="font-size:12px;color:#64748b;">{{ $s['room'] }}</td>
                        <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $s['type'] }}</span></td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📖 Subject Summary</div>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach([
                ['name'=>'Data Structures',     'code'=>'CS201',  'sessions'=>3,'hours'=>4,'color'=>'#6366f1','bg'=>'#eef2ff','staff'=>'Dr. Mitchell'],
                ['name'=>'Calculus II',          'code'=>'MATH202','sessions'=>2,'hours'=>3,'color'=>'#0ea5e9','bg'=>'#e0f2fe','staff'=>'Prof. Okafor'],
                ['name'=>'Physics Lab',          'code'=>'PHY101', 'sessions'=>2,'hours'=>3,'color'=>'#10b981','bg'=>'#d1fae5','staff'=>'Dr. Nair'],
                ['name'=>'Database Systems',     'code'=>'CS301',  'sessions'=>2,'hours'=>3,'color'=>'#f59e0b','bg'=>'#fef3c7','staff'=>'Dr. Yusuf'],
                ['name'=>'Software Engineering', 'code'=>'CS302',  'sessions'=>2,'hours'=>3,'color'=>'#8b5cf6','bg'=>'#f5f3ff','staff'=>'Mr. Hargreaves'],
            ] as $sm)
            <div style="display:flex;align-items:center;gap:12px;padding:11px 13px;background:#f8fafc;border-radius:10px;">
                <div style="width:38px;height:38px;border-radius:9px;background:{{ $sm['bg'] }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{ $sm['color'] }};flex-shrink:0;">{{ substr($sm['code'],0,2) }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:12px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sm['name'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $sm['staff'] }}</div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <div style="font-size:13px;font-weight:800;color:{{ $sm['color'] }};">{{ $sm['hours'] }}h</div>
                    <div style="font-size:9px;color:#94a3b8;">{{ $sm['sessions'] }} sessions</div>
                </div>
            </div>
            @endforeach
            <div style="margin-top:4px;padding:12px 14px;background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:10px;display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:12px;font-weight:700;color:#e0e7ff;">Total per week</span>
                <div style="text-align:right;">
                    <div style="font-size:16px;font-weight:800;color:#fff;">18h</div>
                    <div style="font-size:10px;color:#a5b4fc;">11 sessions</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
