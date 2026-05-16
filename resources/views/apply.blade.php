<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply — SmartU</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;background:#f1f5f9;color:#1e1b4b;min-height:100vh;}
        a{text-decoration:none;color:inherit;}

        nav{position:sticky;top:0;z-index:1000;background:rgba(15,12,41,.85);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.12);padding:0 48px;display:flex;align-items:center;justify-content:space-between;height:64px;}
        .nav-logo{font-size:20px;font-weight:900;color:#a5b4fc;letter-spacing:-.02em;}
        .nav-logo span{color:#fff;}

        .page-hero{background:linear-gradient(135deg,#0f0c29,#1e1b4b,#4f46e5);color:#fff;padding:60px 48px;text-align:center;position:relative;overflow:hidden;}
        .page-hero::before{content:'';position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(139,92,246,.25),transparent 70%);top:-150px;left:50%;transform:translateX(-50%);pointer-events:none;}
        .page-hero h1{font-size:clamp(28px,4vw,48px);font-weight:900;margin-bottom:10px;position:relative;}
        .page-hero p{font-size:15px;color:#c7d2fe;position:relative;}

        .container{max-width:860px;margin:0 auto;padding:48px 24px;}

        /* STEPS */
        .steps{display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:40px;}
        .step{display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;position:relative;}
        .step:not(:last-child)::after{content:'';position:absolute;top:18px;left:60%;width:80%;height:2px;background:#e5e7eb;z-index:0;}
        .step.done:not(:last-child)::after{background:#4f46e5;}
        .step-circle{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;border:2px solid #e5e7eb;background:#fff;color:#9ca3af;position:relative;z-index:1;transition:.2s;}
        .step.active .step-circle{background:#4f46e5;border-color:#4f46e5;color:#fff;box-shadow:0 0 0 4px rgba(79,70,229,.2);}
        .step.done .step-circle{background:#4f46e5;border-color:#4f46e5;color:#fff;}
        .step-label{font-size:11px;font-weight:600;color:#9ca3af;text-align:center;}
        .step.active .step-label,.step.done .step-label{color:#4f46e5;}

        /* CARD */
        .form-card{background:rgba(255,255,255,.85);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.9);border-radius:20px;padding:36px;box-shadow:0 8px 40px rgba(0,0,0,.08);}
        .form-card h2{font-size:18px;font-weight:800;color:#1e1b4b;margin-bottom:6px;}
        .form-card .sub{font-size:13px;color:#6b7280;margin-bottom:28px;}

        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
        .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:18px;}
        .field{display:flex;flex-direction:column;gap:5px;margin-bottom:4px;}
        .field label{font-size:12px;font-weight:700;color:#374151;letter-spacing:.02em;}
        .field input,.field select,.field textarea{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;background:#fff;outline:none;transition:.15s;font-family:inherit;}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);}
        .field textarea{resize:vertical;min-height:90px;}
        .field .hint{font-size:11px;color:#9ca3af;}

        .section-divider{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6366f1;margin:24px 0 16px;padding-bottom:8px;border-bottom:1px solid #e5e7eb;}

        /* PROGRAMME CARDS */
        .prog-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:4px;}
        .prog-option{border:2px solid #e5e7eb;border-radius:12px;padding:14px;cursor:pointer;transition:.2s;background:#fff;text-align:center;}
        .prog-option:hover{border-color:#a5b4fc;background:#f5f3ff;}
        .prog-option input[type=radio]{display:none;}
        .prog-option.selected{border-color:#4f46e5;background:#eef2ff;}
        .prog-option .p-icon{font-size:24px;margin-bottom:6px;}
        .prog-option .p-name{font-size:12px;font-weight:700;color:#1e1b4b;}
        .prog-option .p-dur{font-size:11px;color:#9ca3af;margin-top:2px;}

        /* BUTTONS */
        .btn-row{display:flex;justify-content:space-between;align-items:center;margin-top:28px;}
        .btn{padding:11px 28px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;border:none;transition:.2s;display:inline-flex;align-items:center;gap:6px;}
        .btn-primary{background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;box-shadow:0 4px 15px rgba(79,70,229,.35);}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(79,70,229,.45);}
        .btn-secondary{background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;}
        .btn-secondary:hover{background:#e5e7eb;}

        /* SUCCESS */
        .success-card{text-align:center;padding:60px 36px;}
        .success-icon{font-size:64px;margin-bottom:20px;}
        .success-card h2{font-size:26px;font-weight:900;color:#1e1b4b;margin-bottom:10px;}
        .success-card p{font-size:15px;color:#6b7280;line-height:1.7;max-width:480px;margin:0 auto 28px;}
        .ref-box{display:inline-block;background:#eef2ff;border:1px solid #c7d2fe;border-radius:10px;padding:10px 24px;font-size:14px;font-weight:700;color:#4f46e5;margin-bottom:28px;}

        /* PANEL HIDDEN */
        .panel{display:none;}
        .panel.active{display:block;}

        @media(max-width:640px){
            nav{padding:0 20px;}
            .page-hero{padding:40px 20px;}
            .container{padding:24px 16px;}
            .grid-2,.grid-3{grid-template-columns:1fr;}
            .form-card{padding:24px;}
        }
    </style>
</head>
<body>

<nav>
    <a href="/university" class="nav-logo">Smart<span>U</span></a>
    <a href="/university" style="font-size:13px;color:#a5b4fc;font-weight:600;">← Back to Website</a>
</nav>

<div class="page-hero">
    <h1>🎓 Apply to SmartU</h1>
    <p>Complete your application in 3 simple steps — it takes less than 10 minutes.</p>
</div>

<div class="container">

    {{-- STEPS --}}
    <div class="steps" id="steps">
        <div class="step active" id="s1"><div class="step-circle">1</div><div class="step-label">Personal Info</div></div>
        <div class="step" id="s2"><div class="step-circle">2</div><div class="step-label">Programme</div></div>
        <div class="step" id="s3"><div class="step-circle">3</div><div class="step-label">Review & Submit</div></div>
    </div>

    {{-- STEP 1: PERSONAL INFO --}}
    <div class="panel active" id="panel-1">
        <div class="form-card">
            <h2>Personal Information</h2>
            <div class="sub">Tell us about yourself. All fields marked are required.</div>

            <div class="section-divider">Basic Details</div>
            <div class="grid-3">
                <div class="field"><label>First Name *</label><input type="text" id="fname" placeholder="e.g. Sarah"></div>
                <div class="field"><label>Middle Name</label><input type="text" id="mname" placeholder="Optional"></div>
                <div class="field"><label>Last Name *</label><input type="text" id="lname" placeholder="e.g. Johnson"></div>
            </div>
            <div class="grid-3" style="margin-top:16px;">
                <div class="field"><label>Date of Birth *</label><input type="date" id="dob"></div>
                <div class="field"><label>Gender *</label>
                    <select id="gender">
                        <option value="">Select...</option>
                        <option>Male</option><option>Female</option><option>Non-binary</option><option>Prefer not to say</option>
                    </select>
                </div>
                <div class="field"><label>Nationality *</label><input type="text" id="nationality" placeholder="e.g. British"></div>
            </div>

            <div class="section-divider">Contact Details</div>
            <div class="grid-2">
                <div class="field"><label>Email Address *</label><input type="email" id="email" placeholder="you@example.com"></div>
                <div class="field"><label>Phone Number *</label><input type="tel" id="phone" placeholder="+1 (555) 000-0000"></div>
            </div>
            <div class="field" style="margin-top:16px;"><label>Home Address *</label><input type="text" id="address" placeholder="Street, City, Country"></div>

            <div class="section-divider">Academic Background</div>
            <div class="grid-2">
                <div class="field"><label>Highest Qualification *</label>
                    <select id="qual">
                        <option value="">Select...</option>
                        <option>High School / A-Levels</option>
                        <option>Foundation Year</option>
                        <option>Bachelor's Degree</option>
                        <option>Master's Degree</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="field"><label>GPA / Grade *</label><input type="text" id="gpa" placeholder="e.g. 3.8 / 4.0 or A*AA"></div>
            </div>
            <div class="field" style="margin-top:16px;"><label>Previous Institution *</label><input type="text" id="school" placeholder="Name of your school or university"></div>

            <div class="btn-row">
                <span style="font-size:12px;color:#9ca3af;">Step 1 of 3</span>
                <button class="btn btn-primary" onclick="goTo(2)">Continue →</button>
            </div>
        </div>
    </div>

    {{-- STEP 2: PROGRAMME --}}
    <div class="panel" id="panel-2">
        <div class="form-card">
            <h2>Choose Your Programme</h2>
            <div class="sub">Select the programme you wish to apply for and your preferred intake.</div>

            <div class="section-divider">Select Programme *</div>
            <div class="prog-grid" id="prog-grid">
                @foreach([
                    ['🖥️','Computer Science & AI','4-Year BSc'],
                    ['⚕️','Medicine','6-Year MBBS'],
                    ['⚖️','Law','3-Year LLB'],
                    ['📐','Engineering','4-Year BEng'],
                    ['💼','Business & MBA','1–3 Year'],
                    ['🎨','Arts & Design','3-Year BA'],
                    ['🔬','Natural Sciences','3-Year BSc'],
                    ['🌍','Intl. Relations','3-Year BA'],
                ] as [$icon,$name,$dur])
                <label class="prog-option" onclick="selectProg(this)">
                    <input type="radio" name="programme" value="{{ $name }}">
                    <div class="p-icon">{{ $icon }}</div>
                    <div class="p-name">{{ $name }}</div>
                    <div class="p-dur">{{ $dur }}</div>
                </label>
                @endforeach
            </div>

            <div class="section-divider" style="margin-top:24px;">Intake & Study Mode</div>
            <div class="grid-2">
                <div class="field"><label>Preferred Intake *</label>
                    <select id="intake">
                        <option value="">Select...</option>
                        <option>September 2025</option>
                        <option>January 2026</option>
                        <option>September 2026</option>
                    </select>
                </div>
                <div class="field"><label>Study Mode *</label>
                    <select id="mode">
                        <option value="">Select...</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Online</option>
                    </select>
                </div>
            </div>

            <div class="section-divider">Scholarship</div>
            <div class="field">
                <label>Are you applying for a scholarship?</label>
                <select id="scholarship">
                    <option value="">Select...</option>
                    <option>Yes — Merit Scholarship</option>
                    <option>Yes — Need-Based Scholarship</option>
                    <option>Yes — International Student Scholarship</option>
                    <option>No</option>
                </select>
            </div>
            <div class="field" style="margin-top:16px;">
                <label>Personal Statement</label>
                <textarea id="statement" placeholder="Tell us why you want to study at SmartU and what makes you a great candidate (min. 150 words)..."></textarea>
                <span class="hint">Minimum 150 words recommended.</span>
            </div>

            <div class="btn-row">
                <button class="btn btn-secondary" onclick="goTo(1)">← Back</button>
                <button class="btn btn-primary" onclick="goTo(3)">Review Application →</button>
            </div>
        </div>
    </div>

    {{-- STEP 3: REVIEW --}}
    <div class="panel" id="panel-3">
        <div class="form-card">
            <h2>Review & Submit</h2>
            <div class="sub">Please review your details before submitting.</div>

            <div class="section-divider">Personal Details</div>
            <div id="review-personal" style="display:grid;grid-template-columns:1fr 1fr;gap:10px 24px;font-size:13px;"></div>

            <div class="section-divider">Programme Details</div>
            <div id="review-programme" style="display:grid;grid-template-columns:1fr 1fr;gap:10px 24px;font-size:13px;"></div>

            <div style="margin-top:24px;background:#fefce8;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;font-size:13px;color:#92400e;">
                ⚠️ By submitting this application you confirm all information provided is accurate and complete.
            </div>

            <div class="btn-row">
                <button class="btn btn-secondary" onclick="goTo(2)">← Back</button>
                <button class="btn btn-primary" onclick="submitApp()">🎓 Submit Application</button>
            </div>
        </div>
    </div>

    {{-- SUCCESS --}}
    <div class="panel" id="panel-success">
        <div class="form-card success-card">
            <div class="success-icon">🎉</div>
            <h2>Application Submitted!</h2>
            <p>Thank you for applying to SmartU. We've received your application and will be in touch within <strong>5–7 business days</strong>.</p>
            <div class="ref-box" id="ref-number">Reference: SU-2025-XXXX</div>
            <br>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="/university" class="btn btn-primary">← Back to Website</a>
                <a href="/login" class="btn btn-secondary">Staff Portal</a>
            </div>
        </div>
    </div>

</div>

<script>
function goTo(step) {
    if (step === 2 && !validateStep1()) return;
    if (step === 3 && !validateStep2()) return;
    if (step === 3) buildReview();

    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + step).classList.add('active');

    [1,2,3].forEach(i => {
        const s = document.getElementById('s' + i);
        s.classList.remove('active','done');
        if (i < step) s.classList.add('done');
        if (i === step) s.classList.add('active');
    });
    window.scrollTo({top:0,behavior:'smooth'});
}

function validateStep1() {
    const required = ['fname','lname','dob','gender','nationality','email','phone','address','qual','gpa','school'];
    for (const id of required) {
        const el = document.getElementById(id);
        if (!el.value.trim()) {
            el.style.borderColor = '#ef4444';
            el.focus();
            el.addEventListener('input', () => el.style.borderColor = '', {once:true});
            return false;
        }
    }
    return true;
}

function validateStep2() {
    const prog = document.querySelector('input[name="programme"]:checked');
    const intake = document.getElementById('intake').value;
    const mode = document.getElementById('mode').value;
    if (!prog) { alert('Please select a programme.'); return false; }
    if (!intake) { alert('Please select an intake.'); return false; }
    if (!mode) { alert('Please select a study mode.'); return false; }
    return true;
}

function selectProg(el) {
    document.querySelectorAll('.prog-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
}

function buildReview() {
    const p = document.getElementById('review-personal');
    const pr = document.getElementById('review-programme');
    const prog = document.querySelector('input[name="programme"]:checked');

    p.innerHTML = [
        ['Full Name', `${v('fname')} ${v('mname')} ${v('lname')}`.trim()],
        ['Date of Birth', v('dob')],
        ['Gender', v('gender')],
        ['Nationality', v('nationality')],
        ['Email', v('email')],
        ['Phone', v('phone')],
        ['Address', v('address')],
        ['Qualification', v('qual')],
        ['GPA / Grade', v('gpa')],
        ['Previous Institution', v('school')],
    ].map(([l,val]) => `<div><span style="font-weight:700;color:#374151;">${l}</span><br><span style="color:#6b7280;">${val||'—'}</span></div>`).join('');

    pr.innerHTML = [
        ['Programme', prog ? prog.value : '—'],
        ['Intake', v('intake')],
        ['Study Mode', v('mode')],
        ['Scholarship', v('scholarship') || 'No'],
    ].map(([l,val]) => `<div><span style="font-weight:700;color:#374151;">${l}</span><br><span style="color:#6b7280;">${val||'—'}</span></div>`).join('');
}

function v(id) { return document.getElementById(id)?.value || ''; }

function submitApp() {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-success').classList.add('active');
    document.getElementById('steps').style.display = 'none';
    const ref = 'SU-2025-' + Math.floor(1000 + Math.random() * 9000);
    document.getElementById('ref-number').textContent = 'Reference: ' + ref;
    window.scrollTo({top:0,behavior:'smooth'});
}
</script>
</body>
</html>
