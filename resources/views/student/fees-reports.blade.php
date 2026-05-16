@extends('layouts.academic')
@section('title', 'Fees Reports')
@section('heading', 'Fees Reports')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <a href="#" style="font-size:12px;color:#6366f1;text-decoration:none;padding:7px 14px;border:1.5px solid #6366f1;border-radius:7px;font-weight:600;">⬇ Download Receipt</a>
@endsection

@section('content')
@php
$student = [
    'name'   => 'Alex Johnson',
    'id'     => 'STU-2025-0042',
    'course' => 'Bachelor of Computer Science',
    'sem'    => 'Semester 3',
];

$feeItems = [
    ['label'=>'Tuition Fee',     'amount'=>800,'due'=>'Jul 31, 2025','status'=>'Partial','paid'=>600],
    ['label'=>'Library Fee',     'amount'=>50, 'due'=>'Jul 31, 2025','status'=>'Paid',   'paid'=>50],
    ['label'=>'Lab Fee',         'amount'=>120,'due'=>'Jul 31, 2025','status'=>'Paid',   'paid'=>120],
    ['label'=>'Sports Fee',      'amount'=>30, 'due'=>'Jul 31, 2025','status'=>'Unpaid', 'paid'=>0],
    ['label'=>'Exam Fee',        'amount'=>80, 'due'=>'Aug 15, 2025','status'=>'Unpaid', 'paid'=>0],
    ['label'=>'Student ID Card', 'amount'=>20, 'due'=>'Jul 31, 2025','status'=>'Paid',   'paid'=>20],
];

$transactions = [
    ['id'=>'TXN-001','date'=>'Jan 15, 2025','method'=>'Online','amount'=>400,'desc'=>'Tuition Fee — Partial Payment','status'=>'Success'],
    ['id'=>'TXN-002','date'=>'Feb 02, 2025','method'=>'Cash',  'amount'=>50, 'desc'=>'Library Fee','status'=>'Success'],
    ['id'=>'TXN-003','date'=>'Feb 02, 2025','method'=>'Cash',  'amount'=>120,'desc'=>'Lab Fee','status'=>'Success'],
    ['id'=>'TXN-004','date'=>'Feb 02, 2025','method'=>'Cash',  'amount'=>20, 'desc'=>'Student ID Card','status'=>'Success'],
    ['id'=>'TXN-005','date'=>'Mar 10, 2025','method'=>'Online','amount'=>200,'desc'=>'Tuition Fee — Partial Payment','status'=>'Success'],
    ['id'=>'TXN-006','date'=>'Apr 05, 2025','method'=>'Online','amount'=>100,'desc'=>'Tuition Fee — Attempt','status'=>'Failed'],
];

$methodColors    = ['Online'=>['bg'=>'#dbeafe','color'=>'#1e40af'],'Cash'=>['bg'=>'#d1fae5','color'=>'#065f46']];
$txnStatusColors = ['Success'=>['bg'=>'#d1fae5','color'=>'#065f46'],'Failed'=>['bg'=>'#fee2e2','color'=>'#991b1b']];
$feeStatusColors = ['Paid'=>['bg'=>'#d1fae5','color'=>'#065f46'],'Partial'=>['bg'=>'#fef3c7','color'=>'#92400e'],'Unpaid'=>['bg'=>'#fee2e2','color'=>'#991b1b']];

$totalFees  = array_sum(array_column($feeItems, 'amount'));
$totalPaid  = array_sum(array_column($feeItems, 'paid'));
$totalDue   = $totalFees - $totalPaid;
$paidPct    = round($totalPaid / $totalFees * 100);
$challanRef = 'CHN-2025-'.$student['id'];
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Total Fees',   'value'=>'$'.$totalFees,       'sub'=>'this semester',    'icon'=>'💰','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Amount Paid',  'value'=>'$'.$totalPaid,       'sub'=>$paidPct.'% cleared','icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Amount Due',   'value'=>'$'.$totalDue,        'sub'=>'due Jul 31, 2025', 'icon'=>'⚠️','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'Transactions', 'value'=>count($transactions), 'sub'=>'this semester',    'icon'=>'🧾','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ② Progress + Breakdown --}}
<div style="display:grid;grid-template-columns:1fr 2fr;gap:16px;margin-bottom:16px;">

    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">💳 Payment Progress</div>
        </div>
        <div style="padding:20px;">
            <div style="text-align:center;margin-bottom:20px;">
                <div style="position:relative;display:inline-block;width:120px;height:120px;">
                    <svg width="120" height="120" style="transform:rotate(-90deg);">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#f1f5f9" stroke-width="10"/>
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#10b981" stroke-width="10"
                            stroke-dasharray="{{ round(314 * $paidPct / 100) }} 314" stroke-linecap="round"/>
                    </svg>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                        <div style="font-size:22px;font-weight:800;color:#1e293b;">{{ $paidPct }}%</div>
                        <div style="font-size:9px;color:#94a3b8;font-weight:600;">PAID</div>
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#d1fae5;border-radius:9px;">
                    <span style="font-size:12px;font-weight:600;color:#065f46;flex:1;text-align:left;">✅ Paid</span>
                    <span style="font-size:14px;font-weight:800;color:#065f46;">${{ $totalPaid }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#fee2e2;border-radius:9px;">
                    <span style="font-size:12px;font-weight:600;color:#991b1b;flex:1;text-align:left;">⚠ Due</span>
                    <span style="font-size:14px;font-weight:800;color:#991b1b;">${{ $totalDue }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#f1f5f9;border-radius:9px;">
                    <span style="font-size:12px;font-weight:600;color:#475569;flex:1;text-align:left;">💰 Total</span>
                    <span style="font-size:14px;font-weight:800;color:#1e293b;">${{ $totalFees }}</span>
                </div>
            </div>
        </div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🧾 Fee Breakdown</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Fee Item</th>
                        <th style="text-align:right;">Amount</th>
                        <th style="text-align:right;">Paid</th>
                        <th style="text-align:right;">Balance</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeItems as $item)
                    @php $sc = $feeStatusColors[$item['status']]; $balance = $item['amount'] - $item['paid']; @endphp
                    <tr>
                        <td style="font-size:12px;font-weight:600;color:#1e293b;">{{ $item['label'] }}</td>
                        <td style="text-align:right;font-size:12px;font-weight:700;color:#1e293b;">${{ $item['amount'] }}</td>
                        <td style="text-align:right;font-size:12px;font-weight:700;color:#10b981;">${{ $item['paid'] }}</td>
                        <td style="text-align:right;font-size:12px;font-weight:700;color:{{ $balance > 0 ? '#ef4444' : '#10b981' }};">${{ $balance }}</td>
                        <td style="font-size:11px;color:#94a3b8;white-space:nowrap;">{{ $item['due'] }}</td>
                        <td><span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $item['status'] }}</span></td>
                    </tr>
                    @endforeach
                    <tr style="background:#f8fafc;">
                        <td style="font-size:12px;font-weight:800;color:#1e1b4b;">Total</td>
                        <td style="text-align:right;font-size:13px;font-weight:800;color:#1e293b;">${{ $totalFees }}</td>
                        <td style="text-align:right;font-size:13px;font-weight:800;color:#10b981;">${{ $totalPaid }}</td>
                        <td style="text-align:right;font-size:13px;font-weight:800;color:#ef4444;">${{ $totalDue }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if($totalDue > 0)
        <div style="margin:12px 16px 16px;padding:12px 16px;background:linear-gradient(135deg,#fef2f2,#fee2e2);border-radius:10px;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-size:12px;font-weight:700;color:#991b1b;">⚠ Outstanding Balance: ${{ $totalDue }}</div>
                <div style="font-size:10px;color:#b91c1c;margin-top:2px;">Please clear dues before Jul 31, 2025 to avoid late fees.</div>
            </div>
            <button onclick="openModal('modal-challan')" class="btn btn-primary" style="background:#ef4444;white-space:nowrap;">Pay Now</button>
        </div>
        @endif
    </div>

</div>

{{-- ③ Transaction History --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🔄 Transaction History</div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Txn ID</th><th>Date</th><th>Description</th><th>Method</th><th style="text-align:right;">Amount</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $txn)
                @php $mc = $methodColors[$txn['method']]; $sc = $txnStatusColors[$txn['status']]; @endphp
                <tr>
                    <td style="font-size:12px;font-weight:700;color:#6366f1;">{{ $txn['id'] }}</td>
                    <td style="font-size:12px;color:#64748b;white-space:nowrap;">{{ $txn['date'] }}</td>
                    <td style="font-size:12px;color:#1e293b;">{{ $txn['desc'] }}</td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $mc['bg'] }};color:{{ $mc['color'] }};">{{ $txn['method'] }}</span></td>
                    <td style="text-align:right;font-size:13px;font-weight:800;color:{{ $txn['status']==='Success'?'#10b981':'#ef4444' }};">
                        {{ $txn['status']==='Success'?'+':'' }}${{ $txn['amount'] }}
                    </td>
                    <td><span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">{{ $txn['status'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ④ Challan Modal --}}
<div id="modal-challan" data-modal style="display:none;" class="modal">
    <div class="modal-box" style="max-width:480px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">🏦 Bank Payment Challan</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>

        <div style="border:2px dashed #6366f1;border-radius:12px;padding:20px;background:#fafafa;">
            <div style="text-align:center;margin-bottom:16px;padding-bottom:14px;border-bottom:1px dashed #e2e8f0;">
                <div style="font-size:16px;font-weight:800;color:#1e1b4b;">🎓 University of Excellence</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Fee Payment Challan — Semester 1 · 2025</div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;">
                @foreach([
                    ['Student Name', $student['name']],
                    ['Student ID',   $student['id']],
                    ['Course',       $student['course']],
                    ['Semester',     $student['sem']],
                    ['Challan Ref',  $challanRef],
                    ['Issue Date',   'Jul 13, 2025'],
                ] as $row)
                <div style="background:#fff;border-radius:7px;padding:8px 10px;border:1px solid #e2e8f0;">
                    <div style="font-size:9px;color:#94a3b8;font-weight:600;text-transform:uppercase;">{{ $row[0] }}</div>
                    <div style="font-size:11px;font-weight:700;color:#1e293b;margin-top:2px;">{{ $row[1] }}</div>
                </div>
                @endforeach
            </div>

            <div style="margin-bottom:14px;">
                <div style="font-size:11px;font-weight:700;color:#475569;margin-bottom:6px;">Outstanding Fees:</div>
                @foreach($feeItems as $item)
                @if($item['amount'] - $item['paid'] > 0)
                <div style="display:flex;justify-content:space-between;padding:6px 10px;background:#fff;border-radius:6px;border:1px solid #f1f5f9;margin-bottom:4px;">
                    <span style="font-size:11px;color:#475569;">{{ $item['label'] }}</span>
                    <span style="font-size:11px;font-weight:700;color:#ef4444;">${{ $item['amount'] - $item['paid'] }}</span>
                </div>
                @endif
                @endforeach
                <div style="display:flex;justify-content:space-between;padding:8px 10px;background:#1e1b4b;border-radius:8px;margin-top:6px;">
                    <span style="font-size:12px;font-weight:700;color:#e0e7ff;">Total Payable</span>
                    <span style="font-size:14px;font-weight:800;color:#fff;">${{ $totalDue }}</span>
                </div>
            </div>

            <div style="background:#eef2ff;border-radius:9px;padding:12px 14px;margin-bottom:14px;">
                <div style="font-size:11px;font-weight:700;color:#4338ca;margin-bottom:8px;">🏦 Bank Account Details</div>
                @foreach([
                    ['Bank Name',     'National Bank of Education'],
                    ['Account Title', 'University of Excellence'],
                    ['Account No.',   '1234-5678-9012-3456'],
                    ['Branch Code',   'NBE-0042'],
                    ['IBAN',          'PK36SCBL0000001123456702'],
                ] as $row)
                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:10px;color:#6366f1;font-weight:600;">{{ $row[0] }}</span>
                    <span style="font-size:10px;font-weight:700;color:#1e293b;">{{ $row[1] }}</span>
                </div>
                @endforeach
            </div>

            <div style="background:#fef3c7;border-radius:9px;padding:10px 12px;">
                <div style="font-size:10px;font-weight:700;color:#92400e;margin-bottom:4px;">📌 Instructions</div>
                <ul style="margin:0;padding-left:14px;display:flex;flex-direction:column;gap:3px;">
                    @foreach([
                        'Pay at any branch of National Bank of Education.',
                        'Use Challan Ref ('.$challanRef.') as payment reference.',
                        'Submit payment proof to the accounts office within 2 days.',
                        'Keep a copy of this challan for your records.',
                    ] as $inst)
                    <li style="font-size:10px;color:#78350f;">{{ $inst }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Actions: full width, text centered --}}
        <div style="display:flex;gap:10px;margin-top:16px;">
            <button onclick="window.print()" class="btn btn-secondary" style="flex:1;justify-content:center;">🖨 Print Challan</button>
            <button onclick="closeModal()" class="btn btn-primary" style="flex:1;justify-content:center;">Done</button>
        </div>
    </div>
</div>
@endsection
