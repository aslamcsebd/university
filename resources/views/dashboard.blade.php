<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Banner --}}
            <div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:28px 32px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 24px rgba(79,70,229,.3);">
                <div>
                    <div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:6px;">
                        Welcome back, {{ Auth::user()->name }} 👋
                    </div>
                    <div style="font-size:13px;color:#c7d2fe;">
                        Academic Timetable Module &nbsp;·&nbsp; {{ now()->format('l, d F Y') }}
                    </div>
                </div>
                <div style="font-size:56px;opacity:.25;">🎓</div>
            </div>

            {{-- Stats Row --}}
            @php
            $stats = [
                ['label'=>'Departments',  'value'=>5,  'icon'=>'🏛️', 'grad'=>'linear-gradient(135deg,#6366f1,#818cf8)', 'shadow'=>'rgba(99,102,241,.3)'],
                ['label'=>'Courses',      'value'=>7,  'icon'=>'🎓', 'grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)', 'shadow'=>'rgba(14,165,233,.3)'],
                ['label'=>'Subjects',     'value'=>10, 'icon'=>'📖', 'grad'=>'linear-gradient(135deg,#10b981,#34d399)', 'shadow'=>'rgba(16,185,129,.3)'],
                ['label'=>'Semesters',    'value'=>6,  'icon'=>'📅', 'grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)', 'shadow'=>'rgba(245,158,11,.3)'],
                ['label'=>'Buildings',    'value'=>6,  'icon'=>'🏢', 'grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)', 'shadow'=>'rgba(139,92,246,.3)'],
                ['label'=>'Rooms',        'value'=>8,  'icon'=>'🏫', 'grad'=>'linear-gradient(135deg,#ec4899,#f472b6)', 'shadow'=>'rgba(236,72,153,.3)'],
                ['label'=>'Staff',        'value'=>5,  'icon'=>'👤', 'grad'=>'linear-gradient(135deg,#14b8a6,#2dd4bf)', 'shadow'=>'rgba(20,184,166,.3)'],
                ['label'=>'Timetable Slots','value'=>7,'icon'=>'🗓️', 'grad'=>'linear-gradient(135deg,#f43f5e,#fb7185)', 'shadow'=>'rgba(244,63,94,.3)'],
            ];
            @endphp
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
                @foreach($stats as $s)
                <div style="background:{{ $s['grad'] }};border-radius:14px;padding:20px 22px;color:#fff;box-shadow:0 4px 20px {{ $s['shadow'] }};display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:28px;font-weight:800;line-height:1;">{{ $s['value'] }}</div>
                        <div style="font-size:12px;opacity:.85;margin-top:4px;">{{ $s['label'] }}</div>
                    </div>
                    <div style="font-size:34px;opacity:.6;">{{ $s['icon'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Quick Navigation --}}
            <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 6px rgba(0,0,0,.06);overflow:hidden;">
                <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:15px;font-weight:700;color:#1e1b4b;">Academic Module</div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Quick access to all pages</div>
                    </div>
                    <a href="/academic/overview" style="font-size:12px;font-weight:600;color:#4f46e5;text-decoration:none;padding:6px 14px;border:1.5px solid #4f46e5;border-radius:7px;">View Overview →</a>
                </div>
                <div style="padding:20px 24px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                    @foreach([
                        ['label'=>'Departments', 'icon'=>'🏛️', 'url'=>'/academic/departments', 'desc'=>'Manage academic departments','bg'=>'#eef2ff','text'=>'#4338ca','dot'=>'#6366f1'],
                        ['label'=>'Courses',     'icon'=>'🎓', 'url'=>'/academic/courses',     'desc'=>'Programmes & qualifications','bg'=>'#e0f2fe','text'=>'#0369a1','dot'=>'#0ea5e9'],
                        ['label'=>'Subjects',    'icon'=>'📖', 'url'=>'/academic/subjects',    'desc'=>'Modules under each course','bg'=>'#d1fae5','text'=>'#065f46','dot'=>'#10b981'],
                        ['label'=>'Semesters',   'icon'=>'📅', 'url'=>'/academic/semesters',   'desc'=>'Term periods with subjects','bg'=>'#fef9c3','text'=>'#854d0e','dot'=>'#f59e0b'],
                        ['label'=>'Buildings',   'icon'=>'🏢', 'url'=>'/academic/buildings',   'desc'=>'Campus buildings & floors','bg'=>'#f3e8ff','text'=>'#6b21a8','dot'=>'#8b5cf6'],
                        ['label'=>'Rooms',       'icon'=>'🏫', 'url'=>'/academic/rooms',       'desc'=>'Rooms with capacity & type','bg'=>'#fce7f3','text'=>'#9d174d','dot'=>'#ec4899'],
                        ['label'=>'Staff',       'icon'=>'👤', 'url'=>'/academic/staff',       'desc'=>'Academic staff assignments','bg'=>'#ccfbf1','text'=>'#134e4a','dot'=>'#14b8a6'],
                        ['label'=>'Timetable',   'icon'=>'🗓️', 'url'=>'/academic/timetable',   'desc'=>'Schedule & manage slots','bg'=>'#ffe4e6','text'=>'#9f1239','dot'=>'#f43f5e'],
                        ['label'=>'Overview',    'icon'=>'📊', 'url'=>'/academic/overview',    'desc'=>'HR workload at a glance','bg'=>'#e0e7ff','text'=>'#3730a3','dot'=>'#4f46e5'],
                    ] as $card)
                    <a href="{{ $card['url'] }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:{{ $card['bg'] }};border-radius:12px;text-decoration:none;transition:opacity .15s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                        <div style="width:42px;height:42px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;box-shadow:0 1px 4px rgba(0,0,0,.08);">{{ $card['icon'] }}</div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:{{ $card['text'] }};">{{ $card['label'] }}</div>
                            <div style="font-size:11px;color:{{ $card['text'] }};opacity:.7;margin-top:2px;">{{ $card['desc'] }}</div>
                        </div>
                        <div style="margin-left:auto;width:8px;height:8px;border-radius:50%;background:{{ $card['dot'] }};flex-shrink:0;"></div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Bottom Row: Recent Activity + Quick Tips --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                {{-- Recent Activity --}}
                <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 6px rgba(0,0,0,.06);overflow:hidden;">
                    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🕐 Recent Activity</div>
                    </div>
                    <div style="padding:8px 0;">
                        @foreach([
                            ['action'=>'New slot created','detail'=>'CS101 · Mon 13 Jan · Hall A','time'=>'2 min ago','color'=>'#10b981'],
                            ['action'=>'Semester activated','detail'=>'Sem 1 2025 – BCS','time'=>'1 hr ago','color'=>'#6366f1'],
                            ['action'=>'Room set to Maintenance','detail'=>'Computer Lab 2 · BLK-B','time'=>'3 hrs ago','color'=>'#f59e0b'],
                            ['action'=>'Staff assigned','detail'=>'Dr. Amina Yusuf · Data Science','time'=>'Yesterday','color'=>'#0ea5e9'],
                            ['action'=>'Slot cancelled','detail'=>'CS301 · Fri 17 Jan · Lab 1','time'=>'Yesterday','color'=>'#ef4444'],
                            ['action'=>'New subject added','detail'=>'DS401 – Machine Learning','time'=>'2 days ago','color'=>'#8b5cf6'],
                        ] as $a)
                        <div style="display:flex;align-items:center;gap:12px;padding:10px 20px;border-bottom:1px solid #f8fafc;">
                            <div style="width:8px;height:8px;border-radius:50%;background:{{ $a['color'] }};flex-shrink:0;"></div>
                            <div style="flex:1;">
                                <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ $a['action'] }}</div>
                                <div style="font-size:11px;color:#94a3b8;">{{ $a['detail'] }}</div>
                            </div>
                            <div style="font-size:11px;color:#cbd5e1;white-space:nowrap;">{{ $a['time'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Setup Checklist --}}
                <div style="background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 6px rgba(0,0,0,.06);overflow:hidden;">
                    <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">✅ Setup Checklist</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Follow this order to set up the module</div>
                    </div>
                    <div style="padding:12px 20px;display:flex;flex-direction:column;gap:8px;">
                        @foreach([
                            ['step'=>1,'label'=>'Create Departments',  'url'=>'/academic/departments','done'=>true],
                            ['step'=>2,'label'=>'Add Courses',         'url'=>'/academic/courses',    'done'=>true],
                            ['step'=>3,'label'=>'Add Subjects',        'url'=>'/academic/subjects',   'done'=>true],
                            ['step'=>4,'label'=>'Create Semesters',    'url'=>'/academic/semesters',  'done'=>true],
                            ['step'=>5,'label'=>'Add Buildings',       'url'=>'/academic/buildings',  'done'=>true],
                            ['step'=>6,'label'=>'Add Rooms',           'url'=>'/academic/rooms',      'done'=>true],
                            ['step'=>7,'label'=>'Assign Staff',        'url'=>'/academic/staff',      'done'=>true],
                            ['step'=>8,'label'=>'Schedule Timetable',  'url'=>'/academic/timetable',  'done'=>false],
                            ['step'=>9,'label'=>'Review Overview',     'url'=>'/academic/overview',   'done'=>false],
                        ] as $item)
                        <a href="{{ $item['url'] }}" style="display:flex;align-items:center;gap:12px;padding:9px 12px;border-radius:9px;text-decoration:none;background:{{ $item['done'] ? '#f0fdf4' : '#f8fafc' }};border:1px solid {{ $item['done'] ? '#bbf7d0' : '#e2e8f0' }};">
                            <div style="width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;background:{{ $item['done'] ? '#10b981' : '#e2e8f0' }};color:{{ $item['done'] ? '#fff' : '#94a3b8' }};">
                                {{ $item['done'] ? '✓' : $item['step'] }}
                            </div>
                            <span style="font-size:12px;font-weight:600;color:{{ $item['done'] ? '#065f46' : '#475569' }};">{{ $item['label'] }}</span>
                            <span style="margin-left:auto;font-size:11px;color:{{ $item['done'] ? '#10b981' : '#94a3b8' }};">{{ $item['done'] ? 'Done' : 'Pending' }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
