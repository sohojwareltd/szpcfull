<!doctype html>
<html lang="en">
<head>
  @include('partials.site-head', [
    'seoPage' => $seoPage ?? 'home',
    'seoTitle' => $seoTitle ?? null,
  ])
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: { void: '#1a1d24', surface: '#242830', panel: '#2d333d', elevated: '#363d49', neon: '#00FF41', cyber: '#00F0FF', dim: '#b4bcc8' },
        fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'] },
      } },
    };
  </script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" />
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
        <a href="{{ route('home') }}#segments" data-testid="back-to-home-link" class="border border-white/20 px-5 py-2 text-xs tracking-[0.2em] text-gray-200 hover:border-neon hover:text-neon transition-colors duration-300">← MAIN SITE</a>
      </div>
    </div>
  </header>

  <main id="segment-root"></main>

  <footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[10px] tracking-[0.25em] text-dim">
      <span>© {{ date('Y') }} DEPT. OF CSE, UNIVERSITY OF GLOBAL VILLAGE</span>
      <span>South Zone Programming Contest · University of Global Village</span>
    </div>
  </footer>

  <script>
    window.SZPC_ROUTES = {
      home: @json(route('home')),
      homeSegments: @json(route('home').'#segments'),
      register: @json(route('register')),
    };
  </script>
  <script src="{{ asset('js/segment.js') }}?v={{ filemtime(public_path('js/segment.js')) }}"></script>
</body>
</html>
