<!doctype html>
<html lang="en">
<head>
  @include('partials.site-head', ['seoPage' => $seoPage ?? 'payment'])
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
      <a href="{{ route('home') }}" class="flex items-center gap-3 group">
        <span class="w-8 h-8 border border-neon flex items-center justify-center text-neon font-display font-bold text-sm group-hover:bg-neon group-hover:text-black transition-colors duration-300">SZ</span>
        <span class="font-display font-800 tracking-widest text-sm">SZPC<span class="text-neon">'26</span></span>
      </a>
      <div class="flex items-center gap-6">
        <a href="{{ route('register') }}" class="border border-white/20 px-5 py-2 text-xs tracking-[0.2em] text-gray-200 hover:border-neon hover:text-neon transition-colors duration-300">REGISTER</a>
      </div>
    </div>
  </header>

  <main class="blueprint-x min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.12),transparent_60%)]"></div>
    <div class="max-w-xl mx-auto px-6 lg:px-12 pt-32 pb-24 w-full" data-testid="payment-lookup-page">
      <div class="register-panel border border-neon/40 bg-panel/80 backdrop-blur p-8 sm:p-10">
        <p class="text-neon text-sm font-medium mb-2">Payment &amp; status</p>
        <h1 class="font-display font-800 text-2xl sm:text-3xl tracking-tight mb-4">Track your registration</h1>
        <p class="text-sm text-dim leading-relaxed mb-8">Enter the reference code from your registration confirmation email or success page to view progress and submit payment details.</p>

        <form method="post" action="{{ route('payment.lookup') }}" class="space-y-4" data-testid="payment-lookup-form">
          @csrf
          <div>
            <label for="reference_code" class="register-panel field-label block mb-2">Reference code</label>
            <input
              type="text"
              name="reference_code"
              id="reference_code"
              class="register-panel field-input w-full uppercase tracking-widest"
              placeholder="e.g. A1B2C3D4"
              value="{{ old('reference_code', $referencePrefill) }}"
              required
              autocomplete="off"
              maxlength="16"
            />
            @error('reference_code')
              <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
          </div>
          <button type="submit" class="w-full bg-neon text-black font-bold py-3.5 text-sm rounded-lg btn-hard">View status</button>
        </form>
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
