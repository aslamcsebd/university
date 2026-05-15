@extends('layouts.academic')
@section('title', 'Academic Timetable')
@section('heading', 'Academic Timetable')

@section('header-actions')
    <a href="#" style="font-size:12px; color:#6b7280; text-decoration:none; padding:6px 10px; border:1px solid #e5e7eb; border-radius:6px;">⬇ CSV</a>
    <a href="#" style="font-size:12px; color:#6b7280; text-decoration:none; padding:6px 10px; border:1px solid #e5e7eb; border-radius:6px;">⬇ ICS</a>
    <button class="btn btn-primary" onclick="openModal('modal-add')">+ New Slot</button>
@endsection

@section('content')
@php
$slots = [
    ['id'=>1,'semester'=>'Sem 1 2025 – BCS','dept'=>'Computer Science','staff'=>'Dr. Sarah Mitchell','subject_code'=>'CS101','subject_name'=>'Introduction to Programming','building'=>'BLK-A','room'=>'Lecture Hall A','room_label'=>'Floor G','day'=>'Monday','date'=>'2025-01-13','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>2,'semester'=>'Sem 1 2025 – BCS','dept'=>'Computer Science','staff'=>'Dr. Sarah Mitchell','subject_code'=>'CS101','subject_name'=>'Introduction to Programming','building'=>'BLK-A','room'=>'Lecture Hall A','room_label'=>'Floor G','day'=>'Monday','date'=>'2025-01-20','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>3,'semester'=>'Sem 1 2025 – BMATH','dept'=>'Mathematics','staff'=>'Prof. James Okafor','subject_code'=>'MATH101','subject_name'=>'Calculus I','building'=>'BLK-A','room'=>'Lecture Hall B','room_label'=>'Floor 1','day'=>'Tuesday','date'=>'2025-01-14','start'=>'10:00','end'=>'12:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>4,'semester'=>'Sem 1 2025 – BPHY','dept'=>'Physics','staff'=>'Dr. Priya Nair','subject_code'=>'PHY101','subject_name'=>'Physics Fundamentals','building'=>'BLK-A','room'=>'Lecture Hall B','room_label'=>'Floor 1','day'=>'Wednesday','date'=>'2025-01-15','start'=>'14:00','end'=>'16:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>5,'semester'=>'Sem 1 2025 – MDS','dept'=>'Data Science','staff'=>'Dr. Amina Yusuf','subject_code'=>'DS401','subject_name'=>'Machine Learning','building'=>'BLK-B','room'=>'Computer Lab 1','room_label'=>'Floor 2','day'=>'Thursday','date'=>'2025-01-16','start'=>'13:00','end'=>'15:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>6,'semester'=>'Sem 1 2025 – BCS','dept'=>'Computer Science','staff'=>'Dr. Sarah Mitchell','subject_code'=>'CS301','subject_name'=>'Database Systems','building'=>'BLK-B','room'=>'Computer Lab 1','room_label'=>'Floor 2','day'=>'Friday','date'=>'2025-01-17','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Cancelled'],
    ['id'=>7,'semester'=>'Sem 1 2025 – BMATH','dept'=>'Mathematics','staff'=>'Prof. James Okafor','subject_code'=>'MATH201','subject_name'=>'Linear Algebra','building'=>'ADM','room'=>'Seminar Room 1','room_label'=>'Floor 3','day'=>'Monday','date'=>'2025-01-13','start'=>'14:00','end'=>'16:00','recurrence'=>'Weekly','status'=>'Scheduled'],
];
$statusColor = ['Scheduled'=>'badge-blue','Cancelled'=>'badge-red','Completed'=>'badge-gray','Rescheduled'=>'badge-yellow'];
@endphp

{{-- Filters --}}
<div style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
    <select class="form-select" style="width:190px;"><option>All Semesters</option><option>Sem 1 2025 – BCS</option><option>Sem 1 2025 – BMATH</option><option>Sem 1 2025 – BPHY</option><option>Sem 1 2025 – MDS</option></select>
    <select class="form-select" style="width:160px;"><option>All Departments</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
    <select class="form-select" style="width:170px;"><option>All Staff</option><option>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option><option>Dr. Priya Nair</option><option>Dr. Amina Yusuf</option></select>
    <select class="form-select" style="width:130px;"><option>All Days</option><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option></select>
    <select class="form-select" style="width:130px;"><option>All Statuses</option><option>Scheduled</option><option>Cancelled</option></select>
    <input class="form-input" style="width:180px;" placeholder="Search subject / room…" type="text">
</div>

<div style="display:flex;gap:20px;align-items:flex-start;">

{{-- Left Tips --}}
<div style="width:230px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;">
    <div style="background:#1e1b4b;border-radius:12px;padding:18px;color:#fff;">
        <div style="font-size:13px;font-weight:700;margin-bottom:12px;">🖣️ Timetable Slots</div>
        <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0 0 10px;">Each <strong style="color:#fff;">slot</strong> is one scheduled class session — linking a Semester, Subject, Staff member and Room.</p>
        <p style="font-size:11px;color:#c7d2fe;line-height:1.6;margin:0;">Use the <strong style="color:#fff;">date range + days</strong> to auto-generate recurring weekly slots in one go.</p>
    </div>
    <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:16px;">
        <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:10px;">📊 Summary</div>
        @php
            $scheduled = count(array_filter($slots, fn($s) => $s['status']==='Scheduled'));
            $cancelled = count(array_filter($slots, fn($s) => $s['status']==='Cancelled'));
            $depts     = count(array_unique(array_column($slots,'dept')));
        @endphp
        @foreach([['Total Slots',count($slots),'#4f46e5'],['Scheduled',$scheduled,'#10b981'],['Cancelled',$cancelled,'#ef4444'],['Departments',$depts,'#f59e0b']] as [$l,$v,$c])
        <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:12px;color:#64748b;">{{ $l }}</span>
            <span style="font-size:15px;font-weight:800;color:{{ $c }};">{{ $v }}</span>
        </div>
        @endforeach
    </div>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:14px;">
        <div style="font-size:12px;font-weight:700;color:#065f46;margin-bottom:6px;">✅ How to create</div>
        <ol style="font-size:11px;color:#166534;line-height:1.8;margin:0;padding-left:16px;">
            <li>Select Department</li>
            <li>Select Semester</li>
            <li>Pick Staff + Subject</li>
            <li>Pick Building + Room</li>
            <li>Set date range + days</li>
        </ol>
    </div>
    <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:12px;padding:14px;">
        <div style="font-size:12px;font-weight:700;color:#854d0e;margin-bottom:6px;">⚠️ Note</div>
        <p style="font-size:11px;color:#92400e;line-height:1.6;margin:0;">Only <strong>Active</strong> semesters and <strong>Available</strong> rooms can be selected when creating slots.</p>
    </div>
</div>

{{-- Right Table --}}
<div style="flex:1;">
    <div style="padding:14px 20px; border-bottom:1px solid #e5e7eb;">
        <span style="font-size:16px; font-weight:700; color:#1e1b4b;">{{ count($slots) }} Timetable Slots</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Semester</th>
                <th>Staff</th>
                <th>Subject / Module</th>
                <th>Building / Room</th>
                <th>Day</th>
                <th>Date</th>
                <th>Time</th>
                <th>Recurrence</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($slots as $s)
            <tr>
                <td>
                    <div style="font-size:11px;font-weight:700;color:#4338ca;">{{ $s['semester'] }}</div>
                    <div style="font-size:10px;color:#94a3b8;">{{ $s['dept'] }}</div>
                </td>
                <td style="font-size:12px; font-weight:600;">{{ $s['staff'] }}</td>
                <td>
                    <div style="font-weight:800; font-size:12px; color:#4f46e5; font-family:monospace;">{{ $s['subject_code'] }}</div>
                    <div style="font-size:11px; color:#374151;">{{ $s['subject_name'] }}</div>
                </td>
                <td>
                    <div style="font-size:11px;font-weight:700;color:#64748b;font-family:monospace;">{{ $s['building'] }}</div>
                    <div style="font-size:12px; font-weight:600;">{{ $s['room'] }}</div>
                    <div style="font-size:11px; color:#9ca3af;">{{ $s['room_label'] }}</div>
                </td>
                <td style="font-size:12px;">{{ $s['day'] }}</td>
                <td style="font-size:12px; color:#6b7280;">{{ date('d M Y', strtotime($s['date'])) }}</td>
                <td style="font-size:12px; font-weight:600;">{{ $s['start'] }} – {{ $s['end'] }}</td>
                <td style="font-size:12px; color:#6b7280;">{{ $s['recurrence'] }}</td>
                <td><span class="badge {{ $statusColor[$s['status']] }}">{{ $s['status'] }}</span></td>
                <td>
                    <div style="display:flex; gap:5px;">
                        <button class="btn btn-secondary btn-sm" onclick="openModal('modal-edit')">Edit</button>
                        <button class="btn btn-secondary btn-sm" onclick="openModal('modal-log')" title="Change Log">📋</button>
                        <button class="btn btn-danger btn-sm">✕</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:12px 20px; border-top:1px solid #f3f4f6; font-size:16px; font-weight:700; color:#1e1b4b;">
        Showing {{ count($slots) }} Slots
    </div>
</div>{{-- end card --}}
</div>{{-- end right --}}
</div>{{-- end flex --}}

{{-- Add Slot Modal --}}
<div id="modal-add" data-modal style="display:none;" class="modal">
    <div class="modal-box modal-box-lg">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">New Timetable Slot</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Department <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Department —</option><option>Computer Science</option><option>Mathematics</option><option>Physics</option><option>Data Science</option></select>
                </div>
                <div>
                    <label class="form-label">Semester <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Semester —</option><option>Sem 1 2025 – Bachelor of CS (BCS)</option><option>Sem 1 2025 – Bachelor of Maths (BMATH)</option><option>Sem 1 2025 – Bachelor of Physics (BPHY)</option><option>Sem 1 2025 – Master of DS (MDS)</option></select>
                    <div style="font-size:11px;color:#94a3b8;margin-top:3px;">Only Active semesters shown.</div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Staff Member <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Staff —</option><option>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option><option>Dr. Priya Nair</option><option>Dr. Amina Yusuf</option></select>
                </div>
                <div>
                    <label class="form-label">Subject / Module <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Subject —</option><option>CS101 – Introduction to Programming</option><option>CS201 – Data Structures & Algorithms</option><option>CS301 – Database Systems</option><option>MATH101 – Calculus I</option><option>PHY101 – Physics Fundamentals</option><option>DS401 – Machine Learning</option></select>
                    <div style="font-size:11px;color:#94a3b8;margin-top:3px;">Subjects from selected semester.</div>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Building <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Building —</option><option>Block A (BLK-A)</option><option>Block B (BLK-B)</option><option>Block C (BLK-C)</option><option>Science Block (SCI)</option><option>Admin Block (ADM)</option></select>
                </div>
                <div>
                    <label class="form-label">Room <span style="color:#ef4444;">*</span></label>
                    <select class="form-select"><option>— Select Room —</option><option>Lecture Hall A (Cap: 120)</option><option>Lecture Hall B (Cap: 80)</option><option>Computer Lab 1 (Cap: 40)</option><option>Seminar Room 1 (Cap: 25)</option></select>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Class Start Date</label>
                    <input class="form-input" type="date">
                </div>
                <div>
                    <label class="form-label">Class End Date</label>
                    <input class="form-input" type="date">
                </div>
            </div>
            <div>
                <label class="form-label">Days of Week</label>
                <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:6px;" class="day-check">
                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
                    <label><input type="checkbox"> {{ $d }}</label>
                    @endforeach
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Start Time</label>
                    <input class="form-input" type="time" value="09:00">
                </div>
                <div>
                    <label class="form-label">End Time</label>
                    <input class="form-input" type="time" value="11:00">
                </div>
            </div>
            <div>
                <label class="form-label">Notes (optional)</label>
                <textarea class="form-input" rows="2" placeholder="Any notes…"></textarea>
            </div>
        </div>
        <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:6px; padding:10px 14px; margin-top:14px; font-size:12px; color:#0369a1;">
            💡 Slots will be created for each matching weekday within the date range.
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Create Slots</button>
        </div>
    </div>
</div>

{{-- Edit Slot Modal --}}
<div id="modal-edit" data-modal style="display:none;" class="modal">
    <div class="modal-box modal-box-lg">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">Edit Slot</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Semester</label>
                    <select class="form-select"><option selected>Sem 1 2025 – Bachelor of CS (BCS)</option><option>Sem 1 2025 – Bachelor of Maths (BMATH)</option></select>
                </div>
                <div>
                    <label class="form-label">Staff Member</label>
                    <select class="form-select"><option selected>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option></select>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Subject / Module</label>
                    <select class="form-select"><option selected>CS101 – Introduction to Programming</option><option>CS301 – Database Systems</option></select>
                </div>
                <div>
                    <label class="form-label">Building / Room</label>
                    <select class="form-select"><option selected>BLK-A / Lecture Hall A (120)</option><option>BLK-A / Lecture Hall B (80)</option></select>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Date</label>
                    <input class="form-input" type="date" value="2025-01-13">
                </div>
                <div>
                    <label class="form-label">Start Time</label>
                    <input class="form-input" type="time" value="09:00">
                </div>
                <div>
                    <label class="form-label">End Time</label>
                    <input class="form-input" type="time" value="11:00">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select"><option>Scheduled</option><option>Cancelled</option><option>Rescheduled</option></select>
                </div>
                <div>
                    <label class="form-label">Recurrence</label>
                    <select class="form-select"><option>Weekly</option><option>Fortnightly</option><option>One-off</option></select>
                </div>
            </div>
            <div>
                <label class="form-label">Notes</label>
                <textarea class="form-input" rows="2"></textarea>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</div>

{{-- Change Log Modal --}}
<div id="modal-log" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 16px;">Change Log — Slot #1</h2>
        @php
        $logs = [
            ['action'=>'Created','by'=>'Admin','at'=>'2025-01-05 09:12','note'=>'Initial slot creation'],
            ['action'=>'Updated','by'=>'Dr. Sarah Mitchell','at'=>'2025-01-08 14:30','note'=>'Room changed from Lab 2 to Lecture Hall A'],
            ['action'=>'Updated','by'=>'Admin','at'=>'2025-01-10 11:00','note'=>'Status set to Scheduled'],
        ];
        @endphp
        <div style="display:flex; flex-direction:column; gap:10px;">
            @foreach($logs as $log)
            <div style="padding:10px 14px; background:#f9fafb; border-radius:7px; border-left:3px solid #6366f1;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span style="font-size:12px; font-weight:700; color:#4f46e5;">{{ $log['action'] }}</span>
                    <span style="font-size:11px; color:#9ca3af;">{{ $log['at'] }}</span>
                </div>
                <div style="font-size:12px; color:#374151;">{{ $log['note'] }}</div>
                <div style="font-size:11px; color:#9ca3af; margin-top:2px;">by {{ $log['by'] }}</div>
            </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:flex-end; margin-top:20px;">
            <button class="btn btn-secondary" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>
@endsection
