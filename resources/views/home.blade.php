<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#1a1d24" />
  <meta name="description" content="SZPC '26 — 3rd UGV South Zone Programming Contest & ICT Talent Hunt, 29 August 2026 at University of Global Village, Barishal. Code. Solve. Quiz. Compete." />
  <title>SZPC '26 — South Zone Programming Contest | University of Global Village</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%23050505'/%3E%3Ctext x='6' y='24' font-family='monospace' font-size='20' fill='%2300FF41'%3E%3E_%3C/text%3E%3C/svg%3E" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            void: '#1a1d24',
            surface: '#242830',
            panel: '#2d333d',
            elevated: '#363d49',
            neon: '#00FF41',
            cyber: '#00F0FF',
            dim: '#b4bcc8',
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          },
        },
      },
    };
  </script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body class="bg-void text-gray-100 font-sans antialiased selection:bg-neon selection:text-black">

  <div class="noise-overlay" aria-hidden="true"></div>

  <!-- ================= NAV ================= -->
  <header id="site-nav" class="fixed top-0 left-0 right-0 z-50 border-b border-white/15 bg-surface/85 backdrop-blur-xl transition-transform duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
      <a href="#top" data-testid="nav-logo" class="nav-anchor flex items-center gap-3 group">
        <span class="w-8 h-8 border border-neon flex items-center justify-center text-neon font-display font-bold text-sm group-hover:bg-neon group-hover:text-black transition-colors duration-300">SZ</span>
        <span class="font-display font-800 tracking-wide text-sm">SZPC<span class="text-neon">'26</span></span>
      </a>
      <nav class="hidden lg:flex items-center gap-8 text-xs tracking-[0.2em] text-dim">
        <a href="#about" data-testid="nav-link-about" class="nav-anchor nav-link">ABOUT</a>
        <a href="#segments" data-testid="nav-link-segments" class="nav-anchor nav-link">SEGMENTS</a>
        <a href="#schedule" data-testid="nav-link-schedule" class="nav-anchor nav-link">SCHEDULE</a>
        <a href="#prizes" data-testid="nav-link-prizes" class="nav-anchor nav-link">PRIZES</a>
        <!-- <a href="#sponsors" data-testid="nav-link-sponsors" class="nav-anchor nav-link">SPONSORS</a> -->
        <a href="#committee" data-testid="nav-link-committee" class="nav-anchor nav-link">TEAM</a>
        <a href="#faq" data-testid="nav-link-faq" class="nav-anchor nav-link">FAQ</a>
      </nav>
      <div class="flex items-center gap-4">
        <a href="{{ route('register') }}" data-testid="nav-register-btn" class="nav-anchor hidden sm:inline-block border border-neon text-neon px-5 py-2 text-xs tracking-[0.2em] hover:bg-neon hover:text-black transition-colors duration-300 btn-hard">REGISTER</a>
        <button id="menu-toggle" data-testid="mobile-menu-button" class="lg:hidden text-neon text-2xl leading-none" aria-label="Open menu">≡</button>
      </div>
    </div>
  </header>

  <!-- mobile menu -->
  <div id="mobile-menu" class="fixed inset-0 z-40 bg-surface/95 backdrop-blur-xl hidden flex-col items-center justify-center gap-8 text-lg tracking-[0.3em] font-display">
    <button id="menu-close" data-testid="mobile-menu-close" class="absolute top-5 right-6 text-neon text-3xl" aria-label="Close menu">×</button>
    <a href="#about" data-testid="mobile-link-about" class="nav-anchor mobile-link">ABOUT</a>
    <a href="#segments" data-testid="mobile-link-segments" class="nav-anchor mobile-link">SEGMENTS</a>
    <a href="#schedule" data-testid="mobile-link-schedule" class="nav-anchor mobile-link">SCHEDULE</a>
    <a href="#prizes" data-testid="mobile-link-prizes" class="nav-anchor mobile-link">PRIZES</a>
    <!-- <a href="#sponsors" data-testid="mobile-link-sponsors" class="nav-anchor mobile-link">SPONSORS</a> -->
    <a href="#committee" data-testid="mobile-link-committee" class="nav-anchor mobile-link">TEAM</a>
    <a href="#faq" data-testid="mobile-link-faq" class="nav-anchor mobile-link">FAQ</a>
    <a href="{{ route('register') }}" data-testid="mobile-link-register" class="border border-neon text-neon px-8 py-3 mt-4">REGISTER</a>
  </div>

  <!-- ================= HERO ================= -->
  <section id="top" class="relative min-h-screen flex flex-col justify-center overflow-hidden blueprint-x">
    <div id="hero-bg" class="absolute inset-0 -z-10">
      <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=2000&auto=format&fit=crop" alt="" class="w-full h-[120%] object-cover opacity-[0.28] blur-[1px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-void/25 via-void/45 to-void"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 w-full pt-28 pb-16">
      <p class="text-dim text-sm sm:text-base mb-6" data-testid="hero-terminal-line">
        University of Global Village, Barishal · 29 August 2026
      </p>

      <h1 class="font-display font-800 leading-[1.05] tracking-tight text-[11vw] sm:text-[7vw] lg:text-[5.5rem]">
        <span class="line-mask"><span class="line-inner">South Zone</span></span>
        <span class="line-mask"><span class="line-inner text-neon">Programming</span></span>
        <span class="line-mask"><span class="line-inner">Contest <span class="text-gray-400">'26</span></span></span>
      </h1>

      <div class="hero-fade mt-10 flex flex-col md:flex-row md:items-end md:justify-between gap-10" style="--d:.9s">
        <p class="max-w-md text-sm sm:text-base text-dim leading-relaxed">
          3rd edition — organized by the <span class="text-gray-200">UGV Programming Club</span>, supported by the Department of CSE,
          University of Global Village, Barishal. Three contests, one campus, one day: 29 August 2026.
        </p>

        <!-- countdown -->
        <div data-testid="countdown-timer" class="flex gap-3 sm:gap-4">
          <div class="count-cell"><span id="cd-days" data-testid="countdown-days" class="count-num">00</span><span class="count-label">DAYS</span></div>
          <div class="count-cell"><span id="cd-hours" data-testid="countdown-hours" class="count-num">00</span><span class="count-label">HRS</span></div>
          <div class="count-cell"><span id="cd-mins" data-testid="countdown-mins" class="count-num">00</span><span class="count-label">MIN</span></div>
          <div class="count-cell"><span id="cd-secs" data-testid="countdown-secs" class="count-num text-neon">00</span><span class="count-label">SEC</span></div>
        </div>
      </div>

      <div class="hero-fade mt-12 flex flex-wrap items-center gap-5" style="--d:1.1s">
        <a href="{{ route('register') }}" data-testid="hero-register-btn" class="bg-neon text-black font-bold px-8 py-4 text-sm tracking-[0.2em] btn-hard">REGISTER YOUR TEAM</a>
        <a href="#segments" data-testid="hero-explore-btn" class="nav-anchor border border-white/20 px-8 py-4 text-sm tracking-[0.2em] text-gray-200 hover:border-cyber hover:text-cyber transition-colors duration-300">EXPLORE SEGMENTS →</a>
        <span class="text-xs text-dim">29 Aug 2026 · UGV Campus, Barishal</span>
      </div>
    </div>

    <div class="hero-fade absolute bottom-6 left-1/2 -translate-x-1/2 text-dim text-xs tracking-[0.4em]" style="--d:1.4s">SCROLL ▼</div>
  </section>

  <!-- ================= MARQUEE ================= -->
  <div class="marquee border-y border-white/15 py-5 overflow-hidden select-none" aria-hidden="true">
    <div class="marquee-track font-display font-800 text-3xl sm:text-4xl uppercase whitespace-nowrap">
      <span class="outline-text mx-4">Code</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Solve</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Quiz</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Compete</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Code</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Solve</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Quiz</span><span class="text-neon mx-4">•</span>
      <span class="outline-text mx-4">Compete</span><span class="text-neon mx-4">•</span>
    </div>
  </div>

  <!-- ================= UNIVERSITIES STRIP ================= -->
  <div class="marquee border-b border-white/15 py-4 overflow-hidden select-none" aria-hidden="true" data-testid="university-marquee">
    <div class="marquee-track-reverse text-xs sm:text-sm tracking-[0.3em] whitespace-nowrap">
      <span class="uni-name mx-5">UNIVERSITY OF GLOBAL VILLAGE</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">BARISHAL UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">PATUAKHALI SCIENCE & TECHNOLOGY UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">GSTU</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">KUET</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">PUST</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">KHULNA UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">+ OTHER SOUTH ZONE UNIVERSITIES</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">UNIVERSITY OF GLOBAL VILLAGE</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">BARISHAL UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">PATUAKHALI SCIENCE & TECHNOLOGY UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">GSTU</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">KUET</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">PUST</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">KHULNA UNIVERSITY</span><span class="text-neon mx-1">•</span>
      <span class="uni-name mx-5">+ OTHER SOUTH ZONE UNIVERSITIES</span><span class="text-neon mx-1">•</span>
    </div>
  </div>

  <!-- ================= MANIFESTO / ABOUT ================= -->
  <section id="about" class="py-24 lg:py-32 blueprint-x section-lift">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <p class="reveal text-neon text-sm font-medium mb-4">About</p>
      <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight max-w-3xl leading-tight" style="--d:.1s">
        A quieter stage for <span class="text-neon">sharp minds</span> and competitive craft.
      </h2>

      <div class="mt-16 grid grid-cols-1 md:grid-cols-12 gap-8">
        <div class="reveal md:col-span-4 border-l-2 border-neon pl-6" style="--d:.1s">
          <span class="font-display font-900 text-5xl outline-text">01</span>
          <h3 class="font-display font-700 text-lg mt-4 mb-3 tracking-widest uppercase">The Arena</h3>
          <p class="text-sm text-dim leading-relaxed">Every year the South Zone's best programmers scatter across local contests and disappear. SZPC pulls them into one room — UGV's CSE labs — under one clock, one problem set, one leaderboard.</p>
        </div>
        <div class="reveal md:col-span-4 md:col-start-6 border-l-2 border-cyber pl-6 md:mt-16" style="--d:.25s">
          <span class="font-display font-900 text-5xl outline-text">02</span>
          <h3 class="font-display font-700 text-lg mt-4 mb-3 tracking-widest uppercase">The Craft</h3>
          <p class="text-sm text-dim leading-relaxed">An online preliminary filters the field; the onsite final decides it. Nine problems, three hours, no shortcuts — set by UGV's own problem-setting committee to reward clean algorithmic thinking.</p>
        </div>
        <div class="reveal md:col-span-4 md:col-start-9 border-l-2 border-neon pl-6 md:mt-32" style="--d:.4s">
          <span class="font-display font-900 text-5xl outline-text">03</span>
          <h3 class="font-display font-700 text-lg mt-4 mb-3 tracking-widest uppercase">The Pipeline</h3>
          <p class="text-sm text-dim leading-relaxed">From class 6 to final year: the Junior Programming Contest and ICT Talent Hunt bring school, college and polytechnic students onto the same campus on the same day. The zone's talent pipeline starts here.</p>
        </div>
      </div>

      <!-- stats strip -->
      <div class="reveal mt-24 grid grid-cols-2 lg:grid-cols-4 border border-white/10 divide-x divide-y lg:divide-y-0 divide-white/10" style="--d:.2s" data-testid="stats-strip">
        <div class="stat-cell"><span class="stat-num">03</span><span class="stat-label">CONTESTS</span></div>
        <div class="stat-cell"><span class="stat-num">500+</span><span class="stat-label">PARTICIPANTS EXPECTED</span></div>
        <div class="stat-cell"><span class="stat-num">35+</span><span class="stat-label">INSTITUTIONS</span></div>
        <div class="stat-cell"><span class="stat-num text-neon">29 AUG</span><span class="stat-label">ONE MEGA DAY</span></div>
      </div>
    </div>
  </section>

  <!-- ================= SEGMENTS ================= -->
  <section id="segments" class="py-24 lg:py-32 border-t border-white/15">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
        <div>
          <p class="reveal text-neon text-sm font-medium mb-4">Contest segments</p>
          <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight" style="--d:.1s">Three ways to<br />enter the arena.</h2>
        </div>
        <p class="reveal max-w-sm text-sm text-dim leading-relaxed" style="--d:.2s">One flagship university contest, a junior track, and an ICT quiz — the whole South Zone pipeline on one campus, one day.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- flagship -->
        <article class="reveal segment-card md:col-span-7 group" data-testid="segment-card-programming">
          <!-- <img src="https://images.unsplash.com/photo-1551033406-611cf9a28f67?q=80&w=1600&auto=format&fit=crop" alt="Programming contest" class="segment-img" loading="lazy" /> -->
          <div class="relative z-10 flex flex-col h-full justify-between min-h-[26rem]">
            <div class="flex items-start justify-between">
              <span class="tag-chip border-neon text-neon">FLAGSHIP · UNIVERSITY</span>
              <span class="tag-chip border-white/20 text-dim">ONLINE + ONSITE</span>
            </div>
            <div>
              <h3 class="font-display font-800 text-2xl sm:text-4xl uppercase mb-4 group-hover:text-neon transition-colors duration-300">SZPC-2026</h3>
              <p class="text-sm text-dim max-w-md mb-6">The 3rd South Zone Programming Contest. Online prelim 22 Aug (2h, 5 problems), then a 3-hour, 9-problem onsite final at UGV's CSE labs. C, C++, Java or Python.</p>
              <div class="grid grid-cols-3 gap-4 text-xs border-t border-white/10 pt-4">
                <div><span class="block text-dim tracking-widest mb-1">DATE</span>22 + 29 AUG</div>
                <div><span class="block text-dim tracking-widest mb-1">FEE</span>৳1,000 / TEAM</div>
                <div><span class="block text-dim tracking-widest mb-1">VENUE</span>UGV CSE LABS (B2)</div>
              </div>
              <a href="segment.html?s=szpc" data-testid="segment-link-programming" class="seg-details">FULL RULES &amp; PRIZES →</a><button type="button" class="copy-link-btn" data-copy="/register?c=szpc" data-testid="copy-link-szpc">⧉ COPY REG LINK</button>
            </div>
          </div>
        </article>

        <!-- junior programming contest -->
        <article class="reveal segment-card md:col-span-5 group" data-testid="segment-card-jpc" style="--d:.15s">
          <div class="relative z-10 flex flex-col h-full justify-between min-h-[26rem]">
            <div class="flex items-start justify-between">
              <span class="tag-chip border-cyber text-cyber">JUNIOR TRACK</span>
              <span class="tag-chip border-white/20 text-dim">2–3 MEMBERS</span>
            </div>
            <div>
              <h3 class="font-display font-800 text-2xl sm:text-3xl uppercase mb-4 group-hover:text-cyber transition-colors duration-300">Junior Programming</h3>
              <p class="text-sm text-dim mb-6">School, college & polytechnic teams solve levelled problems. Online prelim 20 Aug (Scratch allowed), onsite final 29 Aug in the junior lab block.</p>
              <div class="grid grid-cols-2 gap-4 text-xs border-t border-white/10 pt-4">
                <div><span class="block text-dim tracking-widest mb-1">DATE</span>20 + 29 AUG</div>
                <div><span class="block text-dim tracking-widest mb-1">FEE</span>৳500 / TEAM</div>
              </div>
              <a href="segment.html?s=jpc" data-testid="segment-link-jpc" class="seg-details">FULL RULES &amp; PRIZES →</a><button type="button" class="copy-link-btn" data-copy="/register?c=jpc" data-testid="copy-link-jpc">⧉ COPY REG LINK</button>
            </div>
          </div>
        </article>

        <!-- ict talent hunt quiz -->
        <article class="reveal segment-card md:col-span-12 group" data-testid="segment-card-quiz">
          <div class="relative z-10 flex flex-col h-full justify-between min-h-[20rem]">
            <div class="flex items-start justify-between">
              <span class="tag-chip border-neon text-neon">BUZZER FINAL</span>
              <span class="tag-chip border-white/20 text-dim">INDIVIDUAL · SCHOOL & COLLEGE</span>
            </div>
            <div>
              <h3 class="font-display font-800 text-2xl sm:text-3xl uppercase mb-4 group-hover:text-neon transition-colors duration-300">ICT Talent Hunt Quiz</h3>
              <p class="text-sm text-dim max-w-xl mb-6">An individual ICT knowledge showdown: written screening on 20 Aug, top 8 per category reach the live buzzer final in the UGV auditorium on 29 Aug, 3:00 PM.</p>
              <div class="grid grid-cols-3 gap-4 text-xs border-t border-white/10 pt-4 max-w-2xl">
                <div><span class="block text-dim tracking-widest mb-1">DATE</span>20 + 29 AUG</div>
                <div><span class="block text-dim tracking-widest mb-1">FEE</span>৳100 / PERSON</div>
                <div><span class="block text-dim tracking-widest mb-1">VENUE</span>AUDITORIUM</div>
              </div>
              <a href="segment.html?s=ithq" data-testid="segment-link-ithq" class="seg-details">FULL RULES &amp; PRIZES →</a><button type="button" class="copy-link-btn" data-copy="/register?c=ithq" data-testid="copy-link-ithq">⧉ COPY REG LINK</button>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ================= SCHEDULE ================= -->
  <section id="schedule" class="py-24 lg:py-32 border-t border-white/15 blueprint-x section-lift">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12">
      <div class="lg:col-span-4">
        <p class="reveal text-neon text-sm font-medium mb-4">Schedule</p>
        <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight sticky top-28" style="--d:.1s">Slowly,<br />then all<br />at once.</h2>
      </div>
      <div class="lg:col-span-8">
        <ol class="relative border-l border-white/15 ml-2">
          <li class="reveal timeline-item" data-testid="timeline-item-1">
            <span class="timeline-dot"></span>
            <span class="timeline-date">23 JUL 2026</span>
            <h3 class="timeline-title">SZPC registration opens</h3>
            <p class="timeline-desc">University teams across the South Zone start reserving slots for the online preliminary round.</p>
          </li>
          <li class="reveal timeline-item" data-testid="timeline-item-2" style="--d:.1s">
            <span class="timeline-dot"></span>
            <span class="timeline-date">27 JUL 2026</span>
            <h3 class="timeline-title">JPC & ITHQ registration opens</h3>
            <p class="timeline-desc">Junior teams (school, college, polytechnic) and individual quiz participants join the roster.</p>
          </li>
          <li class="reveal timeline-item" data-testid="timeline-item-3" style="--d:.2s">
            <span class="timeline-dot"></span>
            <span class="timeline-date">17–20 AUG 2026</span>
            <h3 class="timeline-title">Registration closes</h3>
            <p class="timeline-desc">JPC & ITHQ close 17 August; SZPC closes 20 August at 23:59 BST.</p>
          </li>
          <li class="reveal timeline-item" data-testid="timeline-item-4" style="--d:.3s">
            <span class="timeline-dot"></span>
            <span class="timeline-date">20 AUG 2026</span>
            <h3 class="timeline-title">Junior prelim + quiz screening</h3>
            <p class="timeline-desc">JPC online preliminary (1.5h, 4 problems) and the ITHQ written screening round run side by side.</p>
          </li>
          <li class="reveal timeline-item" data-testid="timeline-item-5" style="--d:.4s">
            <span class="timeline-dot"></span>
            <span class="timeline-date">22 AUG 2026</span>
            <h3 class="timeline-title">SZPC online preliminary</h3>
            <p class="timeline-desc">University teams fight for onsite slots: 2 hours, 5 problems, in C, C++, Java or Python.</p>
          </li>
          <li class="reveal timeline-item" data-testid="timeline-item-6" style="--d:.5s">
            <span class="timeline-dot border-neon"></span>
            <span class="timeline-date text-neon">29 AUG 2026</span>
            <h3 class="timeline-title">Finals day at UGV</h3>
            <p class="timeline-desc">All three finals onsite — SZPC 9:15 AM, JPC in the junior lab block, quiz buzzer final 3:00 PM — then the combined prize-giving ceremony.</p>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <!-- ================= PRIZE POOL ================= -->
  <section id="prizes" class="py-24 lg:py-32 border-t border-white/15 relative overflow-hidden section-lift">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.12),transparent_65%)]"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-left">
      <p class="reveal text-neon text-sm font-medium mb-4">Prizes & recognition</p>
      <h2 class="reveal font-display font-900 uppercase leading-none text-[13vw] lg:text-[8rem] tracking-tight" style="--d:.1s" data-testid="prize-pool-amount">
        <span class="text-neon glow-neon">TROPHIES</span><span class="outline-text">+</span>
      </h2>
      <p class="reveal text-dim text-sm mt-4 tracking-[0.2em]" style="--d:.2s">CHAMPION & RUNNER-UP TROPHIES IN EVERY CATEGORY · CERTIFICATES FOR ALL PARTICIPANTS</p>

      <div class="mt-16 grid grid-cols-2 lg:grid-cols-4 border border-white/10 divide-x divide-y lg:divide-y-0 divide-white/10">
        <div class="reveal prize-cell" data-testid="prize-programming"><span class="prize-amt">SZPC</span><span class="prize-label">CHAMPION + RUNNER-UP TROPHIES</span><span class="prize-sub">UNIVERSITY LEVEL</span></div>
        <div class="reveal prize-cell" data-testid="prize-hackathon" style="--d:.1s"><span class="prize-amt">JPC</span><span class="prize-label">TROPHIES PER CATEGORY</span><span class="prize-sub">SCHOOL / COLLEGE / POLYTECHNIC</span></div>
        <div class="reveal prize-cell" data-testid="prize-esports" style="--d:.2s"><span class="prize-amt">ITHQ</span><span class="prize-label">TROPHIES PER CATEGORY</span><span class="prize-sub">SCHOOL / COLLEGE + STREAK AWARD</span></div>
        <div class="reveal prize-cell" data-testid="prize-quiz" style="--d:.3s"><span class="prize-amt">ALL</span><span class="prize-label">CERTIFICATES</span><span class="prize-sub">PARTICIPATION + MERIT (TOP 10)</span></div>
      </div>
    </div>
  </section>

  <!-- ================= SPONSORS (hidden) =================
  <section id="sponsors" class="py-24 lg:py-32 border-t border-white/15">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
        <div>
          <p class="reveal text-neon text-sm font-medium mb-4">Sponsors</p>
          <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight" style="--d:.1s">The sponsor grid.</h2>
        </div>
        <a href="#contact" data-testid="sponsor-cta" class="reveal nav-anchor text-xs tracking-[0.25em] text-dim hover:text-neon transition-colors duration-300" style="--d:.2s">WANT YOUR LOGO HERE? →</a>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 border border-white/10" data-testid="sponsor-wall">
        <div class="sponsor-cell reveal"><span class="sponsor-name">C0DELAB</span></div>
        <div class="sponsor-cell reveal" style="--d:.05s"><span class="sponsor-name">NeuroTech</span></div>
        <div class="sponsor-cell reveal" style="--d:.1s"><span class="sponsor-name">DataNest.io</span></div>
        <div class="sponsor-cell reveal" style="--d:.15s"><span class="sponsor-name">PIXELFORGE</span></div>
        <div class="sponsor-cell reveal"><span class="sponsor-name">CloudSprint</span></div>
        <div class="sponsor-cell reveal" style="--d:.05s"><span class="sponsor-name">bitWise_</span></div>
        <div class="sponsor-cell reveal" style="--d:.1s"><span class="sponsor-name">QUANTUMLEAP</span></div>
        <div class="sponsor-cell reveal" style="--d:.15s"><span class="sponsor-name">GridCore</span></div>
      </div>
    </div>
  </section>
  -->

  <!-- ================= COMMITTEE ================= -->
  <section id="committee" class="py-24 lg:py-32 border-t border-white/15 blueprint-x section-lift">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
        <div>
          <p class="reveal text-neon text-sm font-medium mb-4">Organizing team</p>
          <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight" style="--d:.1s">Behind the system.</h2>
        </div>
        <p class="reveal max-w-sm text-sm text-dim leading-relaxed" style="--d:.2s">The faculty, engineers and club volunteers running three contests on one campus — organized by the UGV Programming Club with the Department of CSE.</p>
      </div>

      <div class="reveal tribute-card mb-6" data-testid="chief-patron-tribute-card">
        <span class="tribute-corner tl"></span><span class="tribute-corner tr"></span><span class="tribute-corner bl"></span><span class="tribute-corner br"></span>
        <div class="flex flex-col md:flex-row items-center gap-10">
          <div class="tribute-mono" data-testid="chief-patron-monogram">IC</div>
          <div class="flex-1 text-center md:text-left">
            <p class="text-neon text-sm font-medium mb-4">Chief patron</p>
            <h3 class="font-display font-900 text-3xl sm:text-4xl lg:text-5xl uppercase tracking-tight leading-tight">Dr. Md. <span class="text-neon glow-neon">Imran Chowdhury</span></h3>
            <p class="mt-5 text-sm sm:text-base text-dim leading-relaxed max-w-2xl md:mx-0 mx-auto">The visionary force behind UGV — as Chairman of the Board of Trustees, his push for technology education in the South Zone made an arena like SZPC possible on this campus.</p>
            <p class="mt-6 text-sm text-dim" data-testid="chief-patron-status-line">Supporting the South Zone programming community.</p>
          </div>
        </div>
      </div>

      <div class="reveal tribute-card mb-6" data-testid="patron-tribute-card" style="--d:.05s">
        <span class="tribute-corner tl"></span><span class="tribute-corner tr"></span><span class="tribute-corner bl"></span><span class="tribute-corner br"></span>
        <div class="flex flex-col md:flex-row items-center gap-10">
          <div class="tribute-mono" data-testid="patron-monogram">AB</div>
          <div class="flex-1 text-center md:text-left">
            <p class="text-neon text-sm font-medium mb-4">Patron</p>
            <h3 class="font-display font-900 text-3xl sm:text-4xl lg:text-5xl uppercase tracking-tight leading-tight">Dr. <span class="text-neon glow-neon">Abdul Baqee</span></h3>
            <p class="mt-5 text-sm sm:text-base text-dim leading-relaxed max-w-2xl md:mx-0 mx-auto">At the academic helm of UGV — the Vice Chancellor's backing turned a departmental programming contest into a zone-wide talent hunt, from school classrooms to university labs.</p>
            <p class="mt-6 text-sm text-dim" data-testid="patron-status-line">Backing teams across the South Zone.</p>
          </div>
        </div>
      </div>

      <div class="reveal tribute-card mb-16" data-testid="advisor-tribute-card" style="--d:.15s">
        <span class="tribute-corner tl"></span><span class="tribute-corner tr"></span><span class="tribute-corner bl"></span><span class="tribute-corner br"></span>
        <div class="flex flex-col md:flex-row items-center gap-10">
          <div class="tribute-mono" data-testid="advisor-monogram">MK</div>
          <div class="flex-1 text-center md:text-left">
            <p class="text-neon text-sm font-medium mb-4">Chief advisor</p>
            <h3 class="font-display font-900 text-3xl sm:text-4xl lg:text-5xl uppercase tracking-tight leading-tight">Prof. Dr. <span class="text-neon glow-neon">M. Kaykobad</span></h3>
            <p class="mt-5 text-sm sm:text-base text-dim leading-relaxed max-w-2xl md:mx-0 mx-auto">The godfather of competitive programming in Bangladesh — the mentor who put Bangladeshi teams on the world ICPC map and inspired a generation of problem solvers. SZPC '26 is honored to run under his guidance.</p>
            <p class="mt-6 text-sm text-dim" data-testid="advisor-status-line">Guiding the next generation of competitive programmers.</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 pb-4" data-testid="committee-leadership-grid">
        <div class="reveal leader-card" data-testid="leader-card-convener"><span class="leader-role">CONVENER</span><span class="leader-name">Md Riadul Islam</span><span class="leader-desig">Head, Department of CSE</span></div>
        <div class="reveal leader-card" data-testid="leader-card-member-secretary" style="--d:.05s"><span class="leader-role">MEMBER SECRETARY</span><span class="leader-name">Partho Sarathi Sarker</span><span class="leader-desig">Co-Head, Department of CSE</span></div>
        <div class="reveal leader-card" data-testid="leader-card-contest-director" style="--d:.1s"><span class="leader-role">CONTEST DIRECTOR</span><span class="leader-name">Md Zahid Akon</span><span class="leader-desig">Contest Director</span></div>
      </div>

      <!-- Sub-committees only (hidden; main committee section above stays visible) -->
      <p class="reveal text-cyber text-sm font-medium mt-20 mb-6">Sub-committees</p>
      <dl class="reveal border-t border-white/10" style="--d:.1s" data-testid="committee-subgrid">
        <div class="committee-row"><dt>JUDGING — SZPC & JPC</dt><dd>Md Zahid Akon · Saif Bashar Akash · Hasnat Sayed Mahfuzur Rahman · Hasanat Nihal</dd></div>
        <div class="committee-row"><dt>QUIZ — ITHQ</dt><dd>Md Tariqul Islam · Md Masudur Rahman Akash · Hasnat</dd></div>
        <div class="committee-row"><dt>TECHNICAL</dt><dd>Rafiqul Islam Rahat — IT Engineer</dd></div>
        <div class="committee-row"><dt>REGISTRATION</dt><dd>UGV Programming Club</dd></div>
        <div class="committee-row"><dt>SECURITY & DISCIPLINE</dt><dd>Md Tariqul Islam — Assistant Proctor</dd></div>
        <div class="committee-row"><dt>FINANCE · FOOD · TRANSPORT · PRIZE</dt><dd>Md. Gius Uddin Khan — Accountant</dd></div>
        <div class="committee-row"><dt>HOSPITALITY</dt><dd>Alomgir Hossain · Akash Hasnat</dd></div>
        <div class="committee-row"><dt>MEDIA</dt><dd>Md. Tariqur Rahman</dd></div>
        <div class="committee-row"><dt>PHOTOGRAPHY</dt><dd>Jayed Ibn Harun</dd></div>
        <div class="committee-row"><dt>VOLUNTEER & EMERGENCY</dt><dd>Md Zahid Akon · Md Mehedi Hasan · Sayed Mahfuzur Rahman</dd></div>
      </dl>
      -->
    </div>
  </section>

  <!-- ================= FAQ ================= -->
  <section id="faq" class="py-24 lg:py-32 border-t border-white/15 blueprint-x">
    <div class="max-w-5xl mx-auto px-6 lg:px-12">
      <p class="reveal text-neon text-sm font-medium mb-4">FAQ</p>
      <h2 class="reveal font-display font-800 text-3xl sm:text-5xl uppercase tracking-tight mb-14" style="--d:.1s">Query the system.</h2>

      <div class="border-t border-white/10">
        <div class="faq-item reveal" data-testid="faq-item-1">
          <button class="faq-q" data-testid="faq-question-1"><span><span class="text-neon mr-3">&gt;</span>Who can participate?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Three contests, three doors: SZPC-2026 for undergraduate teams of South Zone universities (UGV, BU, PSTU, GSTU, KUET, PUST, KU and others); the Junior Programming Contest for school, college & polytechnic teams; and the ICT Talent Hunt Quiz for individual school (class 6–10) and college (HSC) students.</p></div>
        </div>
        <div class="faq-item reveal" data-testid="faq-item-2" style="--d:.05s">
          <button class="faq-q" data-testid="faq-question-2"><span><span class="text-neon mr-3">&gt;</span>What are the team sizes?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>SZPC-2026 is a university team event (30–35 teams expected). Junior contest teams have 2–3 members from the same institution. The ICT Talent Hunt Quiz is strictly individual.</p></div>
        </div>
        <div class="faq-item reveal" data-testid="faq-item-3" style="--d:.1s">
          <button class="faq-q" data-testid="faq-question-3"><span><span class="text-neon mr-3">&gt;</span>How much is the registration fee?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>SZPC-2026: ৳1,000 per team · JPC-2026: ৳500 per team · ITHQ-2026: ৳100 per person. After submitting the form, the registration committee (UGV Programming Club) contacts you with payment instructions. <span class="text-cyber">(This demo site does not process real payments.)</span></p></div>
        </div>
        <div class="faq-item reveal" data-testid="faq-item-4" style="--d:.15s">
          <button class="faq-q" data-testid="faq-question-4"><span><span class="text-neon mr-3">&gt;</span>Is there an online qualifier?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Yes. SZPC runs an online preliminary on 22 August (2h, 5 problems). The Junior prelim is 20 August (1.5h, Scratch allowed) and the quiz has a written screening the same day. All finals are onsite at UGV on 29 August.</p></div>
        </div>
        <div class="faq-item reveal" data-testid="faq-item-5" style="--d:.2s">
          <button class="faq-q" data-testid="faq-question-5"><span><span class="text-neon mr-3">&gt;</span>What should we bring on contest day?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Your institutional ID card, the confirmation email, and your own keyboard/mouse if you prefer. Workstations, printed problem sets, snacks and unlimited coffee are on us.</p></div>
        </div>
        <div class="faq-item reveal" data-testid="faq-item-6" style="--d:.25s">
          <button class="faq-q" data-testid="faq-question-6"><span><span class="text-neon mr-3">&gt;</span>Will participants get certificates?</span><span class="faq-icon">+</span></button>
          <div class="faq-a"><p>Every registered participant gets a certificate of participation. Top 10 junior teams per category in the preliminary earn merit certificates, and the quiz's fastest correct-answer streak gets special recognition at the 29 August ceremony.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= REGISTER (hidden) =================
  <section id="register" class="py-24 lg:py-32 border-t border-white/15 relative overflow-hidden section-lift">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.1),transparent_60%)]"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-14">
      <div class="lg:col-span-5">
        <p class="reveal text-neon text-sm font-medium mb-4">Registration</p>
        <h2 class="reveal font-display font-800 text-3xl sm:text-5xl tracking-tight leading-tight" style="--d:.1s">Ready to<br />compete?</h2>
        <p class="reveal text-sm text-dim leading-relaxed mt-6 max-w-sm" style="--d:.2s">Choose your contest, assemble your team, and submit your registration. Finals day: 29 August 2026 — one campus, three contests.</p>
        <div class="reveal mt-10 border border-white/10 p-5 text-sm text-dim leading-relaxed space-y-2" style="--d:.3s">
          <p><span class="text-gray-200 font-medium">Expected teams:</span> 30–35 SZPC · 60–70 JPC</p>
          <p><span class="text-gray-200 font-medium">Deadline:</span> 17–20 Aug 2026</p>
          <p><span class="text-neon font-medium">Status:</span> Open for registration</p>
        </div>
      </div>

      <div class="lg:col-span-7">
        <div class="reveal border border-neon bg-panel/80 p-10 backdrop-blur flex flex-col justify-center" style="--d:.2s" data-testid="home-register-cta">
          <p class="text-neon text-sm font-medium mb-4">Register your team</p>
          <p class="text-sm text-dim leading-relaxed mb-8 max-w-md">Complete the registration form on its own page — pick your contest and enter your team details.</p>
          <a href="{{ route('register') }}" data-testid="home-open-registration-button" class="inline-block w-full text-center bg-neon text-black font-bold py-4 text-sm btn-hard">Open registration form</a>
          <p class="mt-4 text-[10px] text-dim tracking-widest text-center">FEES: ৳1,000 SZPC · ৳500 JPC · ৳100 ITHQ</p>
        </div>
      </div>
    </div>
  </section>
  -->

  <!-- ================= FOOTER / CONTACT ================= -->
  <footer id="contact" class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-20 grid grid-cols-1 md:grid-cols-12 gap-12">
      <div class="md:col-span-5">
        <a href="#top" data-testid="footer-logo" class="nav-anchor flex items-center gap-3 mb-6">
          <span class="w-9 h-9 border border-neon flex items-center justify-center text-neon font-display font-bold text-sm">SZ</span>
          <span class="font-display font-800 tracking-widest">SZPC<span class="text-neon">'26</span></span>
        </a>
        <p class="text-sm text-dim leading-relaxed max-w-sm">3rd UGV South Zone Programming Contest & ICT Talent Hunt — organized by the UGV Programming Club, supported by the Department of CSE, University of Global Village, Barishal, Bangladesh.</p>
      </div>
      <div class="md:col-span-3">
        <h4 class="text-xs tracking-[0.3em] text-dim mb-5">CONTACT</h4>
        <ul class="text-sm space-y-3">
          <li><a href="mailto:szpc@ugv.edu.bd" data-testid="contact-email" class="hover:text-neon transition-colors duration-300">szpc@ugv.edu.bd</a></li>
          <li><a href="tel:+8801700000000" data-testid="contact-phone" class="hover:text-neon transition-colors duration-300">+880 1700-000000</a></li>
          <li class="text-dim">CSE Dept., UGV Campus,<br />Barishal 8200, Bangladesh</li>
        </ul>
      </div>
      <div class="md:col-span-4">
        <h4 class="text-xs tracking-[0.3em] text-dim mb-5">SITEMAP</h4>
        <ul class="text-sm space-y-3 columns-2">
          <li><a href="#about" data-testid="footer-link-about" class="nav-anchor hover:text-neon transition-colors duration-300">About</a></li>
          <li><a href="#segments" data-testid="footer-link-segments" class="nav-anchor hover:text-neon transition-colors duration-300">Segments</a></li>
          <li><a href="#schedule" data-testid="footer-link-schedule" class="nav-anchor hover:text-neon transition-colors duration-300">Schedule</a></li>
          <li><a href="#prizes" data-testid="footer-link-prizes" class="nav-anchor hover:text-neon transition-colors duration-300">Prizes</a></li>
          <!-- <li><a href="#sponsors" data-testid="footer-link-sponsors" class="nav-anchor hover:text-neon transition-colors duration-300">Sponsors</a></li> -->
          <li><a href="#committee" data-testid="footer-link-committee" class="nav-anchor hover:text-neon transition-colors duration-300">Team</a></li>
          <li><a href="#faq" data-testid="footer-link-faq" class="nav-anchor hover:text-neon transition-colors duration-300">FAQ</a></li>
          <li><a href="{{ route('register') }}" data-testid="footer-link-register" class="hover:text-neon transition-colors duration-300">Register</a></li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[10px] tracking-[0.25em] text-dim">
        <span>© <span id="year">2026</span> DEPT. OF CSE, UNIVERSITY OF GLOBAL VILLAGE</span>
        <span>South Zone Programming Contest · University of Global Village</span>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
html>
</html>
html>
