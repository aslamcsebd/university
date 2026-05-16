@extends('layouts.academic')
@section('title', 'Assignments')
@section('heading', 'Assignments')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
@endsection

@section('content')
@php
$assignments = [
    ['id'=>'ASG-001','title'=>'Binary Tree Implementation',   'subject'=>'Data Structures',     'code'=>'CS201', 'staff'=>'Dr. Mitchell',  'assigned'=>'Jul 01, 2025','due'=>'Jul 15, 2025','marks'=>20,'obtained'=>null,'status'=>'Pending',  'priority'=>'High',  'desc'=>'Implement a binary search tree with insert, delete, search, and traversal operations in C++. Submit source code and a brief report.','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'ASG-002','title'=>'Integration Problems Set 3',   'subject'=>'Calculus II',          'code'=>'MATH202','staff'=>'Prof. Okafor',  'assigned'=>'Jul 03, 2025','due'=>'Jul 16, 2025','marks'=>15,'obtained'=>15, 'status'=>'Submitted','priority'=>'Normal','desc'=>'Solve all 10 integration problems from Chapter 7. Show complete working steps. Partial marks will be awarded for correct method even if final answer is wrong.','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'ASG-003','title'=>'Lab Report — Optics',          'subject'=>'Physics Lab',          'code'=>'PHY101', 'staff'=>'Dr. Nair',      'assigned'=>'Jul 05, 2025','due'=>'Jul 18, 2025','marks'=>25,'obtained'=>null,'status'=>'Pending',  'priority'=>'High',  'desc'=>'Write a detailed lab report for the optics experiment conducted on July 5. Include aim, apparatus, procedure, observations, calculations, and conclusion.','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'ASG-004','title'=>'ER Diagram Design',            'subject'=>'Database Systems',     'code'=>'CS301', 'staff'=>'Dr. Yusuf',     'assigned'=>'Jul 07, 2025','due'=>'Jul 20, 2025','marks'=>20,'obtained'=>null,'status'=>'Pending',  'priority'=>'Normal','desc'=>'Design an ER diagram for a hospital management system. Include all entities, relationships, cardinalities, and attributes. Submit as PDF.','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'ASG-005','title'=>'Use Case Diagram',             'subject'=>'Software Engineering', 'code'=>'CS302', 'staff'=>'Mr. Hargreaves','assigned'=>'Jun 20, 2025','due'=>'Jul 05, 2025','marks'=>15,'obtained'=>13, 'status'=>'Graded',   'priority'=>'Normal','desc'=>'Create a use case diagram for an online banking system. Identify all actors and use cases. Use standard UML notation.','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'ASG-006','title'=>'Sorting Algorithm Analysis',   'subject'=>'Data Structures',     'code'=>'CS201', 'staff'=>'Dr. Mitchell',  'assigned'=>'Jun 15, 2025','due'=>'Jun 30, 2025','marks'=>20,'obtained'=>18, 'status'=>'Graded',   'priority'=>'Normal','desc'=>'Analyze time and space complexity of bubble, merge, and quick sort. Provide empirical results with graphs comparing performance on different input sizes.','color'=>'#6366f1','bg'=>'#eef2ff'],
];

$statusColors = [
    'Pending'   => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'Submitted' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
    'Graded'    => ['bg'=>'#d1fae5','color'=>'#065f46'],
    'Late'      => ['bg'=>'#fee2e2','color'=>'#991b1b'],
];

$priorityColors = [
    'High'   => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'Normal' => ['bg'=>'#f1f5f9','color'=>'#475569'],
];

$pending   = count(array_filter($assignments, fn($a) => $a['status'] === 'Pending'));
$submitted = count(array_filter($assignments, fn($a) => $a['status'] === 'Submitted'));
$graded    = count(array_filter($assignments, fn($a) => $a['status'] === 'Graded'));
$totalMarks    = array_sum(array_filter(array_column($assignments, 'obtained')));
$totalPossible = array_sum(array_map(fn($a) => $a['obtained'] !== null ? $a['marks'] : 0, $assignments));
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Assignments','value'=>count($assignments),'sub'=>'this semester',  'icon'=>'📋','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Pending',          'value'=>$pending,           'sub'=>'need submission','icon'=>'⏳','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
        ['label'=>'Submitted',        'value'=>$submitted,         'sub'=>'awaiting grade', 'icon'=>'📤','grad'=>'linear-gradient(135deg,#0ea5e9,#38bdf8)','sh'=>'rgba(14,165,233,.25)'],
        ['label'=>'Avg Score',        'value'=>($totalPossible>0?round($totalMarks/$totalPossible*100).'%':'—'),'sub'=>'graded assignments','icon'=>'🎯','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
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

{{-- ② Pending Assignments --}}
@php $pendingList = array_filter($assignments, fn($a) => $a['status'] === 'Pending'); @endphp
@if(count($pendingList) > 0)
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">⏳ Pending Assignments</div>
        <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;background:#fef3c7;color:#92400e;">{{ count($pendingList) }} pending</span>
    </div>
    <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
        @foreach($pendingList as $asgn)
        @php $pc = $priorityColors[$asgn['priority']]; @endphp
        <div style="border:1.5px solid {{ $asgn['color'] }}33;border-top:4px solid {{ $asgn['color'] }};border-radius:12px;padding:16px;background:#fff;box-shadow:0 2px 8px {{ $asgn['color'] }}11;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:11px;font-weight:700;color:#94a3b8;">{{ $asgn['id'] }}</span>
                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $pc['bg'] }};color:{{ $pc['color'] }};">{{ $asgn['priority'] }}</span>
            </div>
            <div style="font-size:13px;font-weight:800;color:#1e293b;margin-bottom:3px;line-height:1.4;">{{ $asgn['title'] }}</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:10px;">{{ $asgn['subject'] }} · {{ $asgn['staff'] }}</div>
            <div style="font-size:11px;color:#475569;line-height:1.6;margin-bottom:12px;">{{ Str::limit($asgn['desc'], 90) }}</div>
            <div style="padding:10px 12px;background:#f8fafc;border-radius:9px;display:flex;flex-direction:column;gap:5px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Assigned</span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $asgn['assigned'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Due Date</span>
                    <span style="font-size:11px;font-weight:700;color:#ef4444;">{{ $asgn['due'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Total Marks</span>
                    <span style="font-size:11px;font-weight:700;color:{{ $asgn['color'] }};">{{ $asgn['marks'] }}</span>
                </div>
            </div>
            <button onclick="openModal('modal-submit-{{ $loop->index }}')" style="margin-top:10px;width:100%;padding:8px;background:{{ $asgn['color'] }};color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">📤 Submit Assignment</button>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ③ All Assignments Table --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📋 All Assignments</div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Assigned</th>
                    <th>Due Date</th>
                    <th style="text-align:center;">Marks</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $asgn)
                @php $sc = $statusColors[$asgn['status']]; $pc = $priorityColors[$asgn['priority']]; @endphp
                <tr>
                    <td style="font-size:12px;font-weight:700;color:#6366f1;">{{ $asgn['id'] }}</td>
                    <td>
                        <div style="font-size:12px;font-weight:600;color:#1e293b;">{{ $asgn['title'] }}</div>
                        <div style="font-size:10px;color:#94a3b8;margin-top:1px;">{{ $asgn['staff'] }}</div>
                    </td>
                    <td><span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $asgn['bg'] }};color:{{ $asgn['color'] }};">{{ $asgn['code'] }}</span></td>
                    <td style="font-size:12px;color:#64748b;white-space:nowrap;">{{ $asgn['assigned'] }}</td>
                    <td style="font-size:12px;font-weight:600;color:{{ $asgn['status']==='Pending'?'#ef4444':'#64748b' }};white-space:nowrap;">{{ $asgn['due'] }}</td>
                    <td style="text-align:center;">
                        @if($asgn['obtained'] !== null)
                        <span style="font-size:12px;font-weight:800;color:{{ $asgn['obtained']/$asgn['marks']>=0.8?'#10b981':'#f59e0b' }};">{{ $asgn['obtained'] }}/{{ $asgn['marks'] }}</span>
                        @else
                        <span style="font-size:12px;color:#94a3b8;">—/{{ $asgn['marks'] }}</span>
                        @endif
                    </td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $pc['bg'] }};color:{{ $pc['color'] }};">{{ $asgn['priority'] }}</span></td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $asgn['status'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ④ Submit Modals for each pending assignment --}}
@foreach($pendingList as $asgn)
<div id="modal-submit-{{ $loop->index }}" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">📤 Submit Assignment</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="padding:12px 14px;background:{{ $asgn['bg'] }};border-radius:10px;margin-bottom:16px;border-left:4px solid {{ $asgn['color'] }};">
            <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $asgn['title'] }}</div>
            <div style="font-size:11px;color:#64748b;margin-top:2px;">{{ $asgn['subject'] }} · Due {{ $asgn['due'] }} · {{ $asgn['marks'] }} marks</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label class="form-label">Upload File</label>
                <input type="file" class="form-input" style="padding:5px;">
                <div style="font-size:10px;color:#94a3b8;margin-top:4px;">Accepted: PDF, DOC, DOCX, ZIP (max 10MB)</div>
            </div>
            <div>
                <label class="form-label">Note to Instructor (optional)</label>
                <textarea class="form-input" rows="3" placeholder="Any note for your instructor..."></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary" style="background:{{ $asgn['color'] }};">Submit</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
