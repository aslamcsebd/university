@extends('layouts.academic')
@section('title', 'Library')
@section('heading', 'Library')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
    <button onclick="openModal('modal-request')" class="btn btn-primary">+ Request Book</button>
@endsection

@section('content')
@php
$borrowed = [
    ['id'=>'LIB-001','title'=>'Introduction to Algorithms','author'=>'Cormen et al.','category'=>'Computer Science','issued'=>'Jun 20, 2025','due'=>'Jul 20, 2025','status'=>'Overdue', 'color'=>'#ef4444','bg'=>'#fee2e2'],
    ['id'=>'LIB-002','title'=>'Calculus: Early Transcendentals','author'=>'James Stewart','category'=>'Mathematics',     'issued'=>'Jul 01, 2025','due'=>'Jul 31, 2025','status'=>'Active',  'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'LIB-003','title'=>'Database System Concepts','author'=>'Silberschatz','category'=>'Computer Science','issued'=>'Jul 05, 2025','due'=>'Aug 05, 2025','status'=>'Active',  'color'=>'#10b981','bg'=>'#d1fae5'],
];

$history = [
    ['title'=>'Clean Code',                  'author'=>'Robert C. Martin','issued'=>'Mar 10, 2025','returned'=>'Apr 02, 2025','fine'=>0],
    ['title'=>'The Pragmatic Programmer',    'author'=>'Hunt & Thomas',   'issued'=>'Feb 01, 2025','returned'=>'Feb 28, 2025','fine'=>0],
    ['title'=>'Operating System Concepts',   'author'=>'Silberschatz',    'issued'=>'Jan 05, 2025','returned'=>'Jan 30, 2025','fine'=>0],
    ['title'=>'Discrete Mathematics',        'author'=>'Kenneth Rosen',   'issued'=>'Apr 10, 2025','returned'=>'May 15, 2025','fine'=>50],
];

$available = [
    ['title'=>'Design Patterns',             'author'=>'Gang of Four',    'category'=>'Computer Science','copies'=>3,'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['title'=>'Artificial Intelligence',     'author'=>'Russell & Norvig','category'=>'Computer Science','copies'=>2,'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['title'=>'Linear Algebra',              'author'=>'Gilbert Strang',  'category'=>'Mathematics',     'copies'=>4,'color'=>'#10b981','bg'=>'#d1fae5'],
    ['title'=>'Physics for Scientists',      'author'=>'Serway & Jewett', 'category'=>'Physics',         'copies'=>2,'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['title'=>'Software Architecture',       'author'=>'Richards & Ford', 'category'=>'Computer Science','copies'=>1,'color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['title'=>'Probability & Statistics',    'author'=>'Walpole et al.',  'category'=>'Mathematics',     'copies'=>3,'color'=>'#ec4899','bg'=>'#fce7f3'],
];

$totalBorrowed  = count($borrowed);
$overdue        = count(array_filter($borrowed, fn($b) => $b['status'] === 'Overdue'));
$totalFine      = array_sum(array_column($history, 'fine'));
$totalReturned  = count($history);
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Books Borrowed', 'value'=>$totalBorrowed,'sub'=>'currently held',   'icon'=>'📚','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Overdue Books',  'value'=>$overdue,      'sub'=>'return immediately','icon'=>'⚠️','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'Books Returned', 'value'=>$totalReturned,'sub'=>'this semester',    'icon'=>'✅','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'Total Fine',     'value'=>'$'.$totalFine,'sub'=>'accumulated',      'icon'=>'💰','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ② Currently Borrowed --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📖 Currently Borrowed</div>
        <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;background:#dbeafe;color:#1e40af;">{{ $totalBorrowed }} books</span>
    </div>
    <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
        @foreach($borrowed as $book)
        <div style="border:1.5px solid {{ $book['color'] }}33;border-top:4px solid {{ $book['color'] }};border-radius:12px;padding:16px;background:#fff;box-shadow:0 2px 8px {{ $book['color'] }}11;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:11px;font-weight:700;color:#94a3b8;">{{ $book['id'] }}</span>
                <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $book['bg'] }};color:{{ $book['color'] }};">{{ $book['status'] }}</span>
            </div>
            <div style="font-size:13px;font-weight:800;color:#1e293b;margin-bottom:3px;line-height:1.4;">{{ $book['title'] }}</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:12px;">{{ $book['author'] }}</div>
            <div style="padding:10px 12px;background:#f8fafc;border-radius:9px;display:flex;flex-direction:column;gap:5px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Category</span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $book['category'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Issued</span>
                    <span style="font-size:11px;font-weight:600;color:#1e293b;">{{ $book['issued'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:10px;color:#94a3b8;">Due Date</span>
                    <span style="font-size:11px;font-weight:700;color:{{ $book['color'] }};">{{ $book['due'] }}</span>
                </div>
            </div>
            @if($book['status'] === 'Overdue')
            <div style="margin-top:10px;padding:7px 10px;background:#fee2e2;border-radius:7px;text-align:center;font-size:10px;font-weight:700;color:#991b1b;">
                ⚠ Overdue — Return Immediately
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- ③ Available Books + Borrow History --}}
<div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;margin-bottom:16px;">

    {{-- Available Books --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🔍 Available Books</div>
            <input type="text" placeholder="Search books..." style="font-size:12px;padding:5px 10px;border:1px solid #e2e8f0;border-radius:7px;outline:none;width:160px;">
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th style="text-align:center;">Copies</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($available as $book)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:30px;height:30px;border-radius:7px;background:{{ $book['bg'] }};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">📗</div>
                                <span style="font-size:12px;font-weight:600;color:#1e293b;">{{ $book['title'] }}</span>
                            </div>
                        </td>
                        <td style="font-size:12px;color:#64748b;">{{ $book['author'] }}</td>
                        <td><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $book['bg'] }};color:{{ $book['color'] }};">{{ $book['category'] }}</span></td>
                        <td style="text-align:center;font-size:12px;font-weight:700;color:#10b981;">{{ $book['copies'] }}</td>
                        <td><button onclick="openModal('modal-request')" style="font-size:10px;font-weight:700;padding:4px 10px;background:#eef2ff;color:#6366f1;border:none;border-radius:6px;cursor:pointer;">Request</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Borrow History --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">🕓 Borrow History</div>
        </div>
        <div style="padding:14px 16px;display:flex;flex-direction:column;gap:10px;">
            @foreach($history as $h)
            <div style="padding:11px 13px;background:#f8fafc;border-radius:10px;border-left:3px solid {{ $h['fine']>0?'#ef4444':'#10b981' }};">
                <div style="font-size:12px;font-weight:700;color:#1e293b;">{{ $h['title'] }}</div>
                <div style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $h['author'] }}</div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                    <span style="font-size:10px;color:#64748b;">{{ $h['issued'] }} → {{ $h['returned'] }}</span>
                    @if($h['fine'] > 0)
                    <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:#fee2e2;color:#991b1b;">Fine ${{ $h['fine'] }}</span>
                    @else
                    <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:#d1fae5;color:#065f46;">No Fine</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ④ Book Request Modal --}}
<div id="modal-request" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">📚 Request a Book</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label class="form-label">Book Title</label>
                <input type="text" class="form-input" placeholder="Enter book title...">
            </div>
            <div>
                <label class="form-label">Author (optional)</label>
                <input type="text" class="form-input" placeholder="Enter author name...">
            </div>
            <div>
                <label class="form-label">Category</label>
                <select class="form-select">
                    <option>Computer Science</option>
                    <option>Mathematics</option>
                    <option>Physics</option>
                    <option>General</option>
                </select>
            </div>
            <div>
                <label class="form-label">Required By</label>
                <input type="date" class="form-input">
            </div>
            <div>
                <label class="form-label">Note (optional)</label>
                <textarea class="form-input" rows="2" placeholder="Any additional note..."></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>
@endsection
