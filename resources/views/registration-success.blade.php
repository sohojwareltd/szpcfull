<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#1a1d24" />
  <meta name="description" content="Registration submitted — SZPC '26 | UGV Contest Registration 2026." />
  <title>Registration received — SZPC '26</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%23050505'/%3E%3Ctext x='6' y='24' font-family='monospace' font-size='20' fill='%2300FF41'%3E%3E_%3C/text%3E%3C/svg%3E" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: { void: '#1a1d24', surface: '#242830', panel: '#2d333d', elevated: '#363d49', neon: '#00FF41', cyber: '#00F0FF', dim: '#b4bcc8' },
        fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'] },
      } },
    };
  </script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="bg-void text-gray-100 font-sans antialiased selection:bg-neon selection:text-black">
  <div class="noise-overlay" aria-hidden="true"></div>

  <header class="fixed top-0 left-0 right-0 z-50 border-b border-white/15 bg-surface/85 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
      <a href="{{ route('home') }}" data-testid="nav-logo" class="flex items-center gap-3 group">
        <span class="w-8 h-8 border border-neon flex items-center justify-center text-neon font-display font-bold text-sm group-hover:bg-neon group-hover:text-black transition-colors duration-300">SZ</span>
        <span class="font-display font-800 tracking-widest text-sm">SZPC<span class="text-neon">'26</span></span>
      </a>
      <div class="flex items-center gap-6">
        <a href="{{ route('home') }}" class="border border-white/20 px-5 py-2 text-xs tracking-[0.2em] text-gray-200 hover:border-neon hover:text-neon transition-colors duration-300">← MAIN SITE</a>
      </div>
    </div>
  </header>

  <main class="blueprint-x min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.12),transparent_60%)]"></div>
    <div class="max-w-2xl mx-auto px-6 lg:px-12 pt-32 pb-24 w-full" data-testid="registration-success-page">
      <div class="register-success-panel border border-neon/40 bg-panel/80 backdrop-blur p-8 sm:p-10">
        <p class="text-neon text-sm font-medium mb-2">Registration submitted</p>
        <h1 class="font-display font-800 text-2xl sm:text-3xl tracking-tight mb-6">You&apos;re on the list</h1>

        <dl class="text-sm space-y-3 border border-white/10 rounded-lg p-5 bg-surface/50">
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Reference code</dt>
            <dd class="text-gray-100 font-mono text-neon tracking-wider">{{ $reg['reference_code'] }}</dd>
          </div>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Contest</dt>
            <dd class="text-gray-100">{{ $reg['contest_type'] }}</dd>
          </div>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Contact phone</dt>
            <dd class="text-gray-100">{{ $reg['phone'] }}</dd>
          </div>
        </dl>

        <p class="mt-8 text-sm text-gray-200 leading-relaxed">
          Save your reference code. The registration committee will contact you at the number above with payment instructions, usually within 48 hours.
        </p>
        <p class="mt-4 text-sm text-dim">Finals day: 29 August 2026 — University of Global Village, Barishal.</p>

        <div class="mt-10 flex flex-col sm:flex-row gap-4">
          <a href="{{ route('register') }}" class="inline-flex justify-center bg-neon text-black font-bold py-3.5 px-6 text-sm rounded-lg btn-hard">Register another entry</a>
          <a href="{{ route('home') }}" class="inline-flex justify-center border border-white/25 px-6 py-3.5 text-sm font-medium rounded-lg text-gray-100 hover:border-neon hover:text-neon transition-colors duration-300">Back to main site</a>
        </div>
      </div>
    </div>
  </main>

  <footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[10px] tracking-[0.25em] text-dim">
      <span>© {{ date('Y') }} DEPT. OF CSE, UNIVERSITY OF GLOBAL VILLAGE</span>
      <span>South Zone Programming Contest · University of Global Village</span>
    </div>
  </footer>
</body>
</html>
