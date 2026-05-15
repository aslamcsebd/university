<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Academic') — Timetable Module</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
        .badge { display:inline-flex; align-items:center; padding:2px 8px; border-radius:9999px; font-size:11px; font-weight:600; }
        .badge-green  { background:#dcfce7; color:#166534; }
        .badge-red    { background:#fee2e2; color:#991b1b; }
        .badge-yellow { background:#fef9c3; color:#854d0e; }
        .badge-blue   { background:#dbeafe; color:#1e40af; }
        .badge-gray   { background:#f3f4f6; color:#374151; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer; border:none; transition:background .15s; }
        .btn-primary { background:#4f46e5; color:#fff; }
        .btn-primary:hover { background:#4338ca; }
        .btn-secondary { background:#f3f4f6; color:#374151; border:1px solid #e5e7eb; }
        .btn-secondary:hover { background:#e5e7eb; }
        .btn-danger { background:#fee2e2; color:#991b1b; }
        .btn-danger:hover { background:#fecaca; }
        .btn-sm { padding:4px 10px; font-size:12px; }
        table { width:100%; border-collapse:collapse; }
        thead th { background:#1e1b4b; padding:12px 16px; text-align:left; font-size:14px; font-weight:800; color:#e0e7ff; letter-spacing:.05em; border-bottom:3px solid #4f46e5; white-space:nowrap; }
        tbody td { padding:11px 14px; font-size:13px; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
        tbody tr:hover { background:#fafafa; }
        .card { background:#fff; border-radius:10px; border:1px solid #e5e7eb; box-shadow:0 1px 3px rgba(0,0,0,.06); }
        .form-label { display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:4px; }
        .form-input { width:100%; padding:7px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; outline:none; }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 2px rgba(99,102,241,.15); }
        .form-select { width:100%; padding:7px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; }
        .modal { position:fixed; inset:0; z-index:50; display:flex; align-items:center; justify-content:center; }
        .modal-box { background:#fff; border-radius:12px; width:100%; max-width:520px; box-shadow:0 20px 60px rgba(0,0,0,.18); padding:28px; position:relative; z-index:51; }
        .modal-box-lg { max-width:680px; }
        .day-check label { display:flex; align-items:center; gap:6px; font-size:13px; cursor:pointer; }
    </style>
</head>
<body style="background:#f1f5f9; min-height:100vh;">

<div style="display:flex; min-height:100vh;">
    {{-- Sidebar --}}
    <aside style="width:220px; background:#1e1b4b; color:#fff; display:flex; flex-direction:column; flex-shrink:0;">
        <div style="padding:18px 20px 14px; border-bottom:1px solid rgba(255,255,255,.1);">
            <div style="font-size:11px; font-weight:700; letter-spacing:.1em; color:#a5b4fc; text-transform:uppercase;">Academic Module</div>
        </div>
        <nav style="flex:1; padding:12px 10px; display:flex; flex-direction:column; gap:2px;">
            @php
                $navItems = [
                    ['label'=>'Departments', 'icon'=>'🏛️', 'url'=>'/academic/departments'],
                    ['label'=>'Courses',     'icon'=>'🎓', 'url'=>'/academic/courses'],
                    ['label'=>'Subjects',    'icon'=>'📖', 'url'=>'/academic/subjects'],
                    ['label'=>'Semesters',   'icon'=>'📅', 'url'=>'/academic/semesters'],
                    ['label'=>'Buildings',   'icon'=>'🏢', 'url'=>'/academic/buildings'],
                    ['label'=>'Rooms',       'icon'=>'🏫', 'url'=>'/academic/rooms'],
                    ['label'=>'Staff',       'icon'=>'👤', 'url'=>'/academic/staff'],
                    ['label'=>'Timetable',   'icon'=>'🗓️', 'url'=>'/academic/timetable'],
                    ['label'=>'Overview',    'icon'=>'📊', 'url'=>'/academic/overview'],
                ];
                $path = request()->getPathInfo();
            @endphp
            @foreach($navItems as $item)
                @php $active = str_starts_with($path, $item['url']); @endphp
                <a href="{{ $item['url'] }}" style="display:flex; align-items:center; gap:9px; padding:9px 12px; border-radius:7px; font-size:13px; text-decoration:none; transition:background .15s;
                    {{ $active ? 'background:#4f46e5; color:#fff; font-weight:600;' : 'color:#c7d2fe;' }}"
                   onmouseover="{{ $active ? '' : "this.style.background='rgba(255,255,255,.08)'" }}"
                   onmouseout="{{ $active ? '' : "this.style.background=''" }}">
                    <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div style="padding:12px 20px; border-top:1px solid rgba(255,255,255,.1); font-size:11px; color:#a5b4fc; display:flex; flex-direction:column; gap:6px;">
            <span>{{ Auth::user()->name ?? 'Guest' }}</span>
            <a href="/dashboard" style="color:#818cf8; text-decoration:none;">← Dashboard</a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" style="background:none; border:none; color:#f87171; font-size:11px; cursor:pointer; padding:0;">Logout</button>
            </form>
        </div>
    </aside>

    {{-- Content --}}
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden;">
        <header style="background:#fff; border-bottom:1px solid #e5e7eb; padding:12px 24px; display:flex; align-items:center; justify-content:space-between;">
            <h1 style="font-size:16px; font-weight:700; color:#1e1b4b; margin:0;">@yield('heading')</h1>
            <div style="display:flex; align-items:center; gap:10px;">
                @yield('header-actions')
            </div>
        </header>
        <main style="flex:1; padding:24px; overflow-y:auto;">
            @yield('content')
        </main>
    </div>
</div>

{{-- Modal backdrop --}}
<div id="modal-backdrop" onclick="closeModal()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:40;"></div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.getElementById('modal-backdrop').style.display = 'block';
}
function closeModal() {
    document.querySelectorAll('[data-modal]').forEach(m => m.style.display = 'none');
    document.getElementById('modal-backdrop').style.display = 'none';
}
</script>
</body>
</html>
