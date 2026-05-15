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
    ['id'=>1,'staff'=>'Dr. Sarah Mitchell','course_code'=>'CS101','course_name'=>'Introduction to Programming','room'=>'Lecture Hall A','room_label'=>'Block A / GF','day'=>'Monday','date'=>'2025-01-13','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>2,'staff'=>'Dr. Sarah Mitchell','course_code'=>'CS101','course_name'=>'Introduction to Programming','room'=>'Lecture Hall A','room_label'=>'Block A / GF','day'=>'Monday','date'=>'2025-01-20','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>3,'staff'=>'Prof. James Okafor','course_code'=>'MATH101','course_name'=>'Calculus I','room'=>'Lecture Hall B','room_label'=>'Block A / L1','day'=>'Tuesday','date'=>'2025-01-14','start'=>'10:00','end'=>'12:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>4,'staff'=>'Dr. Priya Nair','course_code'=>'PHY101','course_name'=>'Physics Fundamentals','room'=>'Lecture Hall B','room_label'=>'Block A / L1','day'=>'Wednesday','date'=>'2025-01-15','start'=>'14:00','end'=>'16:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>5,'staff'=>'Dr. Amina Yusuf','course_code'=>'DS401','course_name'=>'Machine Learning','room'=>'Computer Lab 1','room_label'=>'Block B / L2','day'=>'Thursday','date'=>'2025-01-16','start'=>'13:00','end'=>'15:00','recurrence'=>'Weekly','status'=>'Scheduled'],
    ['id'=>6,'staff'=>'Dr. Sarah Mitchell','course_code'=>'CS301','course_name'=>'Database Systems','room'=>'Computer Lab 1','room_label'=>'Block B / L2','day'=>'Friday','date'=>'2025-01-17','start'=>'09:00','end'=>'11:00','recurrence'=>'Weekly','status'=>'Cancelled'],
    ['id'=>7,'staff'=>'Prof. James Okafor','course_code'=>'MATH201','course_name'=>'Linear Algebra','room'=>'Seminar Room 1','room_label'=>'Admin / L3','day'=>'Monday','date'=>'2025-01-13','start'=>'14:00','end'=>'16:00','recurrence'=>'Weekly','status'=>'Scheduled'],
];
$statusColor = ['Scheduled'=>'badge-blue','Cancelled'=>'badge-red','Completed'=>'badge-gray','Rescheduled'=>'badge-yellow'];
@endphp

{{-- Filters --}}
<div style="display:flex; gap:10px; margin-bottom:16px; flex-wrap:wrap;">
    <select class="form-select" style="width:180px;"><option>All Terms</option><option>Semester 1 2025</option><option>Semester 2 2025</option></select>
    <select class="form-select" style="width:180px;"><option>All Staff</option><option>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option></select>
    <select class="form-select" style="width:160px;"><option>All Days</option><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option></select>
    <select class="form-select" style="width:150px;"><option>All Statuses</option><option>Scheduled</option><option>Cancelled</option></select>
    <input class="form-input" style="width:200px;" placeholder="Search course / room…" type="text">
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Staff</th>
                <th>Course / Module</th>
                <th>Room</th>
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
                <td style="font-size:12px; font-weight:600;">{{ $s['staff'] }}</td>
                <td>
                    <div style="font-weight:700; font-size:12px; color:#4f46e5; font-family:monospace;">{{ $s['course_code'] }}</div>
                    <div style="font-size:12px; color:#374151;">{{ $s['course_name'] }}</div>
                </td>
                <td>
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
    <div style="padding:12px 20px; border-top:1px solid #f3f4f6; font-size:12px; color:#9ca3af;">
        Showing {{ count($slots) }} slots
    </div>
</div>

{{-- Add Slot Modal --}}
<div id="modal-add" data-modal style="display:none;" class="modal">
    <div class="modal-box modal-box-lg">
        <h2 style="font-size:16px; font-weight:700; margin:0 0 20px;">New Timetable Slot</h2>
        <div style="display:grid; gap:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Organisation</label>
                    <select class="form-select"><option>Faculty of Engineering</option><option>Faculty of Science</option></select>
                </div>
                <div>
                    <label class="form-label">Term</label>
                    <select class="form-select"><option>Semester 1 2025</option><option>Semester 2 2025</option></select>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label class="form-label">Staff Member</label>
                    <select class="form-select"><option>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option><option>Dr. Priya Nair</option><option>Dr. Amina Yusuf</option></select>
                </div>
                <div>
                    <label class="form-label">Course / Module</label>
                    <select class="form-select"><option>CS101 – Introduction to Programming</option><option>MATH101 – Calculus I</option><option>PHY101 – Physics Fundamentals</option><option>DS401 – Machine Learning</option></select>
                </div>
            </div>
            <div>
                <label class="form-label">Room</label>
                <select class="form-select"><option>Lecture Hall A (Cap: 120)</option><option>Lecture Hall B (Cap: 80)</option><option>Computer Lab 1 (Cap: 40)</option><option>Seminar Room 1 (Cap: 25)</option></select>
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
                    <label class="form-label">Staff Member</label>
                    <select class="form-select"><option selected>Dr. Sarah Mitchell</option><option>Prof. James Okafor</option></select>
                </div>
                <div>
                    <label class="form-label">Course / Module</label>
                    <select class="form-select"><option selected>CS101 – Introduction to Programming</option><option>CS301 – Database Systems</option></select>
                </div>
            </div>
            <div>
                <label class="form-label">Room</label>
                <select class="form-select"><option selected>Lecture Hall A (Cap: 120)</option><option>Lecture Hall B (Cap: 80)</option></select>
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
