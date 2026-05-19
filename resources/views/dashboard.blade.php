<x-app-layout>
<div style="padding:32px 32px 48px;background:#f8fafc;min-height:100vh;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
        <div>
            <div style="font-size:22px;font-weight:800;color:#0f172a;letter-spacing:-.3px;">Dashboard</div>
            <div style="font-size:13px;color:#94a3b8;margin-top:3px;">{{ now()->format('l, d F Y') }} &nbsp;·&nbsp; Welcome back, <span style="color:#4f46e5;font-weight:600;">{{ Auth::user()->name }}</span></div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="/academic/overview" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#4f46e5;color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;">
                📊 Overview
            </a>
            <a href="/academic/timetable" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#fff;color:#374151;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;">
                🗓️ Timetable
            </a>
        </div>
    </div>

    {{-- KPI Stats --}}
    @php
    $stats = [
        ['label'=>'Departments',    'value'=>5,  'icon'=>'🏛️', 'trend'=>'+1',  'up'=>true,  'url'=>'/academic/departments', 'grad'=>'linear-gradient(135deg,#6366f1,#818cf8)', 'shadow'=>'rgba(99,102,241,.25)'],
        ['label'=>'Courses',        'value'=>7,  'icon'=>'🎓', 'trend'=>'+2',  'up'=>true,  'url'=>'/academic/courses',     'grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)', 'shadow'=>'rgba(14,165,233,.25)'],
        ['label'=>'Subjects',       'value'=>10, 'icon'=>'📖', 'trend'=>'+3',  'up'=>true,  'url'=>'/academic/subjects',    'grad'=>'linear-gradient(135deg,#10b981,#34d399)', 'shadow'=>'rgba(16,185,129,.25)'],
        ['label'=>'Semesters',      'value'=>6,  'icon'=>'📅', 'trend'=>'0',   'up'=>null,  'url'=>'/academic/semesters',   'grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)', 'shadow'=>'rgba(245,158,11,.25)'],
        ['label'=>'Buildings',      'value'=>6,  'icon'=>'🏢', 'trend'=>'+1',  'up'=>true,  'url'=>'/academic/buildings',   'grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)', 'shadow'=>'rgba(139,92,246,.25)'],
        ['label'=>'Rooms',          'value'=>8,  'icon'=>'🏫', 'trend'=>'+2',  'up'=>true,  'url'=>'/academic/rooms',       'grad'=>'linear-gradient(135deg,#ec4899,#f472b6)', 'shadow'=>'rgba(236,72,153,.25)'],
        ['label'=>'Staff',          'value'=>5,  'icon'=>'👤', 'trend'=>'-1',  'up'=>false, 'url'=>'/academic/staff',       'grad'=>'linear-gradient(135deg,#14b8a6,#2dd4bf)', 'shadow'=>'rgba(20,184,166,.25)'],
        ['label'=>'Timetable Slots','value'=>7,  'icon'=>'🗓️', 'trend'=>'+4',  'up'=>true,  'url'=>'/academic/timetable',   'grad'=>'linear-gradient(135deg,#f43f5e,#fb7185)', 'shadow'=>'rgba(244,63,94,.25)'],
    ];
    @endphp
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;">
        @foreach($stats as $s)
        <a href="{{ $s['url'] }}" style="background:{{ $s['grad'] }};border-radius:16px;padding:22px 24px;color:#fff;box-shadow:0 6px 24px {{ $s['shadow'] }};display:flex;align-items:flex-start;justify-content:space-between;text-decoration:none;transition:transform .15s,box-shadow .15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 32px {{ $s['shadow'] }}'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 24px {{ $s['shadow'] }}'">
            <div>
                <div style="font-size:30px;font-weight:800;line-height:1;letter-spacing:-.5px;">{{ $s['value'] }}</div>
                <div style="font-size:12px;opacity:.85;margin-top:5px;font-weight:500;">{{ $s['label'] }}</div>
                <div style="margin-top:10px;font-size:11px;font-weight:600;opacity:.9;background:rgba(255,255,255,.2);display:inline-block;padding:2px 8px;border-radius:20px;">
                    @if($s['up'] === true) ↑ {{ $s['trend'] }} this month
                    @elseif($s['up'] === false) ↓ {{ $s['trend'] }} this month
                    @else — no change
                    @endif
                </div>
            </div>
            <div style="font-size:36px;opacity:.35;margin-top:2px;">{{ $s['icon'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Main Content: Quick Access + Today's Snapshot --}}
    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

        {{-- Quick Access Modules --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 8px rgba(0,0,0,.05);overflow:hidden;">
            <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:15px;font-weight:700;color:#0f172a;">Quick Access</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Jump to any module</div>
                </div>
            </div>

            @php
            $groups = [
                ['title'=>'🏛️ Academic', 'items'=>[
                    ['label'=>'Departments','icon'=>'🏛️','url'=>'/academic/departments','bg'=>'#eef2ff','text'=>'#4338ca'],
                    ['label'=>'Courses',    'icon'=>'🎓','url'=>'/academic/courses',    'bg'=>'#e0f2fe','text'=>'#0369a1'],
                    ['label'=>'Subjects',   'icon'=>'📖','url'=>'/academic/subjects',   'bg'=>'#d1fae5','text'=>'#065f46'],
                    ['label'=>'Semesters',  'icon'=>'📅','url'=>'/academic/semesters',  'bg'=>'#fef9c3','text'=>'#854d0e'],
                    ['label'=>'Faculties',  'icon'=>'🎖️','url'=>'/academic-ext/faculties','bg'=>'#fce7f3','text'=>'#9d174d'],
                    ['label'=>'Programs',   'icon'=>'📋','url'=>'/academic-ext/programs','bg'=>'#f0fdf4','text'=>'#166534'],
                ]],
                ['title'=>'🗓️ Timetable', 'items'=>[
                    ['label'=>'Timetable',       'icon'=>'🗓️','url'=>'/academic/timetable',          'bg'=>'#ffe4e6','text'=>'#9f1239'],
                    ['label'=>'Manage Classes',  'icon'=>'📐','url'=>'/routines/manage-classes',      'bg'=>'#f3e8ff','text'=>'#6b21a8'],
                    ['label'=>'Class Schedules', 'icon'=>'📆','url'=>'/routines/class-schedules',     'bg'=>'#e0e7ff','text'=>'#3730a3'],
                    ['label'=>'Manage Exams',    'icon'=>'📝','url'=>'/routines/manage-exams',        'bg'=>'#fef9c3','text'=>'#854d0e'],
                    ['label'=>'Exam Schedules',  'icon'=>'📋','url'=>'/routines/exam-schedules',      'bg'=>'#d1fae5','text'=>'#065f46'],
                    ['label'=>'Teacher Routines','icon'=>'👨‍🏫','url'=>'/routines/teacher-routines',   'bg'=>'#e0f2fe','text'=>'#0369a1'],
                ]],
                ['title'=>'🏢 Facilities', 'items'=>[
                    ['label'=>'Buildings',  'icon'=>'🏢','url'=>'/academic/buildings',  'bg'=>'#f3e8ff','text'=>'#6b21a8'],
                    ['label'=>'Rooms',      'icon'=>'🏫','url'=>'/academic/rooms',      'bg'=>'#fce7f3','text'=>'#9d174d'],
                    ['label'=>'Hostels',    'icon'=>'🏠','url'=>'/facilities/hostel-list','bg'=>'#d1fae5','text'=>'#065f46'],
                    ['label'=>'Vehicles',   'icon'=>'🚌','url'=>'/facilities/vehicles', 'bg'=>'#e0f2fe','text'=>'#0369a1'],
                    ['label'=>'Routes',     'icon'=>'🗺️','url'=>'/facilities/routes',   'bg'=>'#fef9c3','text'=>'#854d0e'],
                    ['label'=>'Room Types', 'icon'=>'🔑','url'=>'/facilities/room-types','bg'=>'#ffe4e6','text'=>'#9f1239'],
                ]],
                ['title'=>'👥 People', 'items'=>[
                    ['label'=>'Staff',        'icon'=>'👤','url'=>'/academic/staff',         'bg'=>'#ccfbf1','text'=>'#134e4a'],
                    ['label'=>'Staff List',   'icon'=>'📋','url'=>'/staff/staff-list',        'bg'=>'#e0e7ff','text'=>'#3730a3'],
                    ['label'=>'Student List', 'icon'=>'🧑‍🎓','url'=>'/admission/student-list','bg'=>'#fce7f3','text'=>'#9d174d'],
                    ['label'=>'Designations', 'icon'=>'🏷️','url'=>'/staff/designations',     'bg'=>'#fef9c3','text'=>'#854d0e'],
                    ['label'=>'Departments',  'icon'=>'🏢','url'=>'/staff/departments',       'bg'=>'#d1fae5','text'=>'#065f46'],
                    ['label'=>'Payrolls',     'icon'=>'💰','url'=>'/staff/payrolls',          'bg'=>'#e0f2fe','text'=>'#0369a1'],
                ]],
            ];
            @endphp

            <div style="padding:20px 24px;display:flex;flex-direction:column;gap:24px;">
                @foreach($groups as $group)
                <div>
                    <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">{{ $group['title'] }}</div>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                        @foreach($group['items'] as $item)
                        <a href="{{ $item['url'] }}" style="display:flex;align-items:center;gap:10px;padding:11px 13px;background:{{ $item['bg'] }};border-radius:10px;text-decoration:none;transition:opacity .15s;" onmouseover="this.style.opacity='.75'" onmouseout="this.style.opacity='1'">
                            <span style="font-size:18px;flex-shrink:0;">{{ $item['icon'] }}</span>
                            <span style="font-size:12px;font-weight:600;color:{{ $item['text'] }};line-height:1.3;">{{ $item['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right Column --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- System Status --}}
            <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 8px rgba(0,0,0,.05);overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;">⚡ System Status</div>
                </div>
                <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['label'=>'Active Semester',  'value'=>'Sem 1 · 2025',    'color'=>'#10b981','bg'=>'#f0fdf4'],
                        ['label'=>'Active Timetable', 'value'=>'7 slots live',     'color'=>'#6366f1','bg'=>'#eef2ff'],
                        ['label'=>'Rooms Available',  'value'=>'6 of 8',           'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
                        ['label'=>'Staff On Duty',    'value'=>'4 of 5',           'color'=>'#f59e0b','bg'=>'#fef9c3'],
                        ['label'=>'Pending Exams',    'value'=>'2 scheduled',      'color'=>'#f43f5e','bg'=>'#ffe4e6'],
                    ] as $row)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 12px;background:{{ $row['bg'] }};border-radius:9px;">
                        <span style="font-size:12px;color:#475569;font-weight:500;">{{ $row['label'] }}</span>
                        <span style="font-size:12px;font-weight:700;color:{{ $row['color'] }};">{{ $row['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Today's Classes --}}
            <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 8px rgba(0,0,0,.05);overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;">📆 Today's Classes</div>
                    <a href="/routines/class-schedules" style="font-size:11px;color:#4f46e5;font-weight:600;text-decoration:none;">View all →</a>
                </div>
                <div style="padding:12px 20px;display:flex;flex-direction:column;gap:8px;">
                    @foreach([
                        ['time'=>'08:00','subject'=>'CS101','room'=>'Hall A',  'staff'=>'Dr. Ali',   'color'=>'#6366f1'],
                        ['time'=>'10:00','subject'=>'DS201','room'=>'Lab 1',   'staff'=>'Dr. Amina', 'color'=>'#10b981'],
                        ['time'=>'12:00','subject'=>'MT301','room'=>'Room 3',  'staff'=>'Mr. Yusuf', 'color'=>'#f59e0b'],
                        ['time'=>'14:00','subject'=>'CS401','room'=>'Hall B',  'staff'=>'Dr. Sara',  'color'=>'#0ea5e9'],
                        ['time'=>'16:00','subject'=>'DS401','room'=>'Lab 2',   'staff'=>'Dr. Ali',   'color'=>'#8b5cf6'],
                    ] as $cls)
                    <div style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;background:#f8fafc;border-left:3px solid {{ $cls['color'] }};">
                        <div style="font-size:11px;font-weight:700;color:#94a3b8;width:36px;flex-shrink:0;">{{ $cls['time'] }}</div>
                        <div style="flex:1;">
                            <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $cls['subject'] }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $cls['room'] }} · {{ $cls['staff'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Module Links --}}
            <div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:20px;display:flex;flex-direction:column;gap:8px;">
                <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:4px;">🔗 More Modules</div>
                @foreach([
                    ['label'=>'Examinations',  'url'=>'/examinations/exam-results',   'icon'=>'📝'],
                    ['label'=>'Finance',        'url'=>'/finance/fees-due',            'icon'=>'💳'],
                    ['label'=>'Library',        'url'=>'/library-mgmt/book-list',      'icon'=>'📚'],
                    ['label'=>'Communicate',    'url'=>'/communicate/notice-list',     'icon'=>'📢'],
                    ['label'=>'Reports',        'url'=>'/reports/student-progress',    'icon'=>'📊'],
                    ['label'=>'Settings',       'url'=>'/settings/general',            'icon'=>'⚙️'],
                ] as $lnk)
                <a href="{{ $lnk['url'] }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:rgba(255,255,255,.1);border-radius:9px;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.18)'" onmouseout="this.style.background='rgba(255,255,255,.1)'">
                    <span style="font-size:16px;">{{ $lnk['icon'] }}</span>
                    <span style="font-size:12px;font-weight:600;color:#e0e7ff;">{{ $lnk['label'] }}</span>
                    <span style="margin-left:auto;color:#818cf8;font-size:12px;">→</span>
                </a>
                @endforeach
            </div>

        </div>
    </div>

</div>
</x-app-layout>
