@extends('layouts.academic')
@section('title', 'Transcript')
@section('heading', 'Transcript')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Academic Record</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ Download PDF</a>
@endsection

@section('content')
@php
$student = [
    'name'    => 'Alex Johnson',
    'id'      => 'STU-2025-0042',
    'course'  => 'Bachelor of Computer Science',
    'dept'    => 'Computer Science',
    'batch'   => '2023–2026',
    'session' => '2023–2024',
    'avatar'  => 'AJ',
    'color'   => '#6366f1',
    'bg'      => '#eef2ff',
];

$semesters = [
    [
        'name'    => 'Semester 1',
        'session' => '2023–2024',
        'status'  => 'Completed',
        'gpa'     => 3.80,
        'subjects' => [
            ['code'=>'CS101', 'name'=>'Introduction to Programming','credits'=>3,'marks'=>88,'grade'=>'A-','points'=>3.7],
            ['code'=>'MATH101','name'=>'Calculus I',                'credits'=>3,'marks'=>82,'grade'=>'B+','points'=>3.3],
            ['code'=>'PHY101', 'name'=>'Physics I',                 'credits'=>3,'marks'=>91,'grade'=>'A', 'points'=>4.0],
            ['code'=>'ENG101', 'name'=>'English Communication',     'credits'=>2,'marks'=>85,'grade'=>'A-','points'=>3.7],
            ['code'=>'CS102',  'name'=>'Digital Logic Design',      'credits'=>3,'marks'=>79,'grade'=>'B+','points'=>3.3],
        ],
    ],
    [
        'name'    => 'Semester 2',
        'session' => '2023–2024',
        'status'  => 'Completed',
        'gpa'     => 3.65,
        'subjects' => [
            ['code'=>'CS201', 'name'=>'Data Structures',            'credits'=>3,'marks'=>84,'grade'=>'A-','points'=>3.7],
            ['code'=>'MATH201','name'=>'Calculus II',               'credits'=>3,'marks'=>76,'grade'=>'B', 'points'=>3.0],
            ['code'=>'CS202', 'name'=>'Object Oriented Programming','credits'=>3,'marks'=>90,'grade'=>'A', 'points'=>4.0],
            ['code'=>'CS203', 'name'=>'Computer Organization',      'credits'=>3,'marks'=>72,'grade'=>'B', 'points'=>3.0],
            ['code'=>'HUM101','name'=>'Islamic Studies',            'credits'=>2,'marks'=>88,'grade'=>'A-','points'=>3.7],
        ],
    ],
    [
        'name'    => 'Semester 3',
        'session' => '2024–2025',
        'status'  => 'In Progress',
        'gpa'     => null,
        'subjects' => [
            ['code'=>'CS301', 'name'=>'Database Systems',           'credits'=>3,'marks'=>null,'grade'=>'—','points'=>null],
            ['code'=>'MATH202','name'=>'Calculus III',              'credits'=>3,'marks'=>null,'grade'=>'—','points'=>null],
            ['code'=>'CS302', 'name'=>'Software Engineering',       'credits'=>3,'marks'=>null,'grade'=>'—','points'=>null],
            ['code'=>'PHY201','name'=>'Physics Lab',                'credits'=>2,'marks'=>null,'grade'=>'—','points'=>null],
            ['code'=>'CS303', 'name'=>'Computer Networks',          'credits'=>3,'marks'=>null,'grade'=>'—','points'=>null],
        ],
    ],
];

$gradeScale = [
    ['grade'=>'A',  'points'=>4.0,'marks'=>'90–100','desc'=>'Excellent'],
    ['grade'=>'A-', 'points'=>3.7,'marks'=>'85–89', 'desc'=>'Very Good'],
    ['grade'=>'B+', 'points'=>3.3,'marks'=>'80–84', 'desc'=>'Good'],
    ['grade'=>'B',  'points'=>3.0,'marks'=>'75–79', 'desc'=>'Above Average'],
    ['grade'=>'B-', 'points'=>2.7,'marks'=>'70–74', 'desc'=>'Average'],
    ['grade'=>'C+', 'points'=>2.3,'marks'=>'65–69', 'desc'=>'Below Average'],
    ['grade'=>'C',  'points'=>2.0,'marks'=>'60–64', 'desc'=>'Pass'],
    ['grade'=>'F',  'points'=>0.0,'marks'=>'0–59',  'desc'=>'Fail'],
];

// CGPA calculation from completed semesters
$completedSems = array_filter($semesters, fn($s) => $s['status'] === 'Completed');
$cgpa = round(array_sum(array_column($completedSems, 'gpa')) / count($completedSems), 2);
$totalCredits = 0;
foreach($completedSems as $sem) {
    foreach($sem['subjects'] as $sub) $totalCredits += $sub['credits'];
}
@endphp

{{-- ① Student Banner --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:24px 28px;margin-bottom:20px;display:flex;align-items:center;gap:20px;box-shadow:0 4px 20px rgba(79,70,229,.3);">
    <div style="width:64px;height:64px;border-radius:50%;background:{{ $student['bg'] }};display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:{{ $student['color'] }};border:3px solid rgba(255,255,255,.3);flex-shrink:0;">{{ $student['avatar'] }}</div>
    <div style="flex:1;">
        <div style="font-size:20px;font-weight:800;color:#fff;">{{ $student['name'] }}</div>
        <div style="font-size:12px;color:#a5b4fc;margin-top:3px;">{{ $student['id'] }} · {{ $student['course'] }}</div>
        <div style="display:flex;gap:12px;margin-top:8px;flex-wrap:wrap;">
            @foreach([['🏛️',$student['dept']],['🎓',$student['batch']],['📅',$student['session']]] as $tag)
            <span style="font-size:11px;font-weight:600;padding:3px 10px;background:rgba(255,255,255,.12);color:#e0e7ff;border-radius:20px;">{{ $tag[0] }} {{ $tag[1] }}</span>
            @endforeach
        </div>
    </div>
    <div style="display:flex;gap:16px;">
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:28px;font-weight:800;color:#fff;">{{ $cgpa }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">CGPA</div>
        </div>
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:28px;font-weight:800;color:#fff;">{{ $totalCredits }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">CREDITS</div>
        </div>
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:28px;font-weight:800;color:#fff;">{{ count($completedSems) }}/{{ count($semesters) }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">SEMESTERS</div>
        </div>
    </div>
</div>

{{-- ② KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'CGPA',            'value'=>$cgpa,         'sub'=>'cumulative GPA',    'icon'=>'🎯','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Credits Earned',  'value'=>$totalCredits, 'sub'=>'completed semesters','icon'=>'📚','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Semesters Done',  'value'=>count($completedSems),'sub'=>'of '.count($semesters).' total','icon'=>'📅','grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)','sh'=>'rgba(14,165,233,.25)'],
        ['label'=>'Standing',        'value'=>($cgpa>=3.5?'Distinction':($cgpa>=3.0?'Merit':'Pass')),'sub'=>'academic standing','icon'=>'🏆','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ③ Semester Transcripts --}}
@foreach($semesters as $si => $sem)
@php
    $isCompleted = $sem['status'] === 'Completed';
    $semColors   = ['#6366f1','#0ea5e9','#10b981'];
    $sc          = $semColors[$si] ?? '#6366f1';
    $totalSemCredits = array_sum(array_column($sem['subjects'],'credits'));
@endphp
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;background:{{ $isCompleted ? 'linear-gradient(135deg,'.$sc.'15,'.$sc.'08)' : '#f8fafc' }};border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;border-radius:9px;background:{{ $sc }};display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;">{{ $si+1 }}</div>
            <div>
                <div style="font-size:14px;font-weight:800;color:#1e1b4b;">{{ $sem['name'] }}</div>
                <div style="font-size:11px;color:#94a3b8;">{{ $sem['session'] }} · {{ $totalSemCredits }} credits</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            @if($isCompleted)
            <div style="text-align:center;padding:8px 16px;background:{{ $sc }}15;border-radius:9px;">
                <div style="font-size:18px;font-weight:800;color:{{ $sc }};">{{ $sem['gpa'] }}</div>
                <div style="font-size:9px;color:#94a3b8;font-weight:600;">GPA</div>
            </div>
            @endif
            <span style="font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;
                background:{{ $isCompleted ? '#d1fae5' : '#dbeafe' }};
                color:{{ $isCompleted ? '#065f46' : '#1e40af' }};">
                {{ $sem['status'] }}
            </span>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject</th>
                    <th style="text-align:center;">Credits</th>
                    <th style="text-align:center;">Marks</th>
                    <th style="text-align:center;">Grade</th>
                    <th style="text-align:center;">Grade Points</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sem['subjects'] as $sub)
                @php
                    $gradeColor = match(true) {
                        $sub['grade'] === 'A'  => ['bg'=>'#d1fae5','color'=>'#065f46'],
                        $sub['grade'] === 'A-' => ['bg'=>'#d1fae5','color'=>'#065f46'],
                        $sub['grade'] === 'B+' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                        $sub['grade'] === 'B'  => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                        $sub['grade'] === 'F'  => ['bg'=>'#fee2e2','color'=>'#991b1b'],
                        default                => ['bg'=>'#f1f5f9','color'=>'#475569'],
                    };
                @endphp
                <tr>
                    <td><span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $sc }}15;color:{{ $sc }};">{{ $sub['code'] }}</span></td>
                    <td style="font-size:12px;font-weight:600;color:#1e293b;">{{ $sub['name'] }}</td>
                    <td style="text-align:center;font-size:12px;color:#64748b;">{{ $sub['credits'] }}</td>
                    <td style="text-align:center;font-size:12px;font-weight:700;color:#1e293b;">{{ $sub['marks'] ?? '—' }}</td>
                    <td style="text-align:center;">
                        <span style="font-size:12px;font-weight:800;padding:3px 10px;border-radius:20px;background:{{ $gradeColor['bg'] }};color:{{ $gradeColor['color'] }};">{{ $sub['grade'] }}</span>
                    </td>
                    <td style="text-align:center;font-size:12px;font-weight:700;color:{{ $sc }};">{{ $sub['points'] ?? '—' }}</td>
                    <td style="text-align:center;">
                        @if($isCompleted)
                        <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:#d1fae5;color:#065f46;">Pass</span>
                        @else
                        <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:#dbeafe;color:#1e40af;">Ongoing</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @if($isCompleted)
            <tfoot>
                <tr style="background:#f8fafc;">
                    <td colspan="2" style="font-size:12px;font-weight:800;color:#1e1b4b;">Semester Total</td>
                    <td style="text-align:center;font-size:12px;font-weight:800;color:#1e293b;">{{ $totalSemCredits }}</td>
                    <td colspan="2"></td>
                    <td style="text-align:center;font-size:13px;font-weight:800;color:{{ $sc }};">{{ $sem['gpa'] }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endforeach

{{-- ④ Grade Scale + CGPA Progress --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">

    {{-- Grade Scale --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📊 Grading Scale</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center;">Grade</th>
                        <th style="text-align:center;">Points</th>
                        <th style="text-align:center;">Marks Range</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gradeScale as $g)
                    @php
                        $gc = match(true) {
                            $g['points'] >= 3.7 => ['bg'=>'#d1fae5','color'=>'#065f46'],
                            $g['points'] >= 3.0 => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                            $g['points'] >= 2.0 => ['bg'=>'#fef3c7','color'=>'#92400e'],
                            default             => ['bg'=>'#fee2e2','color'=>'#991b1b'],
                        };
                    @endphp
                    <tr>
                        <td style="text-align:center;"><span style="font-size:13px;font-weight:800;padding:3px 12px;border-radius:20px;background:{{ $gc['bg'] }};color:{{ $gc['color'] }};">{{ $g['grade'] }}</span></td>
                        <td style="text-align:center;font-size:12px;font-weight:700;color:#1e293b;">{{ $g['points'] }}</td>
                        <td style="text-align:center;font-size:12px;color:#64748b;">{{ $g['marks'] }}</td>
                        <td style="font-size:12px;color:#475569;">{{ $g['desc'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- CGPA Progress --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📈 GPA Progress</div>
        </div>
        <div style="padding:20px;">
            @foreach($semesters as $si => $sem)
            @php $sc = $semColors[$si] ?? '#6366f1'; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                    <span style="font-size:12px;font-weight:600;color:#1e293b;">{{ $sem['name'] }}</span>
                    <span style="font-size:12px;font-weight:800;color:{{ $sc }};">{{ $sem['gpa'] ?? 'Ongoing' }}</span>
                </div>
                @if($sem['gpa'])
                <div style="height:8px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                    <div style="height:100%;width:{{ round($sem['gpa']/4*100) }}%;background:{{ $sc }};border-radius:9999px;"></div>
                </div>
                <div style="font-size:9px;color:#94a3b8;margin-top:3px;">{{ round($sem['gpa']/4*100) }}% of 4.0</div>
                @else
                <div style="height:8px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                    <div style="height:100%;width:0%;background:{{ $sc }};border-radius:9999px;"></div>
                </div>
                <div style="font-size:9px;color:#94a3b8;margin-top:3px;">In progress</div>
                @endif
            </div>
            @endforeach

            <div style="margin-top:8px;padding:12px 14px;background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:10px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:12px;font-weight:700;color:#e0e7ff;">Cumulative GPA</span>
                    <span style="font-size:20px;font-weight:800;color:#fff;">{{ $cgpa }}</span>
                </div>
                <div style="height:6px;background:rgba(255,255,255,.2);border-radius:9999px;overflow:hidden;margin-top:8px;">
                    <div style="height:100%;width:{{ round($cgpa/4*100) }}%;background:#a5b4fc;border-radius:9999px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
