@extends('layouts.academic')
@section('title', 'My Profile')
@section('heading', 'My Profile')

@section('header-actions')
    <button onclick="openModal('modal-edit-profile')" class="btn btn-primary">✏️ Edit Profile</button>
@endsection

@section('content')
@php
$staff = [
    'name'        => 'Dr. Sarah Mitchell',
    'id'          => 'STF-2019-0015',
    'designation' => 'Associate Professor',
    'dept'        => 'Computer Science',
    'email'       => 'sarah.mitchell@university.edu',
    'phone'       => '+1 (555) 234-5678',
    'dob'         => 'June 22, 1985',
    'gender'      => 'Female',
    'blood'       => 'A+',
    'address'     => '18 Oak Avenue, Springfield, IL 62702',
    'joined'      => 'Aug 15, 2019',
    'shift'       => 'Morning',
    'status'      => 'Active',
    'avatar'      => 'SM',
    'color'       => '#f59e0b',
    'bg'          => '#fef3c7',
    'classes'     => 4,
    'students'    => 120,
    'experience'  => '6 yrs',
];

$classes = [
    ['subject'=>'Data Structures',      'code'=>'CS201','batch'=>'2023','section'=>'A','students'=>32,'time'=>'Mon/Wed 9–10 AM',  'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['subject'=>'Database Systems',     'code'=>'CS301','batch'=>'2022','section'=>'B','students'=>28,'time'=>'Tue/Thu 11–12 PM', 'color'=>'#10b981','bg'=>'#d1fae5'],
    ['subject'=>'Software Engineering', 'code'=>'CS302','batch'=>'2022','section'=>'A','students'=>30,'time'=>'Fri 2–4 PM',       'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['subject'=>'Algorithms',           'code'=>'CS401','batch'=>'2021','section'=>'C','students'=>30,'time'=>'Mon/Wed 2–3 PM',   'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
];

$leaves = [
    ['type'=>'Medical',  'from'=>'Jul 05','to'=>'Jul 06','days'=>2,'status'=>'Approved'],
    ['type'=>'Casual',   'from'=>'Jun 20','to'=>'Jun 20','days'=>1,'status'=>'Approved'],
    ['type'=>'Personal', 'from'=>'May 10','to'=>'May 11','days'=>2,'status'=>'Rejected'],
];

$activity = [
    ['icon'=>'📝','text'=>'Marks submitted — CS201 Mid-Term',    'time'=>'Today, 10:30 AM',    'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['icon'=>'✅','text'=>'Attendance marked — CS301 Batch 2022', 'time'=>'Today, 09:00 AM',    'color'=>'#10b981','bg'=>'#d1fae5'],
    ['icon'=>'🏖️','text'=>'Leave approved — Medical (2 days)',   'time'=>'Jul 05, 2025',       'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['icon'=>'📋','text'=>'Assignment created — Binary Trees',    'time'=>'Jul 03, 2025',       'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['icon'=>'📅','text'=>'Exam schedule published — CS401',     'time'=>'Jun 28, 2025',       'color'=>'#f59e0b','bg'=>'#fef3c7'],
];
@endphp

{{-- Banner --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:28px 32px;margin-bottom:20px;display:flex;align-items:center;gap:24px;box-shadow:0 4px 20px rgba(79,70,229,.3);">
    <div style="position:relative;flex-shrink:0;">
        <div style="width:80px;height:80px;border-radius:50%;background:{{ $staff['bg'] }};display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:{{ $staff['color'] }};border:3px solid rgba(255,255,255,.35);">{{ $staff['avatar'] }}</div>
        <div style="position:absolute;bottom:2px;right:2px;width:16px;height:16px;border-radius:50%;background:#10b981;border:2px solid #1e1b4b;"></div>
    </div>
    <div style="flex:1;">
        <div style="font-size:22px;font-weight:800;color:#fff;">{{ $staff['name'] }}</div>
        <div style="font-size:12px;color:#a5b4fc;margin-top:3px;">{{ $staff['id'] }} · {{ $staff['designation'] }}</div>
        <div style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;">
            @foreach([['🏛️',$staff['dept']],['⏰',$staff['shift']],['📅','Joined '.$staff['joined']]] as $tag)
            <span style="font-size:11px;font-weight:600;padding:3px 10px;background:rgba(255,255,255,.12);color:#e0e7ff;border-radius:20px;">{{ $tag[0] }} {{ $tag[1] }}</span>
            @endforeach
        </div>
    </div>
    <div style="display:flex;gap:14px;flex-shrink:0;">
        @foreach([[$staff['classes'],'CLASSES'],[$staff['students'],'STUDENTS'],[$staff['experience'],'EXPERIENCE']] as $stat)
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:26px;font-weight:800;color:#fff;">{{ $stat[0] }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">{{ $stat[1] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Active Classes',  'value'=>$staff['classes'],  'icon'=>'📖','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Total Students',  'value'=>$staff['students'], 'icon'=>'👨🎓','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Leaves Taken',    'value'=>5,                  'icon'=>'🏖️','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Experience',      'value'=>$staff['experience'],'icon'=>'⭐','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)','sh'=>'rgba(139,92,246,.25)'],
    ] as $k)
    <div style="background:{{ $k['grad'] }};border-radius:14px;padding:18px 20px;color:#fff;box-shadow:0 4px 18px {{ $k['sh'] }};display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:26px;font-weight:800;line-height:1;">{{ $k['value'] }}</div>
            <div style="font-size:11px;font-weight:600;margin-top:3px;opacity:.9;">{{ $k['label'] }}</div>
        </div>
        <div style="font-size:30px;opacity:.55;">{{ $k['icon'] }}</div>
    </div>
    @endforeach
</div>

{{-- Row: Personal Info + Activity --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">👤 Personal Information</div>
        </div>
        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:11px;">
            @foreach([
                ['label'=>'Full Name',   'value'=>$staff['name'],        'icon'=>'👤'],
                ['label'=>'Staff ID',    'value'=>$staff['id'],          'icon'=>'🪪'],
                ['label'=>'Designation','value'=>$staff['designation'],  'icon'=>'💼'],
                ['label'=>'Department', 'value'=>$staff['dept'],         'icon'=>'🏛️'],
                ['label'=>'Email',      'value'=>$staff['email'],        'icon'=>'📧'],
                ['label'=>'Phone',      'value'=>$staff['phone'],        'icon'=>'📱'],
                ['label'=>'Date of Birth','value'=>$staff['dob'],        'icon'=>'🎂'],
                ['label'=>'Gender',     'value'=>$staff['gender'],       'icon'=>'⚧'],
                ['label'=>'Blood Group','value'=>$staff['blood'],        'icon'=>'🩸'],
                ['label'=>'Address',    'value'=>$staff['address'],      'icon'=>'📍'],
            ] as $row)
            <div style="display:flex;align-items:flex-start;gap:10px;">
                <div style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $row['icon'] }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">{{ $row['label'] }}</div>
                    <div style="font-size:12px;font-weight:600;color:#1e293b;margin-top:1px;">{{ $row['value'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Recent Activity --}}
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
                <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🕐 Recent Activity</div>
            </div>
            <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
                @foreach($activity as $act)
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:8px;background:{{ $act['bg'] }};display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;">{{ $act['icon'] }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:12px;font-weight:600;color:#1e293b;line-height:1.4;">{{ $act['text'] }}</div>
                        <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $act['time'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Leave History --}}
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🏖️ Leave History</div>
                <a href="/staff/apply-leave" class="btn btn-primary btn-sm">+ Apply</a>
            </div>
            <table>
                <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($leaves as $l)
                <tr>
                    <td style="font-weight:600;">{{ $l['type'] }}</td>
                    <td style="color:#64748b;">{{ $l['from'] }}</td>
                    <td style="color:#64748b;">{{ $l['to'] }}</td>
                    <td style="text-align:center;">{{ $l['days'] }}</td>
                    <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $l['status']==='Approved'?'#d1fae5':($l['status']==='Rejected'?'#fee2e2':'#fef3c7') }};color:{{ $l['status']==='Approved'?'#065f46':($l['status']==='Rejected'?'#991b1b':'#92400e') }};">{{ $l['status'] }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- My Classes --}}
<div class="card" style="padding:0;overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📖 My Classes This Semester</div>
        <a href="/routines/teacher-routines" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">Full Routine →</a>
    </div>
    <table>
        <thead><tr><th>Subject</th><th>Code</th><th>Batch</th><th>Section</th><th>Students</th><th>Schedule</th></tr></thead>
        <tbody>
        @foreach($classes as $c)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:7px;background:{{ $c['bg'] }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:{{ $c['color'] }};flex-shrink:0;">{{ substr($c['code'],0,2) }}</div>
                    <span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $c['subject'] }}</span>
                </div>
            </td>
            <td style="color:#6366f1;font-weight:700;">{{ $c['code'] }}</td>
            <td style="color:#64748b;">{{ $c['batch'] }}</td>
            <td><span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:{{ $c['bg'] }};color:{{ $c['color'] }};">{{ $c['section'] }}</span></td>
            <td style="text-align:center;font-weight:700;">{{ $c['students'] }}</td>
            <td style="color:#64748b;font-size:12px;">{{ $c['time'] }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Edit Modal --}}
<div id="modal-edit-profile" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">✏️ Edit Profile</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div><label class="form-label">Full Name</label><input class="form-input" value="{{ $staff['name'] }}"></div>
                <div><label class="form-label">Phone</label><input class="form-input" value="{{ $staff['phone'] }}"></div>
            </div>
            <div><label class="form-label">Email</label><input class="form-input" type="email" value="{{ $staff['email'] }}"></div>
            <div><label class="form-label">Address</label><textarea class="form-input" rows="2">{{ $staff['address'] }}</textarea></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Blood Group</label>
                    <select class="form-select">
                        @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                        <option {{ $bg === $staff['blood'] ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="form-label">Profile Photo</label><input type="file" accept="image/*" class="form-input" style="padding:5px;"></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">💾 Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
