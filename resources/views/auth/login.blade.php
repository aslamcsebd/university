<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — {{ config('app.name', 'University ERP') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ─── PAGE ─────────────────────────────────────────────── */
        body {
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            background: #e8f0fe;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            position: relative;
            overflow: hidden;
        }

        /* ─── ANIMATED BG ──────────────────────────────────────── */
        .bg-wrap {
            position: fixed;
            inset: 0;
            z-index: 0;
            /* bright, airy gradient */
            background: linear-gradient(160deg, #dbeafe 0%, #ede9fe 35%, #e0f2fe 65%, #dcfce7 100%);
        }

        /* soft drifting blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            animation: blobDrift ease-in-out infinite alternate;
        }
        .blob-1 { width:520px; height:520px; background:#bfdbfe; opacity:.7; top:-160px; left:-120px; animation-duration:14s; }
        .blob-2 { width:420px; height:420px; background:#ddd6fe; opacity:.6; top:30%;   right:-140px; animation-duration:18s; animation-delay:-6s; }
        .blob-3 { width:380px; height:380px; background:#bae6fd; opacity:.6; bottom:-120px; left:25%; animation-duration:16s; animation-delay:-4s; }
        .blob-4 { width:260px; height:260px; background:#bbf7d0; opacity:.5; top:15%;   left:55%; animation-duration:20s; animation-delay:-10s; }

        @keyframes blobDrift {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(35px,25px) scale(1.08); }
        }

        /* moving grid */
        .grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.06) 1px, transparent 1px);
            background-size: 56px 56px;
            animation: gridMove 25s linear infinite;
        }
        @keyframes gridMove {
            to { background-position: 56px 56px, 56px 56px; }
        }

        /* floating dots */
        .dot {
            position: absolute;
            border-radius: 50%;
            animation: dotFloat linear infinite;
            opacity: 0;
        }
        @keyframes dotFloat {
            0%   { opacity:0; transform:translateY(0) scale(.8); }
            15%  { opacity:1; }
            85%  { opacity:.5; }
            100% { opacity:0; transform:translateY(-120px) scale(1.1); }
        }

        /* ─── PAGE WRAPPER ─────────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ─── HEADER ───────────────────────────────────────────── */
        .header {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-box {
            width: 62px; height: 62px;
            border-radius: 20px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 10px 36px rgba(99,102,241,.38);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 1.55rem;
            font-weight: 800;
            color: #1e1b4b;
            letter-spacing: -.5px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: .85rem;
            color: #64748b;
        }

        /* ─── MAIN CARD ────────────────────────────────────────── */
        .card {
            width: 100%;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid rgba(99,102,241,.12);
            box-shadow:
                0 4px 6px rgba(0,0,0,.04),
                0 20px 60px rgba(99,102,241,.14),
                0 0 0 1px rgba(255,255,255,.8) inset;
            overflow: hidden;
        }

        /* ─── DEPT SECTION ─────────────────────────────────────── */
        .dept-section {
            padding: 24px 24px 20px;
            background: #f8faff;
            border-bottom: 1px solid #e8edf8;
        }
        .dept-title {
            text-align: center;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        /* ─── 6-COL GRID ───────────────────────────────────────── */
        .dept-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .dept-card {
            position: relative;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            background: #ffffff;
            padding: 14px 6px 12px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
            user-select: none;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .dept-card:hover {
            border-color: #c7d2fe;
            background: #f5f3ff;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(99,102,241,.14);
        }

        /* active states */
        .dept-card.a-indigo  { border-color:#818cf8; background:#eef2ff; box-shadow:0 0 0 3px rgba(129,140,248,.2), 0 8px 24px rgba(99,102,241,.18); transform:translateY(-3px); }
        .dept-card.a-emerald { border-color:#34d399; background:#ecfdf5; box-shadow:0 0 0 3px rgba(52,211,153,.2),  0 8px 24px rgba(16,185,129,.18); transform:translateY(-3px); }
        .dept-card.a-amber   { border-color:#fbbf24; background:#fffbeb; box-shadow:0 0 0 3px rgba(251,191,36,.2),  0 8px 24px rgba(245,158,11,.18); transform:translateY(-3px); }
        .dept-card.a-rose    { border-color:#fb7185; background:#fff1f2; box-shadow:0 0 0 3px rgba(251,113,133,.2), 0 8px 24px rgba(244,63,94,.18);  transform:translateY(-3px); }
        .dept-card.a-violet  { border-color:#a78bfa; background:#f5f3ff; box-shadow:0 0 0 3px rgba(167,139,250,.2), 0 8px 24px rgba(139,92,246,.18); transform:translateY(-3px); }
        .dept-card.a-sky     { border-color:#38bdf8; background:#f0f9ff; box-shadow:0 0 0 3px rgba(56,189,248,.2),  0 8px 24px rgba(14,165,233,.18); transform:translateY(-3px); }

        /* tick */
        .tick {
            position: absolute;
            top: 7px; right: 7px;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transform: scale(.4);
            transition: opacity .2s, transform .2s;
        }
        .dept-card[class*=" a-"] .tick,
        .dept-card[class$=" a-indigo"] .tick,
        .dept-card.a-indigo .tick,
        .dept-card.a-emerald .tick,
        .dept-card.a-amber .tick,
        .dept-card.a-rose .tick,
        .dept-card.a-violet .tick,
        .dept-card.a-sky .tick { opacity:1; transform:scale(1); }

        .dept-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            transition: transform .2s;
        }
        .dept-card:hover .dept-icon,
        .dept-card[class*="a-"] .dept-icon { transform: scale(1.08); }

        .dept-name strong {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            line-height: 1.3;
        }
        .dept-name span {
            display: block;
            font-size: .6rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 1px;
        }

        /* ─── BANNER ───────────────────────────────────────────── */
        .dept-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 24px;
            background: #f0f4ff;
            border-bottom: 1px solid #e2e8f0;
            transition: background .25s;
        }
        .banner-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
            transition: background .25s;
        }
        .banner-label {
            font-size: .84rem;
            font-weight: 600;
            color: #1e293b;
        }
        .banner-hint {
            margin-left: auto;
            font-size: .7rem;
            color: #cbd5e1;
        }

        /* ─── FORM ─────────────────────────────────────────────── */
        .form-section { padding: 24px; }

        .fields-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .field-label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #0f172a;
            font-size: .88rem;
            font-family: inherit;
            outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
        }
        .form-input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129,140,248,.18);
            background: #fff;
        }
        .form-input::placeholder { color: #cbd5e1; }

        .pw-wrap { position: relative; }
        .pw-wrap .form-input { padding-right: 44px; }
        .eye-btn {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; padding: 4px;
            transition: color .15s;
            display: flex; align-items: center;
        }
        .eye-btn:hover { color: #4f46e5; }

        .row-between {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .remember-label {
            display: inline-flex; align-items: center;
            gap: 7px; cursor: pointer;
            font-size: .82rem; color: #64748b;
            user-select: none;
        }
        .remember-label input { accent-color:#4f46e5; width:14px; height:14px; cursor:pointer; }
        .forgot-link { font-size:.82rem; color:#4f46e5; text-decoration:none; }
        .forgot-link:hover { text-decoration:underline; }

        /* submit */
        .btn-submit {
            width: 100%;
            display: flex; align-items: center; justify-content: center;
            gap: 8px; padding: 12px;
            border-radius: 13px;
            border: none; cursor: pointer;
            font-family: inherit; font-size: .9rem; font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #4338ca, #4f46e5, #6366f1);
            box-shadow: 0 4px 20px rgba(99,102,241,.4);
            transition: transform .15s, box-shadow .15s, opacity .15s;
            letter-spacing: .01em;
        }
        .btn-submit:hover  { transform:translateY(-1px); box-shadow:0 6px 28px rgba(99,102,241,.5); }
        .btn-submit:active { transform:translateY(0); opacity:.95; }

        /* hint */
        .hint {
            text-align: center;
            font-size: .7rem;
            color: #94a3b8;
            margin-top: 16px;
            line-height: 1.8;
        }
        .hint code {
            font-family: 'Figtree', monospace;
            font-size: .72rem;
            color: #4f46e5;
            background: #eef2ff;
            padding: 1px 6px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: .7rem;
            color: #94a3b8;
            text-align: center;
        }

        .err { font-size:.72rem; color:#ef4444; margin-top:5px; }
    </style>
</head>
<body>

{{-- ─── ANIMATED BACKGROUND ─────────────────────── --}}
<div class="bg-wrap">
    <div class="grid-lines"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="blob blob-4"></div>
    <canvas id="dots" style="position:absolute;inset:0;width:100%;height:100%;"></canvas>
</div>

{{-- ─── CONTENT ──────────────────────────────────── --}}
<div class="page-wrap">

    {{-- Header --}}
    <div class="header">
        <div class="logo-box">
            <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <h1>University ERP</h1>
        <p>Select your department and sign in</p>
    </div>

    {{-- Card --}}
    <div class="card">

        {{-- Dept grid --}}
        <div class="dept-section">
            <p class="dept-title">Choose Department</p>
            <div class="dept-grid" id="dept-grid">

                {{-- Student --}}
                <div class="dept-card"
                     data-dept="student" data-ac="a-indigo"
                     data-email="student@university.com" data-pw="Aa@123456"
                     data-to="{{ route('students.index') }}"
                     data-label="Student Management"
                     data-dot="#6366f1" data-bg="#f0f4ff"
                     data-btn="linear-gradient(135deg,#4338ca,#6366f1)"
                     data-shadow="rgba(99,102,241,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#4f46e5">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#eef2ff">
                        <svg width="20" height="20" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Student</strong><span>Management</span></div>
                </div>

                {{-- Admission --}}
                <div class="dept-card"
                     data-dept="admission" data-ac="a-emerald"
                     data-email="admission@university.com" data-pw="Aa@123456"
                     data-to="{{ route('admissions.index') }}"
                     data-label="Admission Management"
                     data-dot="#10b981" data-bg="#f0fdf4"
                     data-btn="linear-gradient(135deg,#047857,#10b981)"
                     data-shadow="rgba(16,185,129,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#059669">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#d1fae5">
                        <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Admission</strong><span>Management</span></div>
                </div>

                {{-- Accounting --}}
                <div class="dept-card"
                     data-dept="accounting" data-ac="a-amber"
                     data-email="accounting@university.com" data-pw="Aa@123456"
                     data-to="{{ route('finance.overview') }}"
                     data-label="Accounting Management"
                     data-dot="#d97706" data-bg="#fffbeb"
                     data-btn="linear-gradient(135deg,#b45309,#f59e0b)"
                     data-shadow="rgba(245,158,11,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#d97706">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#fef3c7">
                        <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Accounting</strong><span>Management</span></div>
                </div>

                {{-- Examination --}}
                <div class="dept-card"
                     data-dept="examination" data-ac="a-rose"
                     data-email="examination@university.com" data-pw="Aa@123456"
                     data-to="{{ route('results.index') }}"
                     data-label="Examination Management"
                     data-dot="#e11d48" data-bg="#fff1f2"
                     data-btn="linear-gradient(135deg,#be123c,#f43f5e)"
                     data-shadow="rgba(244,63,94,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#e11d48">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#ffe4e6">
                        <svg width="20" height="20" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Examination</strong><span>Management</span></div>
                </div>

                {{-- Library --}}
                <div class="dept-card"
                     data-dept="library" data-ac="a-violet"
                     data-email="library@university.com" data-pw="Aa@123456"
                     data-to="{{ route('library.index') }}"
                     data-label="Library Management"
                     data-dot="#7c3aed" data-bg="#f5f3ff"
                     data-btn="linear-gradient(135deg,#6d28d9,#8b5cf6)"
                     data-shadow="rgba(139,92,246,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#7c3aed">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#ede9fe">
                        <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Library</strong><span>Management</span></div>
                </div>

                {{-- Super Admin --}}
                <div class="dept-card"
                     data-dept="admin" data-ac="a-sky"
                     data-email="admin@gmail.com" data-pw="123456789"
                     data-to="{{ route('dashboard') }}"
                     data-label="Super Admin"
                     data-dot="#0284c7" data-bg="#f0f9ff"
                     data-btn="linear-gradient(135deg,#0369a1,#0ea5e9)"
                     data-shadow="rgba(14,165,233,.45)"
                     onclick="pick(this)">
                    <div class="tick" style="background:#0284c7">
                        <svg width="9" height="9" viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,6 5,9 10,3"/></svg>
                    </div>
                    <div class="dept-icon" style="background:#e0f2fe">
                        <svg width="20" height="20" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="dept-name"><strong>Super</strong><span>Admin</span></div>
                </div>

            </div>
        </div>

        {{-- Banner --}}
        <div class="dept-banner" id="dept-banner">
            <span class="banner-dot" id="banner-dot" style="background:#6366f1;"></span>
            <span class="banner-label" id="banner-label">Student Management</span>
            <span class="banner-hint">click a card above to switch</span>
        </div>

        {{-- Form --}}
        <div class="form-section">

            @if (session('status'))
                <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                    <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span style="font-size:.8rem;color:#15803d;">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="department"  id="dept-input"     value="{{ old('department','student') }}">
                <input type="hidden" name="redirect_to" id="redirect-input" value="{{ old('redirect_to',route('students.index')) }}">

                <div class="fields-row">
                    <div>
                        <label class="field-label" for="email">Email Address</label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="Enter your email"
                               class="form-input"/>
                        @error('email') <p class="err">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="password">Password</label>
                        <div class="pw-wrap">
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••••"
                                   class="form-input"/>
                            <button type="button" class="eye-btn" onclick="togglePw()">
                                <svg id="eye-open" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eye-closed" class="hidden" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="err">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="row-between">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" checked/>
                        Remember me
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit" id="btn-submit">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                    </svg>
                    Sign In
                </button>
            </form>

            <p class="hint">
                Department password: <code>Aa@123456</code>
                &nbsp;·&nbsp;
                Admin: <code>admin@gmail.com</code> / <code>123456789</code>
            </p>
        </div>

    </div>{{-- /card --}}

    <p class="footer">&copy; {{ date('Y') }} University ERP — All rights reserved</p>
</div>

<script>
/* ── Floating dots on canvas ── */
(function(){
    const c = document.getElementById('dots'), x = c.getContext('2d');
    let W, H, pts = [];
    function resize(){ W = c.width = innerWidth; H = c.height = innerHeight; }
    addEventListener('resize', resize); resize();
    for(let i=0;i<40;i++) pts.push({ x:Math.random(), y:Math.random(), r:Math.random()*2+.8, s:Math.random()*.00014+.00006, d:Math.random()*.00006-.00003, o:Math.random()*.3+.1 });
    (function loop(){
        x.clearRect(0,0,W,H);
        pts.forEach(p=>{
            p.y-=p.s; p.x+=p.d;
            if(p.y<-.02) p.y=1.02;
            if(p.x<0)p.x=1; if(p.x>1)p.x=0;
            x.beginPath(); x.arc(p.x*W,p.y*H,p.r,0,Math.PI*2);
            x.fillStyle=`rgba(99,102,241,${p.o})`; x.fill();
        });
        requestAnimationFrame(loop);
    })();
})();

/* ── Dept selection ── */
const ALL_AC = ['a-indigo','a-emerald','a-amber','a-rose','a-violet','a-sky'];

function pick(card){
    document.querySelectorAll('.dept-card').forEach(c => c.classList.remove(...ALL_AC));
    card.classList.add(card.dataset.ac);

    document.getElementById('dept-input').value     = card.dataset.dept;
    document.getElementById('redirect-input').value = card.dataset.to;
    document.getElementById('email').value           = card.dataset.email;
    document.getElementById('password').value        = card.dataset.pw;

    document.getElementById('password').type = 'password';
    document.getElementById('eye-open').classList.remove('hidden');
    document.getElementById('eye-closed').classList.add('hidden');

    document.getElementById('dept-banner').style.background = card.dataset.bg;
    document.getElementById('banner-dot').style.background  = card.dataset.dot;
    document.getElementById('banner-label').textContent     = card.dataset.label;

    const btn = document.getElementById('btn-submit');
    btn.style.background = card.dataset.btn;
    btn.style.boxShadow  = `0 4px 20px ${card.dataset.shadow}`;
}

function togglePw(){
    const pw = document.getElementById('password');
    const h  = pw.type==='password';
    pw.type  = h ? 'text' : 'password';
    document.getElementById('eye-open').classList.toggle('hidden', h);
    document.getElementById('eye-closed').classList.toggle('hidden', !h);
}

document.addEventListener('DOMContentLoaded', ()=>{
    const saved = document.getElementById('dept-input').value || 'student';
    const card  = document.querySelector(`[data-dept="${saved}"]`);
    if(card) pick(card);
});
</script>
</body>
</html>
