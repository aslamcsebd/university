@extends('layouts.academic')
@section('title', 'Academic Overview')
@section('heading', 'Academic Overview — HR Workload View')

@section('header-actions')
    <a href="#" style="font-size:12px; color:#6b7280; text-decoration:none; padding:6px 10px; border:1px solid #e5e7eb; border-radius:6px;">⬇ Workload CSV</a>
    <a href="#" style="font-size:12px; color:#6b7280; text-decoration:none; padding:6px 10px; border:1px solid #e5e7eb; border-radius:6px;">⬇ Workload PDF</a>
@endsection

@section('content')
@php
$staffCards = [
    ['name'=>'Dr. Sarah Mitchell','dept'=>'Computer Science','slots'=>12,'hours'=>24,'courses'=>2,'status'=>'Active'],
    ['name'=>'Prof. James Okafor','dept'=>'Mathematics','slots'=>8,'hours'=>16,'courses'=>2,'status'=>'Active'],
    ['name'=>'Dr. Priya Nair','dept'=>'Physics','slots'=>10,'hours'=>20,'courses'=>1,'status'=>'Active'],
    ['name'=>'Dr. Amina Yusuf','dept'=>'Data Science','slots'=>6,'hours'=>12,'courses'=>1,'status'=>'Active'],
    ['name'=>'Mr. Tom Hargreaves','dept'=>'Software Engineering','slots'=>0,'hours'=>0,'courses'=>0,'status'=>'Inactive'],
];

$weeklySlots = [
    'Monday'    => [['time'=>'09:00–11:00','staff'=>'Dr. Sarah Mitchell','course'=>'CS101','room'=>'Hall A'],['time'=>'14:00–16:00','staff'=>'Prof. James Okafor','course'=>'MATH201','room'=>'Seminar 1']],
    'Tuesday'   => [['time'=>'10:00–12:00','staff'=>'Prof. James Okafor','course'=>'MATH101','room'=>'Hall B']],
    'Wednesday' => [['time'=>'14:00–16:00','staff'=>'Dr. Priya Nair','course'=>'PHY101','room'=>'Hall B']],
    'Thursday'  => [['time'=>'13:00–15:00','staff'=>'Dr. Amina Yusuf','course'=>'DS401','room'=>'Lab 1']],
    'Friday'    => [['time'=>'09:00–11:00','staff'=>'Dr. Sarah Mitchell','course'=>'CS301','room'=>'Lab 1']],
];
@endphp

{{-- Tabs --}}
<div style="display:flex; gap:0; border-bottom:2px solid #e5e7eb; margin-bottom:20px;" id="tabs">
    @foreach(['Staff Cards','Weekly Grid','Workload','Availability'] as $i => $tab)
    <button onclick="switchTab({{ $i }})" id="tab-{{ $i }}"
        style="padding:9px 18px; font-size:13px; font-weight:600; border:none; background:none; cursor:pointer; border-bottom:2px solid {{ $i===0 ? '#4f46e5' : 'transparent' }}; color:{{ $i===0 ? '#4f46e5' : '#6b7280' }}; margin-bottom:-2px;">
        {{ $tab }}
    </button>
    @endforeach
</div>

{{-- Tab 0: Staff Cards --}}
<div id="panel-0">
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:16px;">
        @foreach($staffCards as $s)
        <div class="card" style="padding:18px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                <div style="width:38px; height:38px; border-radius:50%; background:#e0e7ff; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:700; color:#4f46e5;">
                    {{ strtoupper(substr($s['name'], 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13px; font-weight:700; color:#1e1b4b;">{{ $s['name'] }}</div>
                    <div style="font-size:11px; color:#9ca3af;">{{ $s['dept'] }}</div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; text-align:center; margin-bottom:12px;">
                <div style="background:#f9fafb; border-radius:6px; padding:8px 4px;">
                    <div style="font-size:18px; font-weight:700; color:#4f46e5;">{{ $s['slots'] }}</div>
                    <div style="font-size:10px; color:#9ca3af;">Slots</div>
                </div>
                <div style="background:#f9fafb; border-radius:6px; padding:8px 4px;">
                    <div style="font-size:18px; font-weight:700; color:#059669;">{{ $s['hours'] }}</div>
                    <div style="font-size:10px; color:#9ca3af;">Hours</div>
                </div>
                <div style="background:#f9fafb; border-radius:6px; padding:8px 4px;">
                    <div style="font-size:18px; font-weight:700; color:#d97706;">{{ $s['courses'] }}</div>
                    <div style="font-size:10px; color:#9ca3af;">Courses</div>
                </div>
            </div>
            <span class="badge {{ $s['status']==='Active' ? 'badge-green' : 'badge-red' }}">{{ $s['status'] }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- Tab 1: Weekly Grid --}}
<div id="panel-1" style="display:none;">
    <div style="display:grid; grid-template-columns:repeat(5, 1fr); gap:12px;">
        @foreach($weeklySlots as $day => $daySlots)
        <div>
            <div style="font-size:12px; font-weight:700; color:#4f46e5; text-transform:uppercase; letter-spacing:.05em; margin-bottom:8px; padding-bottom:6px; border-bottom:2px solid #e0e7ff;">{{ $day }}</div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($daySlots as $slot)
                <div style="background:#fff; border:1px solid #e0e7ff; border-left:3px solid #4f46e5; border-radius:6px; padding:10px;">
                    <div style="font-size:11px; font-weight:700; color:#4f46e5;">{{ $slot['time'] }}</div>
                    <div style="font-size:12px; font-weight:600; margin-top:3px;">{{ $slot['course'] }}</div>
                    <div style="font-size:11px; color:#6b7280; margin-top:2px;">{{ $slot['staff'] }}</div>
                    <div style="font-size:11px; color:#9ca3af;">📍 {{ $slot['room'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Tab 2: Workload --}}
<div id="panel-2" style="display:none;">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Staff Member</th>
                    <th>Department</th>
                    <th>Total Slots</th>
                    <th>Total Hours</th>
                    <th>Courses</th>
                    <th>Workload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staffCards as $s)
                @php $pct = $s['hours'] > 0 ? min(100, round($s['hours'] / 30 * 100)) : 0; @endphp
                <tr>
                    <td style="font-weight:600;">{{ $s['name'] }}</td>
                    <td style="color:#6b7280;">{{ $s['dept'] }}</td>
                    <td style="font-weight:700; color:#4f46e5;">{{ $s['slots'] }}</td>
                    <td style="font-weight:700; color:#059669;">{{ $s['hours'] }}h</td>
                    <td>{{ $s['courses'] }}</td>
                    <td style="min-width:140px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="flex:1; height:6px; background:#e5e7eb; border-radius:9999px; overflow:hidden;">
                                <div style="height:100%; width:{{ $pct }}%; background:{{ $pct > 80 ? '#ef4444' : ($pct > 50 ? '#f59e0b' : '#4f46e5') }}; border-radius:9999px;"></div>
                            </div>
                            <span style="font-size:11px; color:#6b7280; width:30px;">{{ $pct }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Tab 3: Availability --}}
<div id="panel-3" style="display:none;">
    @php
    $days = ['Mon','Tue','Wed','Thu','Fri'];
    $times = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
    $busy = [
        'Dr. Sarah Mitchell'  => ['Mon-09:00','Mon-10:00','Fri-09:00','Fri-10:00'],
        'Prof. James Okafor'  => ['Tue-10:00','Tue-11:00','Mon-14:00','Mon-15:00'],
        'Dr. Priya Nair'      => ['Wed-14:00','Wed-15:00'],
        'Dr. Amina Yusuf'     => ['Thu-13:00','Thu-14:00'],
    ];
    $staffNames = array_keys($busy);
    @endphp
    <div style="overflow-x:auto;">
        <table style="min-width:700px;">
            <thead>
                <tr>
                    <th style="width:160px;">Staff</th>
                    @foreach($days as $d)
                        @foreach($times as $t)
                        <th style="font-size:10px; padding:6px 4px; text-align:center; min-width:36px;">
                            @if($loop->first) {{ $d }}<br> @endif
                            {{ substr($t,0,2) }}
                        </th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($staffNames as $name)
                <tr>
                    <td style="font-size:12px; font-weight:600;">{{ $name }}</td>
                    @foreach($days as $d)
                        @foreach($times as $t)
                        @php $key = $d.'-'.$t; $isBusy = in_array($key, $busy[$name]); @endphp
                        <td style="text-align:center; padding:4px;">
                            <div style="width:24px; height:24px; border-radius:4px; margin:auto; background:{{ $isBusy ? '#fee2e2' : '#dcfce7' }};"></div>
                        </td>
                        @endforeach
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="display:flex; gap:16px; margin-top:12px; font-size:12px; color:#6b7280;">
            <span><span style="display:inline-block; width:12px; height:12px; background:#dcfce7; border-radius:3px; margin-right:4px;"></span>Available</span>
            <span><span style="display:inline-block; width:12px; height:12px; background:#fee2e2; border-radius:3px; margin-right:4px;"></span>Busy</span>
        </div>
    </div>
</div>

<script>
function switchTab(idx) {
    [0,1,2,3].forEach(i => {
        document.getElementById('panel-'+i).style.display = i===idx ? 'block' : 'none';
        const t = document.getElementById('tab-'+i);
        t.style.borderBottomColor = i===idx ? '#4f46e5' : 'transparent';
        t.style.color = i===idx ? '#4f46e5' : '#6b7280';
    });
}
</script>
@endsection
