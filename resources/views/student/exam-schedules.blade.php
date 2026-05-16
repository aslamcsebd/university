@extends('layouts.academic')
@section('title', 'Exam Schedules')
@section('heading', 'Exam Schedules')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ Export</a>
@endsection

@section('content')
@php
$exams = [
    ['subject'=>'Data Structures',     'code'=>'CS201',  'type'=>'Mid-Term', 'date'=>'Jul 18, 2025','day'=>'Friday',   'time'=>'09:00 AM','duration'=>'2h','room'=>'Hall A',     'seat'=>'A-14','staff'=>'Dr. Mitchell',  'color'=>'#6366f1','bg'=>'#eef2ff','status'=>'Upcoming'],
    ['subject'=>'Calculus II',          'code'=>'MATH202','type'=>'Mid-Term', 'date'=>'Jul 20, 2025','day'=>'Sunday',   'time'=>'11:00 AM','duration'=>'2h','room'=>'Hall B',     'seat'=>'B-07','staff'=>'Prof. Okafor',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','status'=>'Upcoming'],
    ['subject'=>'Physics Lab',          'code'=>'PHY101', 'type'=>'Practical','date'=>'Jul 22, 2025','day'=>'Tuesday',  'time'=>'02:00 PM','duration'=>'3h','room'=>'Physics Lab','seat'=>'P-03','staff'=>'Dr. Nair',      'color'=>'#10b981','bg'=>'#d1fae5','status'=>'Upcoming'],
    ['subject'=>'Database Systems',     'code'=>'CS301',  'type'=>'Mid-Term', 'date'=>'Jul 25, 2025','day'=>'Friday',   'time'=>'09:00 AM','duration'=>'2h','room'=>'Hall A',     'seat'=>'A-22','staff'=>'Dr. Yusuf',     'color'=>'#f59e0b','bg'=>'#fef3c7','status'=>'Upcoming'],
    ['subject'=>'Software Engineering', 'code'=>'CS302',  'type'=>'Mid-Term', 'date'=>'Jul 27, 2025','day'=>'Sunday',   'time'=>'02:00 PM','duration'=>'2h','room'=>'Hall C',     'seat'=>'C-11','staff'=>'Mr. Hargreaves','color'=>'#8b5cf6','bg'=>'#f5f3ff','status'=>'Upcoming'],
    ['subject'=>'Data Structures',     'code'=>'CS201',  'type'=>'Final',    'date'=>'Sep 10, 2025','day'=>'Wednesday','time'=>'09:00 AM','duration'=>'3h','room'=>'Hall A',     'seat'=>'A-14','staff'=>'Dr. Mitchell',  'color'=>'#6366f1','bg'=>'#eef2ff','status'=>'Scheduled'],
    ['subject'=>'Calculus II',          'code'=>'MATH202','type'=>'Final',    'date'=>'Sep 12, 2025','day'=>'Friday',   'time'=>'11:00 AM','duration'=>'3h','room'=>'Hall B',     'seat'=>'B-07','staff'=>'Prof. Okafor',  'color'=>'#0ea5e9','bg'=>'#e0f2fe','status'=>'Scheduled'],
    ['subject'=>'Database Systems',     'code'=>'CS301',  'type'=>'Final',    'date'=>'Sep 15, 2025','day'=>'Monday',   'time'=>'09:00 AM','duration'=>'3h','room'=>'Hall A',     'seat'=>'A-22','staff'=>'Dr. Yusuf',     'color'=>'#f59e0b','bg'=>'#fef3c7','status'=>'Scheduled'],
];

$typeColors = [
    'Mid-Term'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'Final'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'Practical' => ['bg'=>'#fce7f3','color'=>'#9d174d'],
];

$statusColors = [
    'Upcoming'  => ['bg'=>'#dbeafe','color'=>'#1e40af'],
    'Scheduled' => ['bg'=>'#f1f5f9','color'=>'#475569'],
    'Completed' => ['bg'=>'#d1fae5','color'=>'#065f46'],
];

$upcoming  = array_filter($exams, fn($e) => $e['status'] === 'Upcoming');
$scheduled = array_filter($exams, fn($e) => $e['status'] === 'Scheduled');
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Exams',    'value'=>count($exams),'sub'=>'this semester',  'icon'=>'📝','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Upcoming',       'value'=>count($upcoming),'sub'=>'next 2 weeks','icon'=>'⏰','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Finals',         'value'=>3,            'sub'=>'in September',   'icon'=>'🎯','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'Practicals',     'value'=>1,            'sub'=>'this month',     'icon'=>'🔬','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
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

{{-- ② Upcoming Exam Cards --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">⏰ Upcoming Exams</div>
        <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;background:#dbeafe;color:#1e40af;">{{ count($upcoming) }} exams</span>
    </div>
    <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
        @foreach($upcoming as $exam)
        @php $tc = $typeColors[$exam['type']]; @endphp
        <div style="border:1.5px solid {{ $exam['color'] }}33;border-top:4px solid {{ $exam['color'] }};border-radius:12px;padding:16px;background:#fff;box-shadow:0 2px 8px {{ $exam['color'] }}11;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:11px;font-weight:800;padding:3px 9px;border-radius:20px;background:{{ $exam['bg'] }};color:{{ $exam['color'] }};">{{ $exam['code'] }}</span>
                <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $exam['type'] }}</span>
            </div>
            <div style="font-size:14px;font-weight:800;color:#1e293b;margin-bottom:4px;">{{ $exam['subject'] }}</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:12px;">{{ $exam['staff'] }}</div>
            <div style="display:flex;flex-direction:column;gap:5px;padding:10px 12px;background:#f8fafc;border-radius:9px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">📅 Date</span>
                    <span style="font-size:11px;font-weight:700;color:#1e293b;">{{ $exam['date'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">⏰ Time</span>
                    <span style="font-size:11px;font-weight:700;color:#1e293b;">{{ $exam['time'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">📍 Room</span>
                    <span style="font-size:11px;font-weight:700;color:#1e293b;">{{ $exam['room'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">💺 Seat</span>
                    <span style="font-size:11px;font-weight:800;color:{{ $exam['color'] }};">{{ $exam['seat'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">⏱ Duration</span>
                    <span style="font-size:11px;font-weight:700;color:#1e293b;">{{ $exam['duration'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ③ Full Exam Schedule Table --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 Full Exam Schedule</div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Room</th>
                    <th>Seat No.</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $i => $exam)
                @php $tc = $typeColors[$exam['type']]; $sc = $statusColors[$exam['status']]; @endphp
                <tr>
                    <td style="font-size:12px;color:#94a3b8;font-weight:600;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:7px;background:{{ $exam['bg'] }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:{{ $exam['color'] }};flex-shrink:0;">{{ substr($exam['code'],0,2) }}</div>
                            <span style="font-size:12px;font-weight:600;color:#1e293b;">{{ $exam['subject'] }}</span>
                        </div>
                    </td>
                    <td><span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $exam['bg'] }};color:{{ $exam['color'] }};">{{ $exam['code'] }}</span></td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $exam['type'] }}</span></td>
                    <td style="font-size:12px;color:#1e293b;font-weight:600;white-space:nowrap;">{{ $exam['date'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $exam['day'] }}</td>
                    <td style="font-size:12px;color:#475569;white-space:nowrap;">{{ $exam['time'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $exam['duration'] }}</td>
                    <td style="font-size:12px;color:#64748b;">{{ $exam['room'] }}</td>
                    <td><span style="font-size:11px;font-weight:800;padding:2px 10px;border-radius:20px;background:{{ $exam['bg'] }};color:{{ $exam['color'] }};">{{ $exam['seat'] }}</span></td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $exam['status'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ④ Timeline --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🗓️ Exam Timeline</div>
    </div>
    <div style="padding:20px 24px;">
        <div style="position:relative;padding-left:28px;">
            {{-- vertical line --}}
            <div style="position:absolute;left:9px;top:6px;bottom:6px;width:2px;background:linear-gradient(180deg,#6366f1,#e2e8f0);border-radius:2px;"></div>
            @foreach($exams as $i => $exam)
            @php $tc = $typeColors[$exam['type']]; @endphp
            <div style="position:relative;margin-bottom:{{ $i < count($exams)-1 ? '16px' : '0' }};">
                {{-- dot --}}
                <div style="position:absolute;left:-24px;top:10px;width:12px;height:12px;border-radius:50%;background:{{ $exam['color'] }};border:2px solid #fff;box-shadow:0 0 0 2px {{ $exam['color'] }}44;"></div>
                <div style="display:flex;align-items:center;gap:12px;padding:11px 14px;background:#f8fafc;border-radius:10px;border-left:3px solid {{ $exam['color'] }};">
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                            <span style="font-size:12px;font-weight:700;color:#1e293b;">{{ $exam['subject'] }}</span>
                            <span style="font-size:10px;font-weight:700;padding:1px 7px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $exam['type'] }}</span>
                        </div>
                        <div style="display:flex;gap:14px;">
                            <span style="font-size:10px;color:#94a3b8;">📅 {{ $exam['date'] }} · {{ $exam['day'] }}</span>
                            <span style="font-size:10px;color:#94a3b8;">⏰ {{ $exam['time'] }}</span>
                            <span style="font-size:10px;color:#94a3b8;">📍 {{ $exam['room'] }}</span>
                        </div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div style="font-size:12px;font-weight:800;color:{{ $exam['color'] }};">{{ $exam['seat'] }}</div>
                        <div style="font-size:9px;color:#94a3b8;">Seat No.</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
