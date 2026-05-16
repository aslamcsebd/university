@extends('layouts.academic')
@section('title', 'Notices')
@section('heading', 'Notices')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
@endsection

@section('content')
@php
$notices = [
    ['id'=>'NOT-001','title'=>'Mid-Term Exam Schedule Released',       'category'=>'Exam',     'date'=>'Jul 10, 2025','priority'=>'High',  'read'=>false,'body'=>'The mid-term examination schedule for Semester 1, 2025 has been released. Please check your exam dates, times, and room assignments on the Exam Schedules page. All students must carry their student ID cards during exams.','color'=>'#ef4444','bg'=>'#fee2e2'],
    ['id'=>'NOT-002','title'=>'Library Book Return Deadline',           'category'=>'Library',  'date'=>'Jul 12, 2025','priority'=>'High',  'read'=>false,'body'=>'All borrowed books must be returned to the library by July 20, 2025. Failure to return books on time will result in a fine of $5 per day per book. Please check your currently borrowed books on the Library page.','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'NOT-003','title'=>'Semester Fee Payment Reminder',          'category'=>'Finance',  'date'=>'Jul 08, 2025','priority'=>'High',  'read'=>true, 'body'=>'This is a reminder that semester fees are due by July 31, 2025. Students with outstanding balances are requested to clear their dues at the earliest to avoid late payment penalties. Visit the Fees Reports page for details.','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'NOT-004','title'=>'Campus Sports Day Registration Open',    'category'=>'Event',    'date'=>'Jul 07, 2025','priority'=>'Normal','read'=>true, 'body'=>'Registration for the Annual Campus Sports Day is now open. Students can register for athletics, cricket, football, and badminton. Registration closes on July 25, 2025. Contact the sports department for more information.','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'NOT-005','title'=>'New Lab Equipment Available',            'category'=>'Academic', 'date'=>'Jul 05, 2025','priority'=>'Normal','read'=>true, 'body'=>'The Physics and Computer Science labs have been equipped with new hardware and software tools. Students are encouraged to make use of the updated facilities during lab sessions. Lab timings remain unchanged.','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'NOT-006','title'=>'Holiday Notice — Independence Day',      'category'=>'Holiday',  'date'=>'Jul 03, 2025','priority'=>'Normal','read'=>true, 'body'=>'The university will remain closed on August 14, 2025 in observance of Independence Day. All classes, lab sessions, and administrative offices will be closed. Regular schedule resumes on August 15, 2025.','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'NOT-007','title'=>'Guest Lecture: AI in Healthcare',        'category'=>'Event',    'date'=>'Jul 01, 2025','priority'=>'Normal','read'=>true, 'body'=>'A guest lecture on "Artificial Intelligence in Healthcare" will be held on July 18, 2025 at 2:00 PM in Lecture Hall A. The speaker is Dr. Aisha Rahman from the National Institute of Technology. Attendance is open to all students.','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'NOT-008','title'=>'Timetable Change — Thursday Classes',   'category'=>'Academic', 'date'=>'Jun 28, 2025','priority'=>'Normal','read'=>true, 'body'=>'Due to a scheduling conflict, Thursday classes for CS301 (Database Systems) have been moved from 11:00 AM to 2:00 PM effective from July 10, 2025. Please update your schedules accordingly.','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];

$categoryColors = [
    'Exam'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'Library'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'Finance'  => ['bg'=>'#eef2ff','color'=>'#3730a3'],
    'Event'    => ['bg'=>'#d1fae5','color'=>'#065f46'],
    'Academic' => ['bg'=>'#e0f2fe','color'=>'#0369a1'],
    'Holiday'  => ['bg'=>'#f5f3ff','color'=>'#5b21b6'],
];

$priorityColors = [
    'High'   => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'Normal' => ['bg'=>'#f1f5f9','color'=>'#475569'],
];

$unread   = count(array_filter($notices, fn($n) => !$n['read']));
$high     = count(array_filter($notices, fn($n) => $n['priority'] === 'High'));
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Notices', 'value'=>count($notices),'sub'=>'this semester',  'icon'=>'📢','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Unread',        'value'=>$unread,        'sub'=>'need attention', 'icon'=>'🔴','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'High Priority', 'value'=>$high,          'sub'=>'urgent notices', 'icon'=>'⚠️','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Categories',    'value'=>count($categoryColors),'sub'=>'notice types','icon'=>'🗂️','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
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

{{-- ② Unread Highlight --}}
@if($unread > 0)
<div style="background:linear-gradient(135deg,#fef2f2,#fee2e2);border-radius:12px;padding:14px 20px;margin-bottom:16px;display:flex;align-items:center;gap:12px;border:1px solid #fca5a5;">
    <div style="font-size:22px;">🔔</div>
    <div>
        <div style="font-size:13px;font-weight:700;color:#991b1b;">You have {{ $unread }} unread notice{{ $unread>1?'s':'' }}</div>
        <div style="font-size:11px;color:#b91c1c;margin-top:2px;">Please review the highlighted notices below.</div>
    </div>
</div>
@endif

{{-- ③ Notice List --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 All Notices</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @foreach($categoryColors as $cat => $cc)
            <span style="font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;background:{{ $cc['bg'] }};color:{{ $cc['color'] }};">{{ $cat }}</span>
            @endforeach
        </div>
    </div>
    <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
        @foreach($notices as $notice)
        @php $cc = $categoryColors[$notice['category']]; $pc = $priorityColors[$notice['priority']]; @endphp
        <div style="border-radius:12px;border:1.5px solid {{ $notice['read'] ? '#e2e8f0' : $notice['color'].'55' }};
                    background:{{ $notice['read'] ? '#fff' : $notice['bg'] }};
                    overflow:hidden;transition:box-shadow .2s;"
             onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'"
             onmouseout="this.style.boxShadow=''">
            {{-- Header --}}
            <div style="padding:12px 16px;display:flex;align-items:center;gap:12px;cursor:pointer;"
                 onclick="toggleNotice('nb-{{ $loop->index }}','ni-{{ $loop->index }}')">
                {{-- unread dot --}}
                <div style="width:8px;height:8px;border-radius:50%;background:{{ $notice['read'] ? '#e2e8f0' : $notice['color'] }};flex-shrink:0;"></div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span style="font-size:13px;font-weight:{{ $notice['read'] ? '600' : '800' }};color:#1e293b;">{{ $notice['title'] }}</span>
                        @if(!$notice['read'])
                        <span style="font-size:9px;font-weight:700;padding:1px 7px;border-radius:20px;background:{{ $notice['color'] }};color:#fff;">NEW</span>
                        @endif
                    </div>
                    <div style="display:flex;gap:10px;margin-top:4px;flex-wrap:wrap;">
                        <span style="font-size:10px;color:#94a3b8;">📅 {{ $notice['date'] }}</span>
                        <span style="font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;background:{{ $cc['bg'] }};color:{{ $cc['color'] }};">{{ $notice['category'] }}</span>
                        <span style="font-size:10px;font-weight:600;padding:1px 7px;border-radius:20px;background:{{ $pc['bg'] }};color:{{ $pc['color'] }};">{{ $notice['priority'] }}</span>
                    </div>
                </div>
                <span id="ni-{{ $loop->index }}" style="font-size:11px;color:#94a3b8;flex-shrink:0;transition:transform .2s;">▼</span>
            </div>
            {{-- Body (collapsed by default) --}}
            <div id="nb-{{ $loop->index }}" style="display:none;padding:0 16px 14px 36px;font-size:12px;color:#475569;line-height:1.7;border-top:1px solid {{ $notice['read'] ? '#f1f5f9' : $notice['color'].'22' }};">
                <div style="padding-top:12px;">{{ $notice['body'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function toggleNotice(bodyId, iconId) {
    const body = document.getElementById(bodyId);
    const icon = document.getElementById(iconId);
    const open = body.style.display === 'none';
    body.style.display = open ? 'block' : 'none';
    icon.style.transform = open ? 'rotate(180deg)' : '';
}
</script>
@endsection
