@extends('layouts.academic')
@section('title', 'Student Dashboard')
@section('heading', 'Student Dashboard')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <span style="font-size:12px;font-weight:600;padding:6px 14px;background:#d1fae5;color:#065f46;border-radius:7px;">🟢 Active</span>
@endsection

@section('content')
@php
$student = [
    'name'    => 'Alex Johnson',
    'id'      => 'STU-2025-0042',
    'course'  => 'Bachelor of Computer Science',
    'dept'    => 'Computer Science',
    'semester'=> 'Semester 3',
    'batch'   => '2023–2026',
    'gpa'     => '3.72',
    'avatar'  => 'AJ',
    'color'   => '#6366f1',
    'bg'      => '#eef2ff',
];

$todayClasses = [
    ['time'=>'09:00–11:00','subject'=>'Data Structures','code'=>'CS201','room'=>'Lab 1','staff'=>'Dr. Mitchell','color'=>'#6366f1','status'=>'Upcoming'],
    ['time'=>'11:00–12:00','subject'=>'Calculus II',    'code'=>'MATH202','room'=>'Hall B','staff'=>'Prof. Okafor','color'=>'#0ea5e9','status'=>'Upcoming'],
    ['time'=>'14:00–16:00','subject'=>'Physics Lab',    'code'=>'PHY101','room'=>'Physics Lab','staff'=>'Dr. Nair','color'=>'#10b981','status'=>'Upcoming'],
];

$subjects = [
    ['name'=>'Data Structures',      'code'=>'CS201', 'staff'=>'Dr. Mitchell','attendance'=>88,'grade'=>'A-','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['name'=>'Calculus II',          'code'=>'MATH202','staff'=>'Prof. Okafor','attendance'=>92,'grade'=>'B+','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['name'=>'Physics Lab',          'code'=>'PHY101', 'staff'=>'Dr. Nair',   'attendance'=>75,'grade'=>'B', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['name'=>'Database Systems',     'code'=>'CS301', 'staff'=>'Dr. Yusuf',  'attendance'=>95,'grade'=>'A', 'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['name'=>'Software Engineering', 'code'=>'CS302', 'staff'=>'Mr. Hargreaves','attendance'=>80,'grade'=>'B+','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];

$upcomingExams = [
    ['subject'=>'Data Structures','code'=>'CS201','date'=>'Jul 18, 2025','time'=>'09:00 AM','room'=>'Hall A','type'=>'Mid-Term','color'=>'#6366f1'],
    ['subject'=>'Calculus II',    'code'=>'MATH202','date'=>'Jul 20, 2025','time'=>'11:00 AM','room'=>'Hall B','type'=>'Mid-Term','color'=>'#0ea5e9'],
    ['subject'=>'Physics Lab',    'code'=>'PHY101', 'date'=>'Jul 22, 2025','time'=>'02:00 PM','room'=>'Physics Lab','type'=>'Practical','color'=>'#10b981'],
];

$recentNotices = [
    ['title'=>'Mid-Term Exam Schedule Released','date'=>'Jul 10, 2025','type'=>'Exam',    'color'=>'#ef4444','bg'=>'#fee2e2'],
    ['title'=>'Library Book Return Deadline',   'date'=>'Jul 12, 2025','type'=>'Library', 'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['title'=>'Semester Fee Payment Reminder',  'date'=>'Jul 08, 2025','type'=>'Finance', 'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['title'=>'Campus Sports Day Registration', 'date'=>'Jul 07, 2025','type'=>'Event',   'color'=>'#10b981','bg'=>'#d1fae5'],
];

$assignments = [
    ['title'=>'Binary Tree Implementation','subject'=>'CS201','due'=>'Jul 15, 2025','status'=>'Pending', 'color'=>'#f59e0b'],
    ['title'=>'Integration Problems Set 3', 'subject'=>'MATH202','due'=>'Jul 16, 2025','status'=>'Submitted','color'=>'#10b981'],
    ['title'=>'Lab Report – Optics',        'subject'=>'PHY101', 'due'=>'Jul 18, 2025','status'=>'Pending', 'color'=>'#f59e0b'],
    ['title'=>'ER Diagram Design',          'subject'=>'CS301',  'due'=>'Jul 20, 2025','status'=>'Pending', 'color'=>'#f59e0b'],
];

$fees = ['total'=>1200,'paid'=>900,'due'=>300,'dueDate'=>'Jul 31, 2025'];
$overallAttendance = 86;
@endphp

{{-- ① Student Profile Banner --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:24px 28px;margin-bottom:20px;display:flex;align-items:center;gap:20px;box-shadow:0 4px 20px rgba(79,70,229,.3);">
    <div style="width:64px;height:64px;border-radius:50%;background:{{ $student['bg'] }};display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:{{ $student['color'] }};border:3px solid rgba(255,255,255,.3);flex-shrink:0;">{{ $student['avatar'] }}</div>
    <div style="flex:1;">
        <div style="font-size:20px;font-weight:800;color:#fff;">{{ $student['name'] }}</div>
        <div style="font-size:12px;color:#a5b4fc;margin-top:3px;">{{ $student['id'] }} · {{ $student['course'] }}</div>
        <div style="display:flex;gap:12px;margin-top:8px;flex-wrap:wrap;">
            @foreach([['🏛️',$student['dept']],['📅',$student['semester']],['🎓',$student['batch']]] as $tag)
            <span style="font-size:11px;font-weight:600;padding:3px 10px;background:rgba(255,255,255,.12);color:#e0e7ff;border-radius:20px;">{{ $tag[0] }} {{ $tag[1] }}</span>
            @endforeach
        </div>
    </div>
    <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
        <div style="font-size:28px;font-weight:800;color:#fff;">{{ $student['gpa'] }}</div>
        <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">CGPA</div>
    </div>
</div>

{{-- ② KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Enrolled Subjects','value'=>5,   'sub'=>'this semester',   'icon'=>'📖','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Attendance',       'value'=>$overallAttendance.'%','sub'=>'overall average','icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Upcoming Exams',   'value'=>3,   'sub'=>'next 2 weeks',    'icon'=>'📝','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Assignments Due',  'value'=>3,   'sub'=>'this week',       'icon'=>'📋','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'Fees Due',         'value'=>'$'.$fees['due'],'sub'=>'due '.$fees['dueDate'],'icon'=>'💳','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)','sh'=>'rgba(139,92,246,.25)'],
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

{{-- ③ Row 1: Today's Classes + Upcoming Exams --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

    {{-- Today's Classes --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📆 Today's Classes</div>
            <a href="/student/class-schedules" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($todayClasses as $cls)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:#f8fafc;border-radius:10px;border-left:4px solid {{ $cls['color'] }};">
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $cls['subject'] }}</div>
                    <div style="font-size:11px;color:#64748b;margin-top:2px;">{{ $cls['code'] }} · {{ $cls['staff'] }}</div>
                    <div style="display:flex;gap:10px;margin-top:4px;">
                        <span style="font-size:10px;color:#94a3b8;">⏰ {{ $cls['time'] }}</span>
                        <span style="font-size:10px;color:#94a3b8;">📍 {{ $cls['room'] }}</span>
                    </div>
                </div>
                <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:#dbeafe;color:#1e40af;white-space:nowrap;">{{ $cls['status'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Upcoming Exams --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📝 Upcoming Exams</div>
            <a href="/student/exam-schedules" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($upcomingExams as $exam)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:#f8fafc;border-radius:10px;border-left:4px solid {{ $exam['color'] }};">
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $exam['subject'] }}</div>
                    <div style="font-size:11px;color:#64748b;margin-top:2px;">{{ $exam['code'] }} · {{ $exam['room'] }}</div>
                    <div style="display:flex;gap:10px;margin-top:4px;">
                        <span style="font-size:10px;color:#94a3b8;">📅 {{ $exam['date'] }}</span>
                        <span style="font-size:10px;color:#94a3b8;">⏰ {{ $exam['time'] }}</span>
                    </div>
                </div>
                <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:#fef3c7;color:#92400e;white-space:nowrap;">{{ $exam['type'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ④ Row 2: Subject Attendance + Assignments --}}
<div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;margin-bottom:16px;">

    {{-- Subject Attendance --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">✅ Subject Attendance & Grades</div>
            <a href="/student/attendances" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($subjects as $sub)
            @php $attColor = $sub['attendance'] >= 85 ? '#10b981' : ($sub['attendance'] >= 75 ? '#f59e0b' : '#ef4444'); @endphp
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:36px;height:36px;border-radius:9px;background:{{ $sub['bg'] }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:{{ $sub['color'] }};flex-shrink:0;">{{ substr($sub['code'],0,2) }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:12px;font-weight:600;color:#1e293b;">{{ $sub['name'] }}</span>
                        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;margin-left:8px;">
                            <span style="font-size:11px;font-weight:700;color:{{ $attColor }};">{{ $sub['attendance'] }}%</span>
                            <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $sub['bg'] }};color:{{ $sub['color'] }};">{{ $sub['grade'] }}</span>
                        </div>
                    </div>
                    <div style="height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                        <div style="height:100%;width:{{ $sub['attendance'] }}%;background:{{ $attColor }};border-radius:9999px;"></div>
                    </div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $sub['staff'] }} · {{ $sub['code'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Assignments --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 Assignments</div>
            <a href="/student/assignments" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($assignments as $asgn)
            <div style="padding:11px 13px;background:#f8fafc;border-radius:10px;border-left:3px solid {{ $asgn['color'] }};">
                <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $asgn['title'] }}</div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:5px;">
                    <span style="font-size:10px;color:#94a3b8;">{{ $asgn['subject'] }} · Due {{ $asgn['due'] }}</span>
                    <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;
                        background:{{ $asgn['status']==='Submitted'?'#d1fae5':'#fef3c7' }};
                        color:{{ $asgn['status']==='Submitted'?'#065f46':'#92400e' }};">{{ $asgn['status'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ⑤ Row 3: Fees Summary + Recent Notices --}}
<div style="display:grid;grid-template-columns:1fr 2fr;gap:16px;">

    {{-- Fees Summary --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">💳 Fees Summary</div>
            <a href="/student/fees-reports" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View →</a>
        </div>
        <div style="padding:20px 16px;">
            @php $paidPct = round($fees['paid']/$fees['total']*100); @endphp
            <div style="text-align:center;margin-bottom:16px;">
                <div style="font-size:28px;font-weight:800;color:#1e293b;">${{ $fees['paid'] }}</div>
                <div style="font-size:11px;color:#94a3b8;">paid of ${{ $fees['total'] }} total</div>
            </div>
            <div style="height:10px;background:#f1f5f9;border-radius:9999px;overflow:hidden;margin-bottom:10px;">
                <div style="height:100%;width:{{ $paidPct }}%;background:linear-gradient(90deg,#10b981,#34d399);border-radius:9999px;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:16px;">
                <span style="color:#10b981;font-weight:700;">✅ Paid {{ $paidPct }}%</span>
                <span style="color:#ef4444;font-weight:700;">⚠ Due ${{ $fees['due'] }}</span>
            </div>
            <div style="background:#fef2f2;border-radius:9px;padding:10px 12px;text-align:center;">
                <div style="font-size:11px;color:#ef4444;font-weight:600;">Due Date: {{ $fees['dueDate'] }}</div>
            </div>
        </div>
    </div>

    {{-- Recent Notices --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📢 Recent Notices</div>
            <a href="/student/notices" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View all →</a>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($recentNotices as $notice)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:#f8fafc;border-radius:10px;">
                <div style="width:36px;height:36px;border-radius:9px;background:{{ $notice['bg'] }};display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">📢</div>
                <div style="flex:1;">
                    <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $notice['title'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $notice['date'] }}</div>
                </div>
                <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $notice['bg'] }};color:{{ $notice['color'] }};white-space:nowrap;">{{ $notice['type'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
