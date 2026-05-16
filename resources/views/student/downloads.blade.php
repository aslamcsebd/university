@extends('layouts.academic')
@section('title', 'Downloads')
@section('heading', 'Downloads')

@section('header-actions')
    <span style="font-size:12px;color:#94a3b8;padding:6px 10px;">Semester 1 · 2025</span>
@endsection

@section('content')
@php
$files = [
    ['id'=>'DL-001','title'=>'Data Structures — Lecture Notes Week 1-4',  'subject'=>'CS201',  'type'=>'PDF', 'size'=>'2.4 MB','uploaded'=>'Jul 01, 2025','category'=>'Lecture Notes','staff'=>'Dr. Mitchell',  'color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'DL-002','title'=>'Calculus II — Formula Sheet',                'subject'=>'MATH202','type'=>'PDF', 'size'=>'0.8 MB','uploaded'=>'Jul 02, 2025','category'=>'Reference',    'staff'=>'Prof. Okafor',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'DL-003','title'=>'Physics Lab Manual — Semester 1',            'subject'=>'PHY101', 'type'=>'PDF', 'size'=>'5.1 MB','uploaded'=>'Jun 28, 2025','category'=>'Lab Manual',   'staff'=>'Dr. Nair',      'color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'DL-004','title'=>'Database Systems — ER Diagram Templates',    'subject'=>'CS301',  'type'=>'ZIP', 'size'=>'1.2 MB','uploaded'=>'Jul 05, 2025','category'=>'Templates',    'staff'=>'Dr. Yusuf',     'color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'DL-005','title'=>'Software Engineering — UML Slides',          'subject'=>'CS302',  'type'=>'PPTX','size'=>'8.3 MB','uploaded'=>'Jul 03, 2025','category'=>'Slides',       'staff'=>'Mr. Hargreaves','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'DL-006','title'=>'Mid-Term Exam Syllabus',                     'subject'=>'ALL',    'type'=>'PDF', 'size'=>'0.3 MB','uploaded'=>'Jul 08, 2025','category'=>'Exam',         'staff'=>'Admin',         'color'=>'#ef4444','bg'=>'#fee2e2'],
    ['id'=>'DL-007','title'=>'Academic Calendar 2025',                     'subject'=>'ALL',    'type'=>'PDF', 'size'=>'0.5 MB','uploaded'=>'Jan 01, 2025','category'=>'General',      'staff'=>'Admin',         'color'=>'#64748b','bg'=>'#f1f5f9'],
    ['id'=>'DL-008','title'=>'Software Engineering — Project Guidelines',  'subject'=>'CS302',  'type'=>'DOCX','size'=>'0.6 MB','uploaded'=>'Jul 06, 2025','category'=>'Guidelines',   'staff'=>'Mr. Hargreaves','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
];

$pastPapers = [
    ['id'=>'PP-001','subject'=>'Data Structures',     'code'=>'CS201',  'year'=>'2024','type'=>'Final',    'size'=>'1.2 MB','solved'=>true, 'uploaded_by'=>'Dr. Mitchell',  'uploaded'=>'Jan 10, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'PP-002','subject'=>'Data Structures',     'code'=>'CS201',  'year'=>'2024','type'=>'Mid-Term', 'size'=>'0.8 MB','solved'=>true, 'uploaded_by'=>'Dr. Mitchell',  'uploaded'=>'Jan 10, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'PP-003','subject'=>'Data Structures',     'code'=>'CS201',  'year'=>'2023','type'=>'Final',    'size'=>'1.1 MB','solved'=>false,'uploaded_by'=>'Ali Hassan',     'uploaded'=>'Mar 05, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'PP-004','subject'=>'Data Structures',     'code'=>'CS201',  'year'=>'2023','type'=>'Mid-Term', 'size'=>'0.7 MB','solved'=>true, 'uploaded_by'=>'Sara Khan',      'uploaded'=>'Mar 06, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'PP-005','subject'=>'Data Structures',     'code'=>'CS201',  'year'=>'2022','type'=>'Final',    'size'=>'1.0 MB','solved'=>false,'uploaded_by'=>'Ali Hassan',     'uploaded'=>'Apr 01, 2025','color'=>'#6366f1','bg'=>'#eef2ff'],
    ['id'=>'PP-006','subject'=>'Calculus II',          'code'=>'MATH202','year'=>'2024','type'=>'Final',    'size'=>'1.4 MB','solved'=>true, 'uploaded_by'=>'Prof. Okafor',  'uploaded'=>'Jan 12, 2025','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'PP-007','subject'=>'Calculus II',          'code'=>'MATH202','year'=>'2024','type'=>'Mid-Term', 'size'=>'0.9 MB','solved'=>true, 'uploaded_by'=>'Prof. Okafor',  'uploaded'=>'Jan 12, 2025','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'PP-008','subject'=>'Calculus II',          'code'=>'MATH202','year'=>'2023','type'=>'Final',    'size'=>'1.3 MB','solved'=>false,'uploaded_by'=>'Zara Ahmed',     'uploaded'=>'Feb 20, 2025','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'PP-009','subject'=>'Calculus II',          'code'=>'MATH202','year'=>'2023','type'=>'Mid-Term', 'size'=>'0.8 MB','solved'=>false,'uploaded_by'=>'Zara Ahmed',     'uploaded'=>'Feb 20, 2025','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ['id'=>'PP-010','subject'=>'Database Systems',     'code'=>'CS301',  'year'=>'2024','type'=>'Final',    'size'=>'1.0 MB','solved'=>true, 'uploaded_by'=>'Dr. Yusuf',     'uploaded'=>'Jan 15, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'PP-011','subject'=>'Database Systems',     'code'=>'CS301',  'year'=>'2024','type'=>'Mid-Term', 'size'=>'0.6 MB','solved'=>false,'uploaded_by'=>'Omar Farooq',   'uploaded'=>'Mar 10, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'PP-012','subject'=>'Database Systems',     'code'=>'CS301',  'year'=>'2023','type'=>'Final',    'size'=>'0.9 MB','solved'=>true, 'uploaded_by'=>'Omar Farooq',   'uploaded'=>'Mar 10, 2025','color'=>'#f59e0b','bg'=>'#fef3c7'],
    ['id'=>'PP-013','subject'=>'Software Engineering', 'code'=>'CS302',  'year'=>'2024','type'=>'Final',    'size'=>'1.1 MB','solved'=>false,'uploaded_by'=>'Mr. Hargreaves','uploaded'=>'Jan 18, 2025','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'PP-014','subject'=>'Software Engineering', 'code'=>'CS302',  'year'=>'2024','type'=>'Mid-Term', 'size'=>'0.7 MB','solved'=>true, 'uploaded_by'=>'Nadia Malik',   'uploaded'=>'Feb 28, 2025','color'=>'#8b5cf6','bg'=>'#f5f3ff'],
    ['id'=>'PP-015','subject'=>'Physics Lab',          'code'=>'PHY101', 'year'=>'2024','type'=>'Practical','size'=>'0.9 MB','solved'=>true, 'uploaded_by'=>'Dr. Nair',      'uploaded'=>'Jan 20, 2025','color'=>'#10b981','bg'=>'#d1fae5'],
    ['id'=>'PP-016','subject'=>'Physics Lab',          'code'=>'PHY101', 'year'=>'2023','type'=>'Practical','size'=>'0.8 MB','solved'=>false,'uploaded_by'=>'Bilal Raza',    'uploaded'=>'Apr 05, 2025','color'=>'#10b981','bg'=>'#d1fae5'],
];

$examTypeColors = [
    'Final'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'Mid-Term'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'Practical' => ['bg'=>'#fce7f3','color'=>'#9d174d'],
];

$typeIcons  = ['PDF'=>'📄','ZIP'=>'🗜️','PPTX'=>'📊','DOCX'=>'📝'];
$typeColors = [
    'PDF'  => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    'ZIP'  => ['bg'=>'#fef3c7','color'=>'#92400e'],
    'PPTX' => ['bg'=>'#fce7f3','color'=>'#9d174d'],
    'DOCX' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
];

$subjects   = array_unique(array_column($pastPapers, 'subject'));
$years      = array_unique(array_column($pastPapers, 'year'));
rsort($years);
$categories = array_unique(array_column($files, 'category'));
@endphp

{{-- ① KPI Strip --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Study Materials','value'=>count($files),      'sub'=>'notes & slides',   'icon'=>'📁','grad'=>'linear-gradient(135deg,#6366f1,#818cf8)','sh'=>'rgba(99,102,241,.25)'],
        ['label'=>'Past Papers',    'value'=>count($pastPapers), 'sub'=>'question papers',  'icon'=>'📝','grad'=>'linear-gradient(135deg,#ef4444,#f87171)','sh'=>'rgba(239,68,68,.25)'],
        ['label'=>'Subjects',       'value'=>count($subjects),   'sub'=>'with past papers', 'icon'=>'📖','grad'=>'linear-gradient(135deg,#10b981,#34d399)','sh'=>'rgba(16,185,129,.25)'],
        ['label'=>'New This Week',  'value'=>4,                  'sub'=>'recently added',   'icon'=>'🆕','grad'=>'linear-gradient(135deg,#f59e0b,#fbbf24)','sh'=>'rgba(245,158,11,.25)'],
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

{{-- ② Past Papers --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;margin-bottom:16px;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div>
            <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📝 Past Exam Papers</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Mid-Term · Final · Practical — contributed by staff & students</div>
        </div>
        <button onclick="openModal('modal-upload-paper')" class="btn btn-primary">⬆ Upload Paper</button>
    </div>

    {{-- Search & Filter --}}
    <div style="padding:12px 20px;background:#f8fafc;border-bottom:1px solid #f1f5f9;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        <input type="text" id="pp-search" oninput="filterPapers()" placeholder="🔍 Search subject, year, type..."
               style="font-size:12px;padding:6px 12px;border:1px solid #e2e8f0;border-radius:8px;outline:none;flex:1;min-width:180px;">
        <select id="pp-subject" onchange="filterPapers()" style="font-size:12px;padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;outline:none;background:#fff;">
            <option value="">All Subjects</option>
            @foreach($subjects as $sub)
            <option value="{{ $sub }}">{{ $sub }}</option>
            @endforeach
        </select>
        <select id="pp-year" onchange="filterPapers()" style="font-size:12px;padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;outline:none;background:#fff;">
            <option value="">All Years</option>
            @foreach($years as $yr)
            <option value="{{ $yr }}">{{ $yr }}</option>
            @endforeach
        </select>
        <select id="pp-type" onchange="filterPapers()" style="font-size:12px;padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;outline:none;background:#fff;">
            <option value="">All Types</option>
            <option value="Final">Final</option>
            <option value="Mid-Term">Mid-Term</option>
            <option value="Practical">Practical</option>
        </select>
        <select id="pp-solved" onchange="filterPapers()" style="font-size:12px;padding:6px 10px;border:1px solid #e2e8f0;border-radius:8px;outline:none;background:#fff;">
            <option value="">All</option>
            <option value="solved">Solved Only</option>
            <option value="unsolved">Unsolved Only</option>
        </select>
        <button onclick="resetPaperFilters()" style="font-size:11px;font-weight:600;padding:6px 12px;border-radius:8px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;cursor:pointer;">Reset</button>
    </div>

    {{-- Papers Card Grid --}}
    <div style="padding:16px 20px;">
        <div id="pp-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;">
            @foreach($pastPapers as $pp)
            @php $etc = $examTypeColors[$pp['type']]; @endphp
            <div class="pp-row" data-subject="{{ strtolower($pp['subject']) }}" data-year="{{ $pp['year'] }}" data-type="{{ $pp['type'] }}" data-solved="{{ $pp['solved'] ? 'solved' : 'unsolved' }}"
                 style="border:1px solid #e2e8f0;border-top:3px solid {{ $pp['color'] }};border-radius:10px;padding:14px;background:#fff;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <div style="width:36px;height:36px;border-radius:8px;background:{{ $pp['bg'] }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:{{ $pp['color'] }};flex-shrink:0;">{{ substr($pp['code'],0,2) }}</div>
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#1e293b;line-height:1.3;">{{ $pp['subject'] }}</div>
                        <div style="font-size:10px;color:#94a3b8;">{{ $pp['code'] }}</div>
                    </div>
                </div>
                <div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:8px;">
                    <span style="font-size:9px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $etc['bg'] }};color:{{ $etc['color'] }};">{{ $pp['type'] }}</span>
                    <span style="font-size:9px;font-weight:700;padding:2px 8px;border-radius:20px;background:#f1f5f9;color:#475569;">{{ $pp['year'] }}</span>
                    @if($pp['solved'])
                    <span style="font-size:9px;font-weight:700;padding:2px 8px;border-radius:20px;background:#d1fae5;color:#065f46;">✅ Solved</span>
                    @endif
                </div>
                <div style="font-size:10px;color:#94a3b8;margin-bottom:10px;">{{ $pp['uploaded_by'] }} · {{ $pp['size'] }}</div>
                <a href="#" style="display:flex;align-items:center;justify-content:center;gap:4px;width:100%;padding:6px;background:{{ $pp['color'] }};color:#fff;border-radius:7px;font-size:11px;font-weight:700;text-decoration:none;box-sizing:border-box;">⬇ Download</a>
            </div>
            @endforeach
        </div>
        <div id="pp-empty" style="display:none;padding:30px;text-align:center;color:#94a3b8;font-size:13px;">No papers found matching your filters.</div>
    </div>
</div>

{{-- ③ Study Materials --}}
<div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden;">
    <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div style="font-size:14px;font-weight:700;color:#1e1b4b;">📚 Study Materials</div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <button onclick="filterCat('all',this)" style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;background:#1e1b4b;color:#fff;border:none;cursor:pointer;">All</button>
            @foreach($categories as $cat)
            <button onclick="filterCat('{{ $cat }}',this)" style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;background:#f1f5f9;color:#475569;border:none;cursor:pointer;">{{ $cat }}</button>
            @endforeach
            <input type="text" id="dl-search" oninput="filterSearch()" placeholder="🔍 Search..." style="font-size:12px;padding:5px 10px;border:1px solid #e2e8f0;border-radius:8px;outline:none;width:140px;">
        </div>
    </div>
    <div id="file-grid" style="padding:16px 20px;display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        @foreach($files as $file)
        @php $tc = $typeColors[$file['type']]; $icon = $typeIcons[$file['type']]; @endphp
        <div class="dl-card" data-cat="{{ $file['category'] }}" data-title="{{ strtolower($file['title']) }}"
             style="border:1px solid #e2e8f0;border-top:3px solid {{ $file['color'] }};border-radius:10px;padding:14px;background:#fff;transition:box-shadow .2s;"
             onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'"
             onmouseout="this.style.boxShadow=''">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $file['bg'] }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $icon }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:11px;font-weight:700;color:#1e293b;line-height:1.4;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $file['title'] }}</div>
                </div>
            </div>
            <div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:8px;">
                <span style="font-size:9px;font-weight:700;padding:2px 6px;border-radius:20px;background:{{ $file['bg'] }};color:{{ $file['color'] }};">{{ $file['subject'] }}</span>
                <span style="font-size:9px;font-weight:700;padding:2px 6px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">{{ $file['type'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:9px;color:#94a3b8;margin-bottom:8px;">
                <span>{{ $file['uploaded'] }}</span>
                <span>{{ $file['size'] }}</span>
            </div>
            <a href="#" style="display:flex;align-items:center;justify-content:center;gap:4px;width:100%;padding:6px;background:{{ $file['color'] }};color:#fff;border-radius:7px;font-size:11px;font-weight:700;text-decoration:none;box-sizing:border-box;">⬇ Download</a>
        </div>
        @endforeach
    </div>
</div>

{{-- ④ Upload Past Paper Modal --}}
<div id="modal-upload-paper" data-modal style="display:none;" class="modal">
    <div class="modal-box">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:800;color:#1e1b4b;">⬆ Upload Past Paper</div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:18px;cursor:pointer;color:#94a3b8;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Subject</label>
                    <select class="form-select">
                        <option>Data Structures (CS201)</option>
                        <option>Calculus II (MATH202)</option>
                        <option>Physics Lab (PHY101)</option>
                        <option>Database Systems (CS301)</option>
                        <option>Software Engineering (CS302)</option>
                        <option>Other</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Exam Year</label>
                    <select class="form-select">
                        <option>2025</option>
                        <option>2024</option>
                        <option>2023</option>
                        <option>2022</option>
                        <option>2021</option>
                        <option>2020</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Exam Type</label>
                    <select class="form-select">
                        <option>Mid-Term</option>
                        <option>Final</option>
                        <option>Practical</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Is this a Solved Paper?</label>
                    <select class="form-select">
                        <option value="0">No — Question Paper Only</option>
                        <option value="1">Yes — Includes Solutions</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label">Upload File (PDF only, max 10MB)</label>
                <input type="file" accept=".pdf" class="form-input" style="padding:5px;">
            </div>
            <div>
                <label class="form-label">Note (optional)</label>
                <textarea class="form-input" rows="2" placeholder="e.g. This is from Prof. Smith's section, includes all questions..."></textarea>
            </div>
            <div style="padding:10px 12px;background:#fef3c7;border-radius:8px;font-size:11px;color:#92400e;">
                ⚠ Please only upload papers you have permission to share. Uploaded papers will be reviewed before being made public.
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary">⬆ Submit Paper</button>
            </div>
        </div>
    </div>
</div>

<script>
function filterPapers() {
    const q       = document.getElementById('pp-search').value.toLowerCase();
    const subject = document.getElementById('pp-subject').value;
    const year    = document.getElementById('pp-year').value;
    const type    = document.getElementById('pp-type').value;
    const solved  = document.getElementById('pp-solved').value;
    let visible   = 0;
    document.querySelectorAll('.pp-row').forEach(row => {
        const matchQ       = !q       || row.dataset.subject.includes(q) || row.dataset.year.includes(q) || row.dataset.type.toLowerCase().includes(q);
        const matchSubject = !subject || row.dataset.subject === subject.toLowerCase();
        const matchYear    = !year    || row.dataset.year === year;
        const matchType    = !type    || row.dataset.type === type;
        const matchSolved  = !solved  || row.dataset.solved === solved;
        const show = matchQ && matchSubject && matchYear && matchType && matchSolved;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('pp-empty').style.display = visible === 0 ? 'block' : 'none';
}
function resetPaperFilters() {
    ['pp-search','pp-subject','pp-year','pp-type','pp-solved'].forEach(id => {
        const el = document.getElementById(id);
        el.value = '';
    });
    filterPapers();
}
function filterCat(cat, btn) {
    document.querySelectorAll('.dl-card').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? 'block' : 'none';
    });
    document.querySelectorAll('[onclick^="filterCat"]').forEach(b => {
        b.style.background = '#f1f5f9'; b.style.color = '#475569';
    });
    btn.style.background = '#1e1b4b'; btn.style.color = '#fff';
}
function filterSearch() {
    const q = document.getElementById('dl-search').value.toLowerCase();
    document.querySelectorAll('.dl-card').forEach(card => {
        card.style.display = card.dataset.title.includes(q) ? 'block' : 'none';
    });
}
</script>
@endsection
