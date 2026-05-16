@extends('layouts.academic')
@section('title', 'Apply Leaves')
@section('heading', 'Apply Leaves')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <button onclick="openModal('modal-apply')" class="btn btn-primary">+ Apply Leave</button>
@endsection

@section('content')
@php
$leaves = [
    ['id'=>'LV-001','type'=>'Medical',  'from'=>'Jun 10, 2025','to'=>'Jun 11, 2025','days'=>2,'reason'=>'Fever and flu, doctor advised rest','status'=>'Approved', 'applied'=>'Jun 09, 2025','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'LV-002','type'=>'Personal', 'from'=>'Jun 20, 2025','to'=>'Jun 20, 2025','days'=>1,'reason'=>'Family function attendance','status'=>'Approved', 'applied'=>'Jun 18, 2025','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'LV-003','type'=>'Medical',  'from'=>'Jul 03, 2025','to'=>'Jul 04, 2025','days'=>2,'reason'=>'Dental surgery follow-up appointment','status'=>'Pending',  'applied'=>'Jul 02, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'LV-004','type'=>'Emergency','from'=>'Jul 08, 2025','to'=>'Jul 08, 2025','days'=>1,'reason'=>'Family emergency — travel required','status'=>'Pending',  'applied'=>'Jul 07, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'LV-005','type'=>'Personal', 'from'=>'May 15, 2025','to'=>'May 15, 2025','days'=>1,'reason'=>'Personal work','status'=>'Rejected', 'applied'=>'May 14, 2025','color'=>'#ef4444','bg'=>'#fee2e2'],
];

$statusColors = [
    'Approved' => ['bg'=>'#d1fae5','color'=>'#065f46'],
    'Pending'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'Rejected' => ['bg'=>'#fee2e2','color'=>'#991b1b'],
];

$typeColors = [
    'Medical'   => ['bg'=>'#dbeafe','color'=>'#1e40af'],
    'Personal'  => ['bg'=>'#f5f3ff','color'=>'#5b21b6'],
    'Emergency' => ['bg'=>'#fee2e2','color'=>'#991b1b'],
];

$approved = count(array_filter($leaves, fn($l) => $l['status'] === 'Approved'));
$pending  = count(array_filter($leaves, fn($l) => $l['status'] === 'Pending'));
$rejected = count(array_filter($leaves, fn($l) => $l['status'] === 'Rejected'));
$totalDays = array_sum(array_column($leaves, 'days'));
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Applied', 'value'=>count($leaves),'sub'=>'this semester',  'icon'=>'📋','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Approved',      'value'=>$approved,     'sub'=>'leaves granted', 'icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Pending',       'value'=>$pending,      'sub'=>'awaiting review','icon'=>'⏳','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Total Days',    'value'=>$totalDays,    'sub'=>'days on leave',  'icon'=>'📅','grad'=>'linear-gradient(135deg,#8b5cf6,#a78bfa)','sh'=>'rgba(139,92,246,.25)'],
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

{{-- ② Leave Cards --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:16px;">
    @foreach($leaves as $leave)
    @php $sc = $statusColors[$leave['status']]; $tc = $typeColors[$leave['type']]; @endphp
    <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;border-top:4px solid {{ $leave['color'] }};box-shadow:0 2px 8px rgba(0,0,0,.05);padding:16px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#94a3b8;">{{ $leave['id'] }}</span>
            <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $leave['status'] }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <span style="font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $leave['type'] }}</span>
            <span style="font-size:11px;font-weight:700;color:{{ $leave['color'] }};">{{ $leave['days'] }} day{{ $leave['days']>1?'s':'' }}</span>
        </div>
        <div style="font-size:12px;color:#475569;margin-bottom:10px;line-height:1.5;">{{ $leave['reason'] }}</div>
        <div style="padding:10px 12px;background:#f8fafc;border-radius:9px;display:flex;flex-direction:column;gap:5px;">
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:10px;color:#94a3b8;">From</span>
                <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $leave['from'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:10px;color:#94a3b8;">To</span>
                <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $leave['to'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:10px;color:#94a3b8;">Applied</span>
                <span style="font-size:11px;color:#64748b;">{{ $leave['applied'] }}</span>
            </div>
        </div>
        @if($leave['status'] === 'Pending')
        <button style="margin-top:10px;width:100%;padding:7px;background:#fee2e2;color:#991b1b;border:none;border-radius:7px;font-size:11px;font-weight:700;cursor:pointer;">Cancel Request</button>
        @endif
    </div>
    @endforeach
</div>

{{-- ③ Leave History Table --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 Leave History</div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Applied On</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $leave)
                @php $sc = $statusColors[$leave['status']]; $tc = $typeColors[$leave['type']]; @endphp
                <tr>
                    <td style="font-size:12px;font-weight:700;color:#6366f1;">{{ $leave['id'] }}</td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $leave['type'] }}</span></td>
                    <td style="font-size:12px;color:#1e293b;white-space:nowrap;">{{ $leave['from'] }}</td>
                    <td style="font-size:12px;color:#1e293b;white-space:nowrap;">{{ $leave['to'] }}</td>
                    <td style="font-size:12px;font-weight:700;color:#6366f1;text-align:center;">{{ $leave['days'] }}</td>
                    <td style="font-size:12px;color:#64748b;max-width:200px;">{{ $leave['reason'] }}</td>
                    <td style="font-size:12px;color:#94a3b8;white-space:nowrap;">{{ $leave['applied'] }}</td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $leave['status'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ④ Apply Leave Modal --}}
<div id="modal-apply" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">🏖️ Apply for Leave</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label class="form-label">Leave Type</label>
                <select class="form-select">
                    <option>Medical</option>
                    <option>Personal</option>
                    <option>Emergency</option>
                </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-input">
                </div>
                <div>
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Reason</label>
                <textarea class="form-input" rows="3" placeholder="Describe your reason for leave..."></textarea>
            </div>
            <div>
                <label class="form-label">Supporting Document (optional)</label>
                <input type="file" class="form-input" style="padding:5px;">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>
@endsection
