@extends('layouts.academic')
@section('title', 'My Profile')
@section('heading', 'My Profile')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <button onclick="openModal('modal-edit-profile')" class="btn btn-primary">✏️ Edit Profile</button>
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
    // profile-specific extras
    'email'   => 'alex.johnson@university.edu',
    'phone'   => '+1 (555) 012-3456',
    'dob'     => 'March 14, 2003',
    'gender'  => 'Male',
    'blood'   => 'O+',
    'address' => '42 Maple Street, Springfield, IL 62701',
    'joined'  => 'Sep 01, 2023',
    'advisor' => 'Dr. Mitchell',
    'section' => 'Section A',
    'shift'   => 'Morning',
    'status'  => 'Active',
    'credits' => 72,
];

$subjects = [
    ['name'=>'Data Structures',     'code'=>'CS201',  'staff'=>'Dr. Mitchell',  'attendance'=>88,'grade'=>'A-','gp'=>3.7,'credits'=>3,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['name'=>'Calculus II',         'code'=>'MATH202','staff'=>'Prof. Okafor',  'attendance'=>92,'grade'=>'B+','gp'=>3.3,'credits'=>3,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['name'=>'Physics Lab',         'code'=>'PHY101', 'staff'=>'Dr. Nair',      'attendance'=>75,'grade'=>'B', 'gp'=>3.0,'credits'=>2,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['name'=>'Database Systems',    'code'=>'CS301',  'staff'=>'Dr. Yusuf',     'attendance'=>95,'grade'=>'A', 'gp'=>4.0,'credits'=>3,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['name'=>'Software Engineering','code'=>'CS302',  'staff'=>'Mr. Hargreaves','attendance'=>80,'grade'=>'B+','gp'=>3.3,'credits'=>3,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];

$fees = ['total'=>1200,'paid'=>900,'due'=>300,'dueDate'=>'Jul 31, 2025'];

$guardian = [
    'name'       => 'Robert Johnson',
    'relation'   => 'Father',
    'phone'      => '+1 (555) 098-7654',
    'email'      => 'robert.johnson@email.com',
    'occupation' => 'Engineer',
];

$activity = [
    ['icon'=>'✅','text'=>'Attendance marked — Data Structures',  'time'=>'Today, 09:15 AM',   'color'=>'#10b981','bg'=>'#d1fae5'],
    ['icon'=>'📋','text'=>'Assignment submitted — Binary Tree',    'time'=>'Yesterday, 11:40 PM','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['icon'=>'💳','text'=>'Fee payment received — $300',          'time'=>'Jul 10, 2025',      'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['icon'=>'📝','text'=>'Exam registered — Mid-Term CS201',     'time'=>'Jul 08, 2025',      'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['icon'=>'🏖️','text'=>'Leave approved — Medical (2 days)',    'time'=>'Jul 05, 2025',      'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['icon'=>'📚','text'=>'Library book issued — Clean Code',     'time'=>'Jul 03, 2025',      'color'=>'#ef4444','bg'=>'#fee2e2'],
];

$overallAtt = round(array_sum(array_column($subjects,'attendance')) / count($subjects));
$feePct     = round($fees['paid'] / $fees['total'] * 100);
@endphp

{{-- ① Profile Banner --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#4f46e5);border-radius:16px;padding:28px 32px;margin-bottom:20px;display:flex;align-items:center;gap:24px;box-shadow:0 4px 20px rgba(79,70,229,.3);">
    <div style="position:relative;flex-shrink:0;">
        <div style="width:80px;height:80px;border-radius:50%;background:{{ $student['bg'] }};display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:{{ $student['color'] }};border:3px solid rgba(255,255,255,.35);">{{ $student['avatar'] }}</div>
        <div style="position:absolute;bottom:2px;right:2px;width:16px;height:16px;border-radius:50%;background:#10b981;border:2px solid #1e1b4b;"></div>
    </div>
    <div style="flex:1;">
        <div style="font-size:22px;font-weight:800;color:#fff;">{{ $student['name'] }}</div>
        <div style="font-size:12px;color:#a5b4fc;margin-top:3px;">{{ $student['id'] }} · {{ $student['course'] }}</div>
        <div style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;">
            @foreach([['🏛️',$student['dept']],['📅',$student['semester']],['🎓',$student['batch']],['📍',$student['section']]] as $tag)
            <span style="font-size:11px;font-weight:600;padding:3px 10px;background:rgba(255,255,255,.12);color:#e0e7ff;border-radius:20px;">{{ $tag[0] }} {{ $tag[1] }}</span>
            @endforeach
        </div>
    </div>
    <div style="display:flex;gap:14px;flex-shrink:0;">
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:28px;font-weight:800;color:#fff;">{{ $student['gpa'] }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">CGPA</div>
        </div>
        <div style="text-align:center;background:rgba(255,255,255,.1);border-radius:12px;padding:14px 20px;">
            <div style="font-size:28px;font-weight:800;color:#fff;">{{ $student['credits'] }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:2px;">CREDITS</div>
        </div>
        <div style="text-align:center;background:rgba(16,185,129,.2);border-radius:12px;padding:14px 20px;">
            <div style="font-size:14px;font-weight:800;color:#6ee7b7;">✅ {{ $student['status'] }}</div>
            <div style="font-size:10px;color:#a5b4fc;font-weight:600;margin-top:6px;">Good Standing</div>
        </div>
    </div>
</div>

{{-- ② KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Enrolled Subjects','value'=>count($subjects),    'sub'=>'this semester',     'icon'=>'📖','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Avg Attendance',   'value'=>$overallAtt.'%',     'sub'=>'across all subjects','icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Fees Paid',        'value'=>'$'.$fees['paid'],   'sub'=>'of $'.$fees['total'].' total','icon'=>'💳','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)','sh'=>'rgba(139,92,246,.25)'],
        ['label'=>'Credits Earned',   'value'=>$student['credits'], 'sub'=>'of 120 required',   'icon'=>'⭐','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ③ Row 1: Personal Info + Academic Info + Guardian --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

    {{-- Personal Info --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">👤 Personal Information</div>
        </div>
        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:11px;">
            @foreach([
                ['label'=>'Full Name',   'value'=>$student['name'],   'icon'=>'👤'],
                ['label'=>'Student ID',  'value'=>$student['id'],     'icon'=>'🪪'],
                ['label'=>'Email',       'value'=>$student['email'],  'icon'=>'📧'],
                ['label'=>'Phone',       'value'=>$student['phone'],  'icon'=>'📱'],
                ['label'=>'Date of Birth','value'=>$student['dob'],   'icon'=>'🎂'],
                ['label'=>'Gender',      'value'=>$student['gender'], 'icon'=>'⚧'],
                ['label'=>'Blood Group', 'value'=>$student['blood'],  'icon'=>'🩸'],
                ['label'=>'Address',     'value'=>$student['address'],'icon'=>'📍'],
                ['label'=>'Joined',      'value'=>$student['joined'], 'icon'=>'📅'],
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

        {{-- Academic Info --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
                <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🎓 Academic Information</div>
            </div>
            <div style="padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:11px;">
                @foreach([
                    ['label'=>'Course',    'value'=>$student['course'],   'icon'=>'🎓'],
                    ['label'=>'Department','value'=>$student['dept'],     'icon'=>'🏢'],
                    ['label'=>'Semester',  'value'=>$student['semester'], 'icon'=>'📅'],
                    ['label'=>'Section',   'value'=>$student['section'],  'icon'=>'📍'],
                    ['label'=>'Batch',     'value'=>$student['batch'],    'icon'=>'🗓️'],
                    ['label'=>'Shift',     'value'=>$student['shift'],    'icon'=>'⏰'],
                    ['label'=>'Advisor',   'value'=>$student['advisor'],  'icon'=>'👨‍🏫'],
                    ['label'=>'CGPA',      'value'=>$student['gpa'],      'icon'=>'⭐'],
                ] as $row)
                <div style="display:flex;align-items:flex-start;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">{{ $row['icon'] }}</div>
                    <div>
                        <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">{{ $row['label'] }}</div>
                        <div style="font-size:11px;font-weight:600;color:#1e293b;margin-top:1px;">{{ $row['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Guardian Info --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
                <div style="font-size:14px;font-weight:700;color:#1e1b4b;">👨‍👩‍👦 Guardian Information</div>
            </div>
            <div style="padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:11px;">
                @foreach([
                    ['label'=>'Name',       'value'=>$guardian['name'],       'icon'=>'👤'],
                    ['label'=>'Relation',   'value'=>$guardian['relation'],   'icon'=>'🤝'],
                    ['label'=>'Phone',      'value'=>$guardian['phone'],      'icon'=>'📱'],
                    ['label'=>'Email',      'value'=>$guardian['email'],      'icon'=>'📧'],
                    ['label'=>'Occupation', 'value'=>$guardian['occupation'], 'icon'=>'💼'],
                ] as $row)
                <div style="display:flex;align-items:flex-start;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">{{ $row['icon'] }}</div>
                    <div>
                        <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">{{ $row['label'] }}</div>
                        <div style="font-size:11px;font-weight:600;color:#1e293b;margin-top:1px;">{{ $row['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- ④ Row 2: Semester Grades + Recent Activity --}}
<div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;margin-bottom:16px;">

    {{-- Grades --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📊 Current Semester Grades</div>
            <a href="/student/transcript" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">Full Transcript →</a>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th style="text-align:center;">Credits</th>
                        <th style="text-align:center;">Attendance</th>
                        <th style="text-align:center;">Grade</th>
                        <th style="text-align:center;">GP</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $sub)
                    @php
                        $attColor = $sub['attendance'] >= 85 ? '#10b981' : ($sub['attendance'] >= 75 ? '#f59e0b' : '#ef4444');
                        $gpPct    = round($sub['gp'] / 4.0 * 100);
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:28px;height:28px;border-radius:7px;background:{{ $sub['bg'] }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:{{ $sub['color'] }};flex-shrink:0;">{{ substr($sub['code'],0,2) }}</div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ $sub['name'] }}</div>
                                    <div style="font-size:10px;color:#94a3b8;">{{ $sub['staff'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align:center;font-size:12px;color:#64748b;">{{ $sub['credits'] }}</td>
                        <td style="text-align:center;font-size:12px;font-weight:700;color:{{ $attColor }};">{{ $sub['attendance'] }}%</td>
                        <td style="text-align:center;">
                            <span style="font-size:12px;font-weight:800;padding:2px 10px;border-radius:20px;background:{{ $sub['bg'] }};color:{{ $sub['color'] }};">{{ $sub['grade'] }}</span>
                        </td>
                        <td style="text-align:center;font-size:13px;font-weight:800;color:#1e293b;">{{ $sub['gp'] }}</td>
                        <td style="min-width:90px;">
                            <div style="height:6px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                                <div style="height:100%;width:{{ $gpPct }}%;background:{{ $sub['color'] }};border-radius:9999px;"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="background:#f8fafc;">
                        <td colspan="3" style="font-size:12px;font-weight:800;color:#1e1b4b;">Semester CGPA</td>
                        <td></td>
                        <td style="text-align:center;font-size:14px;font-weight:800;color:#6366f1;">{{ $student['gpa'] }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
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

</div>

{{-- ⑤ Fees Summary Bar --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">💳 Fees Summary</div>
        <a href="/student/fees-reports" style="font-size:11px;color:#6366f1;text-decoration:none;font-weight:600;">View Details →</a>
    </div>
    <div style="padding:16px 20px;display:flex;align-items:center;gap:24px;">
        <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;font-size:12px;font-weight:600;margin-bottom:6px;">
                <span style="color:#10b981;">✅ Paid: ${{ $fees['paid'] }}</span>
                <span style="color:#ef4444;">⚠ Due: ${{ $fees['due'] }} · {{ $fees['dueDate'] }}</span>
            </div>
            <div style="height:10px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                <div style="height:100%;width:{{ $feePct }}%;background:linear-gradient(90deg,#10b981,#34d399);border-radius:9999px;"></div>
            </div>
            <div style="font-size:10px;color:#94a3b8;margin-top:4px;">{{ $feePct }}% of ${{ $fees['total'] }} total paid</div>
        </div>
        <div style="text-align:center;background:#f8fafc;border-radius:10px;padding:12px 20px;flex-shrink:0;">
            <div style="font-size:22px;font-weight:800;color:#1e293b;">${{ $fees['total'] }}</div>
            <div style="font-size:10px;color:#94a3b8;margin-top:2px;">Total Fees</div>
        </div>
    </div>
</div>

{{-- ⑥ Edit Profile Modal --}}
<div id="modal-edit-profile" data-modal style="display:none;" class="modal">
    <div class="modal-box" style="max-width:520px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">✏️ Edit Profile</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div><label class="form-label">Full Name</label><input class="form-input" value="{{ $student['name'] }}"></div>
                <div><label class="form-label">Phone</label><input class="form-input" value="{{ $student['phone'] }}"></div>
            </div>
            <div><label class="form-label">Email</label><input class="form-input" type="email" value="{{ $student['email'] }}"></div>
            <div><label class="form-label">Address</label><textarea class="form-input" rows="2">{{ $student['address'] }}</textarea></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Blood Group</label>
                    <select class="form-select">
                        @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                        <option {{ $bg === $student['blood'] ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="form-label">Guardian Phone</label><input class="form-input" value="{{ $guardian['phone'] }}"></div>
            </div>
            <div><label class="form-label">Profile Photo</label><input type="file" accept="image/*" class="form-input" style="padding:5px;"></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">💾 Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
