<!doctype html>
<html lang="en">
<head>
  @include('partials.site-head', ['seoPage' => $seoPage ?? 'register'])
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: { void: '#1a1d24', surface: '#242830', panel: '#2d333d', elevated: '#363d49', neon: '#00FF41', cyber: '#00F0FF', dim: '#b4bcc8' },
        fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'] },
      } },
    };
  </script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="bg-void text-gray-100 font-sans antialiased selection:bg-neon selection:text-black">
  <div class="noise-overlay" aria-hidden="true"></div>

  @if ($errors->any())
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-[60] max-w-lg w-[calc(100%-2rem)] form-error-banner">
      {{ $errors->first() }}
    </div>
  @endif

  <header class="fixed top-0 left-0 right-0 z-50 border-b border-white/15 bg-surface/85 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
      <a href="{{ route('home') }}" data-testid="nav-logo" class="flex items-center gap-3 group">
        <span class="w-8 h-8 border border-neon flex items-center justify-center text-neon font-display font-bold text-sm group-hover:bg-neon group-hover:text-black transition-colors duration-300">SZ</span>
        <span class="font-display font-800 tracking-widest text-sm">SZPC<span class="text-neon">'26</span></span>
      </a>
      <div class="flex items-center gap-6">
        <a href="{{ route('home') }}" data-testid="back-to-home-link" class="border border-white/20 px-5 py-2 text-xs tracking-[0.2em] text-gray-200 hover:border-neon hover:text-neon transition-colors duration-300">← MAIN SITE</a>
      </div>
    </div>
  </header>

  <main class="blueprint-x min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.12),transparent_60%)]"></div>
    <div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-12 pt-10 pb-24 flex flex-col gap-8 w-full" data-testid="register-page">

      <div class="register-page-header w-full px-4 sm:px-0 pb-10 border-b border-white/15">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-start mb-12">
       

        <!-- <p class="text-neon text-sm font-medium mb-8">How it works</p>
        <ol class="timeline-h" data-testid="register-steps-timeline">
          <li class="timeline-h-item">
            <span class="timeline-dot border-neon" aria-hidden="true"></span>
            <span class="timeline-date text-neon uppercase">Step 01</span>
            <h3 class="timeline-title text-base uppercase tracking-wide">Select contest</h3>
            <p class="timeline-desc">SZPC for universities, JPC for school/college/polytechnic teams, ITHQ for individual quiz participants.</p>
          </li>
          <li class="timeline-h-item">
            <span class="timeline-dot" aria-hidden="true"></span>
            <span class="timeline-date uppercase">Step 02</span>
            <h3 class="timeline-title text-base uppercase tracking-wide">Fill the details</h3>
            <p class="timeline-desc">Team info, member names, phone numbers and t-shirt sizes — the form branches to match your contest.</p>
          </li>
          <li class="timeline-h-item">
            <span class="timeline-dot" aria-hidden="true"></span>
            <span class="timeline-date uppercase">Step 03</span>
            <h3 class="timeline-title text-base uppercase tracking-wide">Submit</h3>
            <p class="timeline-desc">The registration committee (UGV Programming Club) contacts you with payment instructions.</p>
          </li>
        </ol> -->
      </div>

      <div class="register-panel w-full max-w-none border-y sm:border border-neon/40 bg-panel/80 backdrop-blur px-4 py-6 sm:p-8 lg:p-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-start mb-12">
          <div>
            <!-- <p class="text-neon text-sm font-medium mb-4">Team registration</p> -->
            <h1 class="font-display font-800 text-3xl sm:text-4xl lg:text-5xl tracking-tight leading-tight">Register your <span class="text-neon">team</span></h1>
            <!-- <p class="text-sm text-dim leading-relaxed mt-6 max-w-md">Choose your contest, enter your team details, and submit. Finals day: 29 August 2026 — one campus, three contests.</p> -->
          </div>
          </div>
        <div class="register-step">
          <h2 class="register-step-title">Step 1 — Choose your contest</h2>
          <p class="register-step-hint">Pick SZPC, JPC, or ITHQ. The form below updates with the fields you need.</p>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" data-testid="contest-type-selector">
          <button type="button" class="contest-card" data-contest="SZPC-2026" data-testid="contest-type-szpc">
            <span class="contest-card-name">SZPC-2026</span>
            <span class="contest-card-sub">University teams · ৳1,000</span>
          </button>
          <button type="button" class="contest-card" data-contest="JPC-2026" data-testid="contest-type-jpc">
            <span class="contest-card-name">JPC-2026</span>
            <span class="contest-card-sub">School / college · ৳500</span>
          </button>
          <button type="button" class="contest-card" data-contest="ITHQ-2026" data-testid="contest-type-ithq">
            <span class="contest-card-name">ITHQ-2026</span>
            <span class="contest-card-sub">Individual quiz · ৳100</span>
          </button>
        </div>
        </div>

        <form id="reg-form" data-testid="registration-form" class="hidden register-form-panel w-full max-w-none" method="post" action="{{ route('register.store') }}" novalidate>
          @csrf
          <input type="hidden" name="contest_type" id="contest-type-input" value="" />

          {{-- Honeypot: hidden from users; bots often fill every field --}}
          <div class="registration-honeypot" aria-hidden="true">
            <label for="company_website">Company website</label>
            <input type="text" name="company_website" id="company_website" value="" tabindex="-1" autocomplete="off" />
          </div>

          <div id="form-fields" data-testid="form-fields" class="w-full min-w-0"></div>
          <p id="form-error" data-testid="form-error-message" class="hidden mt-6 form-error-banner"></p>

          @if ($turnstileSiteKey)
            <div class="mt-6" data-testid="turnstile-widget">
              <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
              <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}" data-theme="dark"></div>
            </div>
          @endif

          <button type="submit" data-testid="form-submit-button" class="mt-8 w-full bg-neon text-black font-bold py-3.5 text-base rounded-lg btn-hard">Submit registration</button>
          <p class="mt-4 form-demo-note">Secure registration — stored for the organizing committee.</p>
        </form>

        <div id="reg-success" data-testid="registration-success" class="hidden register-success-panel">
          <p class="text-neon text-sm font-medium mb-6">Registration submitted</p>
          <div class="text-sm text-dim leading-relaxed space-y-1" id="success-log"></div>
          <p class="mt-8 text-sm text-gray-200">Our team will contact you within 48 hours with payment instructions. See you at the contest.</p>
          <button id="reg-again" data-testid="register-again-button" class="mt-8 border border-white/25 px-6 py-3 text-sm font-medium rounded-lg text-gray-100 hover:border-neon hover:text-neon transition-colors duration-300">Register another team</button>
        </div>
      </div>
    </div>
  </main>

  <footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[10px] tracking-[0.25em] text-dim">
      <span>© <span id="year">2026</span> DEPT. OF CSE, UNIVERSITY OF GLOBAL VILLAGE</span>
      <span>South Zone Programming Contest · University of Global Village</span>
    </div>
  </footer>

  <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
<script>
  window.SZPC_REGISTER = {
    storeUrl: @json(route('register.store')),
    csrf: @json(csrf_token()),
  };
</script>
  <script src="{{ asset('js/registration.js') }}"></script>
</body>
</html>
