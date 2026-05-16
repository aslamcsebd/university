<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartU — Smart University</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;background:#fff;color:#1e1b4b;}
        a{text-decoration:none;color:inherit;}

        /* NAV — glassmorphism */
        nav{position:sticky;top:0;z-index:1000;background:rgba(15,12,41,.75);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.12);padding:0 48px;display:flex;align-items:center;justify-content:space-between;height:64px;box-shadow:0 4px 30px rgba(0,0,0,.25);}
        .nav-logo{font-size:20px;font-weight:900;color:#a5b4fc;letter-spacing:-.02em;}
        .nav-logo span{color:#fff;}
        .nav-links{display:flex;gap:28px;font-size:14px;font-weight:500;color:#c7d2fe;}
        .nav-links a:hover{color:#fff;}
        .nav-cta{background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;padding:8px 20px;border-radius:8px;font-size:13px;font-weight:700;box-shadow:0 4px 15px rgba(79,70,229,.4);transition:.2s;}
        .nav-cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(79,70,229,.5);}

        /* HERO */
        .hero{background:linear-gradient(135deg,#0f0c29 0%,#1e1b4b 40%,#312e81 70%,#4f46e5 100%);color:#fff;padding:100px 48px;display:flex;align-items:center;gap:60px;min-height:88vh;position:relative;overflow:hidden;}
        .hero::before{content:'';position:absolute;width:600px;height:600px;background:radial-gradient(circle,rgba(139,92,246,.3),transparent 70%);top:-100px;right:-100px;pointer-events:none;}
        .hero::after{content:'';position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(99,102,241,.2),transparent 70%);bottom:-50px;left:200px;pointer-events:none;}
        .hero-text{flex:1;max-width:580px;position:relative;z-index:1;}
        .hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.1);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.25);padding:5px 14px;border-radius:999px;font-size:12px;font-weight:600;letter-spacing:.05em;margin-bottom:24px;box-shadow:0 4px 15px rgba(0,0,0,.1);}
        .hero h1{font-size:clamp(36px,5vw,62px);font-weight:900;line-height:1.1;letter-spacing:-.03em;margin-bottom:20px;}
        .hero h1 span{color:#a5b4fc;}
        .hero p{font-size:17px;color:#c7d2fe;line-height:1.7;margin-bottom:36px;}
        .hero-btns{display:flex;gap:14px;flex-wrap:wrap;}
        .btn-hero{padding:13px 28px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;border:none;transition:.2s;display:inline-block;}
        .btn-hero-primary{background:rgba(255,255,255,.95);color:#4f46e5;box-shadow:0 4px 20px rgba(255,255,255,.2);}
        .btn-hero-primary:hover{background:#fff;transform:translateY(-2px);box-shadow:0 8px 30px rgba(255,255,255,.3);}
        .btn-hero-outline{background:rgba(255,255,255,.08);backdrop-filter:blur(10px);color:#fff;border:1.5px solid rgba(255,255,255,.3);}
        .btn-hero-outline:hover{background:rgba(255,255,255,.15);transform:translateY(-2px);}
        .hero-visual{flex:1;display:flex;justify-content:center;align-items:center;position:relative;z-index:1;}
        .hero-card-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;max-width:380px;width:100%;}
        .hero-card{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);border-radius:16px;padding:22px;backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);box-shadow:0 8px 32px rgba(0,0,0,.15);transition:.2s;}
        .hero-card:hover{background:rgba(255,255,255,.14);transform:translateY(-3px);box-shadow:0 12px 40px rgba(0,0,0,.2);}
        .hero-card .num{font-size:28px;font-weight:900;color:#fff;}
        .hero-card .lbl{font-size:12px;color:#a5b4fc;margin-top:2px;}

        /* STATS BAR */
        .stats-bar{background:linear-gradient(135deg,#4338ca,#4f46e5,#7c3aed);color:#fff;padding:28px 48px;display:flex;justify-content:space-around;flex-wrap:wrap;gap:20px;position:relative;overflow:hidden;}
        .stats-bar::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");}
        .stat-item{text-align:center;background:rgba(255,255,255,.08);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:16px 28px;}
        .stat-item .n{font-size:32px;font-weight:900;}
        .stat-item .l{font-size:12px;color:#c7d2fe;margin-top:2px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}

        /* SECTIONS */
        section{padding:80px 48px;}
        .section-label{font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6366f1;margin-bottom:10px;}
        .section-title{font-size:clamp(26px,3.5vw,40px);font-weight:900;color:#1e1b4b;line-height:1.2;margin-bottom:14px;}
        .section-sub{font-size:15px;color:#6b7280;max-width:560px;line-height:1.7;}
        .section-header{margin-bottom:48px;}

        /* PROGRAMS */
        .programs{background:linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);}
        .programs-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
        .prog-card{background:rgba(255,255,255,.7);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.9);border-radius:16px;padding:24px;transition:.25s;cursor:pointer;box-shadow:0 4px 20px rgba(99,102,241,.06);}
        .prog-card:hover{background:rgba(255,255,255,.95);border-color:#a5b4fc;box-shadow:0 12px 40px rgba(99,102,241,.15);transform:translateY(-4px);}
        .prog-icon{font-size:32px;margin-bottom:14px;}
        .prog-card h3{font-size:15px;font-weight:700;color:#1e1b4b;margin-bottom:6px;}
        .prog-card p{font-size:13px;color:#6b7280;line-height:1.6;}
        .prog-tag{display:inline-block;margin-top:12px;font-size:11px;font-weight:700;color:#4f46e5;background:rgba(99,102,241,.1);padding:3px 10px;border-radius:999px;border:1px solid rgba(99,102,241,.2);}

        /* FEATURES */
        .features-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;}
        .feat{display:flex;gap:16px;align-items:flex-start;background:rgba(255,255,255,.6);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.8);border-radius:14px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,.04);transition:.2s;}
        .feat:hover{background:rgba(255,255,255,.9);box-shadow:0 8px 30px rgba(99,102,241,.1);transform:translateY(-2px);}
        .feat-icon{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#eef2ff,#e0e7ff);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;box-shadow:0 2px 8px rgba(99,102,241,.15);}
        .feat h4{font-size:14px;font-weight:700;color:#1e1b4b;margin-bottom:4px;}
        .feat p{font-size:13px;color:#6b7280;line-height:1.6;}

        /* NEWS */
        .news{background:linear-gradient(180deg,#f8faff,#eef2ff);}
        .news-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;}
        .news-card{background:rgba(255,255,255,.75);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,.9);transition:.25s;box-shadow:0 4px 20px rgba(0,0,0,.05);}
        .news-card:hover{box-shadow:0 12px 40px rgba(99,102,241,.12);transform:translateY(-4px);background:rgba(255,255,255,.95);}
        .news-img{height:160px;display:flex;align-items:center;justify-content:center;font-size:48px;}
        .news-body{padding:20px;}
        .news-cat{font-size:11px;font-weight:700;color:#6366f1;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;}
        .news-body h3{font-size:15px;font-weight:700;color:#1e1b4b;margin-bottom:8px;line-height:1.4;}
        .news-body p{font-size:13px;color:#6b7280;line-height:1.6;}
        .news-date{font-size:11px;color:#9ca3af;margin-top:12px;}

        /* TESTIMONIALS */
        .testi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;}
        .testi-card{background:rgba(255,255,255,.65);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.85);border-radius:16px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.05);transition:.2s;}
        .testi-card:hover{background:rgba(255,255,255,.9);box-shadow:0 10px 35px rgba(99,102,241,.1);transform:translateY(-3px);}
        .testi-stars{color:#f59e0b;font-size:14px;margin-bottom:12px;}
        .testi-card p{font-size:13px;color:#374151;line-height:1.7;font-style:italic;}
        .testi-author{display:flex;align-items:center;gap:10px;margin-top:16px;}
        .testi-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;box-shadow:0 2px 8px rgba(99,102,241,.3);}
        .testi-name{font-size:13px;font-weight:700;color:#1e1b4b;}
        .testi-role{font-size:11px;color:#9ca3af;}

        /* CTA */
        .cta-section{background:linear-gradient(135deg,#0f0c29,#1e1b4b,#4f46e5);color:#fff;text-align:center;padding:80px 48px;position:relative;overflow:hidden;}
        .cta-section::before{content:'';position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(139,92,246,.25),transparent 70%);top:-150px;left:50%;transform:translateX(-50%);pointer-events:none;}
        .cta-inner{position:relative;z-index:1;background:rgba(255,255,255,.05);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.12);border-radius:24px;padding:60px 48px;max-width:700px;margin:0 auto;box-shadow:0 20px 60px rgba(0,0,0,.2);}
        .cta-section h2{font-size:clamp(28px,4vw,48px);font-weight:900;margin-bottom:16px;}
        .cta-section p{font-size:16px;color:#c7d2fe;margin-bottom:36px;}
        .cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;}

        /* FOOTER */
        footer{background:#0f0e1a;color:#9ca3af;padding:60px 48px 30px;}
        .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;margin-bottom:40px;}
        .footer-brand .logo{font-size:20px;font-weight:900;color:#fff;margin-bottom:12px;}
        .footer-brand p{font-size:13px;line-height:1.7;}
        .footer-col h4{font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px;}
        .footer-col a{display:block;font-size:13px;color:#9ca3af;margin-bottom:8px;}
        .footer-col a:hover{color:#a5b4fc;}
        .footer-bottom{border-top:1px solid #1f2937;padding-top:24px;display:flex;justify-content:space-between;font-size:12px;flex-wrap:wrap;gap:10px;}

        @media(max-width:768px){
            nav{padding:0 20px;}
            .nav-links{display:none;}
            .hero{flex-direction:column;padding:60px 20px;}
            .hero-visual{display:none;}
            section{padding:60px 20px;}
            .stats-bar{padding:24px 20px;}
            .footer-grid{grid-template-columns:1fr 1fr;}
            footer{padding:40px 20px 20px;}
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav>
    <div class="nav-logo">Smart<span>U</span></div>
    <div class="nav-links">
        <a href="#programs">Programs</a>
        <a href="#features">Campus Life</a>
        <a href="#news">News</a>
        <a href="#testimonials">Alumni</a>
        <a href="#contact">Contact</a>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <a href="/login" style="font-size:13px;font-weight:600;color:#a5b4fc;">Staff Login</a>
        <a href="/apply" class="nav-cta">Apply Now</a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-text">
        <div class="hero-badge">🏆 Ranked #1 Smart University 2025</div>
        <h1>Shape the Future at <span>SmartU</span></h1>
        <p>A world-class institution where innovation meets tradition. Discover cutting-edge programmes, world-renowned faculty, and a vibrant campus community.</p>
        <div class="hero-btns">
            <a href="/apply" class="btn-hero btn-hero-primary">Explore Programmes</a>
            <a href="#features" class="btn-hero btn-hero-outline">Virtual Campus Tour</a>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-card-grid">
            <div class="hero-card"><div class="num">12,400+</div><div class="lbl">Students Enrolled</div></div>
            <div class="hero-card"><div class="num">320+</div><div class="lbl">Expert Faculty</div></div>
            <div class="hero-card"><div class="num">85+</div><div class="lbl">Programmes</div></div>
            <div class="hero-card"><div class="num">96%</div><div class="lbl">Graduate Employment</div></div>
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<div class="stats-bar">
    <div class="stat-item"><div class="n">50+</div><div class="l">Years of Excellence</div></div>
    <div class="stat-item"><div class="n">140+</div><div class="l">Research Centres</div></div>
    <div class="stat-item"><div class="n">60+</div><div class="l">Partner Universities</div></div>
    <div class="stat-item"><div class="n">$42M</div><div class="l">Annual Research Funding</div></div>
    <div class="stat-item"><div class="n">180+</div><div class="l">Countries Represented</div></div>
</div>

{{-- PROGRAMMES --}}
<section class="programs" id="programs">
    <div class="section-header">
        <div class="section-label">Academic Excellence</div>
        <div class="section-title">World-Class Programmes</div>
        <div class="section-sub">From undergraduate to doctoral studies, our programmes are designed to challenge, inspire, and prepare you for a global career.</div>
    </div>
    <div class="programs-grid">
        @foreach([
            ['🖥️','Computer Science & AI','Deep-dive into machine learning, software engineering, and intelligent systems.','4-Year BSc'],
            ['⚕️','Medicine & Health Sciences','Train with leading clinicians in state-of-the-art simulation labs.','6-Year MBBS'],
            ['⚖️','Law & Governance','Develop critical legal reasoning with real-world moot court experience.','3-Year LLB'],
            ['📐','Engineering & Technology','Hands-on design, build, and test across 12 engineering disciplines.','4-Year BEng'],
            ['💼','Business & Management','MBA and undergraduate programmes ranked in the global top 50.','1–3 Year'],
            ['🎨','Arts, Design & Media','Unleash creativity in our award-winning studios and media labs.','3-Year BA'],
            ['🔬','Natural Sciences','Cutting-edge labs for biology, chemistry, physics, and earth sciences.','3-Year BSc'],
            ['🌍','International Relations','Prepare for diplomacy, policy, and global leadership roles.','3-Year BA'],
        ] as [$icon,$title,$desc,$tag])
        <div class="prog-card">
            <div class="prog-icon">{{ $icon }}</div>
            <h3>{{ $title }}</h3>
            <p>{{ $desc }}</p>
            <span class="prog-tag">{{ $tag }}</span>
        </div>
        @endforeach
    </div>
</section>

{{-- FEATURES --}}
<section id="features" style="position:relative;overflow:hidden;">
    <div style="position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(99,102,241,.08),transparent 70%);top:-100px;right:-100px;pointer-events:none;"></div>
    <div style="position:absolute;width:300px;height:300px;background:radial-gradient(circle,rgba(139,92,246,.07),transparent 70%);bottom:-50px;left:-50px;pointer-events:none;"></div>
    <div class="section-header">
        <div class="section-label">Campus Life</div>
        <div class="section-title">Everything You Need to Thrive</div>
        <div class="section-sub">Our smart campus integrates technology and community to create an unparalleled student experience.</div>
    </div>
    <div class="features-grid">
        @foreach([
            ['🤖','AI-Powered Learning','Personalised study plans, smart tutoring, and adaptive assessments powered by AI.'],
            ['📡','Smart Campus Network','Gigabit Wi-Fi across all buildings, IoT-enabled classrooms, and digital ID access.'],
            ['🏋️','World-Class Facilities','Olympic pool, fitness centre, 3D printing labs, and a 1,200-seat concert hall.'],
            ['🌱','Sustainability Pledge','Carbon-neutral campus by 2030 with solar energy, green roofs, and zero-waste dining.'],
            ['🤝','Industry Partnerships','Direct pipelines to 500+ companies for internships, placements, and graduate roles.'],
            ['🌐','Global Exchange','Semester abroad programmes with 60+ partner universities across 40 countries.'],
            ['💡','Research Opportunities','Undergraduate research grants and access to 140+ active research centres.'],
            ['🏠','Student Wellbeing','24/7 counselling, mental health support, and a dedicated student success team.'],
            ['📚','Digital Library','Access to 2M+ e-books, journals, and databases from anywhere in the world.'],
        ] as [$icon,$title,$desc])
        <div class="feat">
            <div class="feat-icon">{{ $icon }}</div>
            <div>
                <h4>{{ $title }}</h4>
                <p>{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- NEWS --}}
<section class="news" id="news">
    <div class="section-header">
        <div class="section-label">Latest Updates</div>
        <div class="section-title">News & Events</div>
        <div class="section-sub">Stay up to date with research breakthroughs, campus events, and student achievements.</div>
    </div>
    <div class="news-grid">
        @foreach([
            ['🏆','Achievement','SmartU Ranks in Global Top 100 Universities','Our institution climbs 12 places in the latest QS World University Rankings, reflecting excellence in research and teaching.','Jan 15, 2025','#eef2ff'],
            ['🔬','Research','Breakthrough in Quantum Computing Research','SmartU scientists publish landmark paper on error-corrected quantum processors in Nature journal.','Jan 10, 2025','#f0fdf4'],
            ['🎓','Events','Annual Graduation Ceremony — 3,200 Graduates','This year\'s ceremony celebrated our largest graduating class, with students from 85 countries.','Dec 20, 2024','#fff7ed'],
            ['💡','Innovation','New AI Research Centre Opens on Campus','A $12M facility dedicated to responsible AI development and human-computer interaction research.','Dec 5, 2024','#fdf4ff'],
            ['🌍','Partnership','New Exchange Agreement with Tokyo University','Students can now apply for a full-year exchange programme starting September 2025.','Nov 28, 2024','#eff6ff'],
            ['🏅','Sports','SmartU Wins National University Sports Championship','Our athletics team claimed gold in 7 disciplines at the national inter-university games.','Nov 15, 2024','#fefce8'],
        ] as [$icon,$cat,$title,$desc,$date,$bg])
        <div class="news-card">
            <div class="news-img" style="background:{{ $bg }};">{{ $icon }}</div>
            <div class="news-body">
                <div class="news-cat">{{ $cat }}</div>
                <h3>{{ $title }}</h3>
                <p>{{ $desc }}</p>
                <div class="news-date">{{ $date }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- TESTIMONIALS --}}
<section id="testimonials" style="position:relative;overflow:hidden;">
    <div style="position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(99,102,241,.06),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>
    <div class="section-header">
        <div class="section-label">Alumni Voices</div>
        <div class="section-title">What Our Graduates Say</div>
    </div>
    <div class="testi-grid">
        @foreach([
            ['"SmartU gave me the technical depth and the global network to launch my startup. Within two years of graduating, we raised $4M in seed funding."','S','Sarah K.','BSc Computer Science, 2022'],
            ['"The medical programme here is unmatched. The simulation labs and clinical placements prepared me for real-world practice from day one."','A','Dr. Ahmed R.','MBBS Medicine, 2020'],
            ['"I came from Kenya on a scholarship and left with a world-class degree and lifelong friends from 30 countries. SmartU changed my life."','F','Fatima O.','BA International Relations, 2023'],
            ['"The research opportunities as an undergraduate were extraordinary. I co-authored two papers before I even graduated."','J','James T.','BSc Natural Sciences, 2021'],
            ['"The MBA programme connected me directly with industry leaders. I had three job offers before graduation day."','L','Li W.','MBA Business, 2023'],
            ['"SmartU\'s engineering labs are better equipped than most industry facilities. I felt ready for my career from day one."','M','Maria G.','BEng Engineering, 2022'],
        ] as [$quote,$initial,$name,$role])
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p>{{ $quote }}</p>
            <div class="testi-author">
                <div class="testi-avatar">{{ $initial }}</div>
                <div>
                    <div class="testi-name">{{ $name }}</div>
                    <div class="testi-role">{{ $role }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" id="apply">
    <div class="cta-inner">
        <div class="section-label" style="color:#a5b4fc;">Start Your Journey</div>
        <h2>Ready to Join SmartU?</h2>
        <p>Applications for September 2025 intake are now open. Scholarships available for outstanding candidates.</p>
        <div class="cta-btns">
            <a href="/apply" class="btn-hero btn-hero-primary">Apply for 2025 Intake</a>
            <a href="#" class="btn-hero btn-hero-outline">Download Prospectus</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer id="contact">
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="logo">🎓 SmartU</div>
            <p>A world-class smart university committed to excellence in education, research, and innovation since 1974.</p>
            <div style="margin-top:16px;display:flex;gap:12px;font-size:18px;">
                <span style="cursor:pointer;">🐦</span>
                <span style="cursor:pointer;">💼</span>
                <span style="cursor:pointer;">📘</span>
                <span style="cursor:pointer;">📸</span>
            </div>
        </div>
        <div class="footer-col">
            <h4>Academics</h4>
            <a href="#">Undergraduate</a>
            <a href="#">Postgraduate</a>
            <a href="#">PhD Programmes</a>
            <a href="#">Online Learning</a>
            <a href="#">Short Courses</a>
        </div>
        <div class="footer-col">
            <h4>Campus</h4>
            <a href="#">Library</a>
            <a href="#">Student Union</a>
            <a href="#">Sports Centre</a>
            <a href="#">Accommodation</a>
            <a href="#">Dining</a>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <a href="#">📍 1 University Avenue</a>
            <a href="#">📞 +1 (800) 123-4567</a>
            <a href="#">✉️ info@smartu.edu</a>
            <a href="/login" style="color:#a5b4fc;margin-top:8px;display:block;">🔐 Staff Portal</a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© 2025 SmartU. All rights reserved.</span>
        <span>Privacy Policy · Terms of Use · Accessibility</span>
    </div>
</footer>

</body>
</html>
