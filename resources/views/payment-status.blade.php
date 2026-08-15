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
        <a href="{{ route('payment') }}" class="text-xs tracking-[0.15em] text-dim hover:text-neon transition-colors">LOOKUP</a>
        <a href="{{ route('register') }}" class="border border-white/20 px-5 py-2 text-xs tracking-[0.2em] text-gray-200 hover:border-neon hover:text-neon transition-colors duration-300">REGISTER</a>
      </div>
    </div>
  </header>

  <main class="blueprint-x min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,255,65,0.12),transparent_60%)]"></div>
    <div class="max-w-2xl mx-auto px-6 lg:px-12 pt-32 pb-24 w-full" data-testid="payment-status-page">
      <div class="register-success-panel border border-neon/40 bg-panel/80 backdrop-blur p-8 sm:p-10">
        <p class="text-neon text-sm font-medium mb-2">Registration status</p>
        <h1 class="font-display font-800 text-2xl sm:text-3xl tracking-tight mb-6">{{ $registration->displayName() }}</h1>

        @if (session('payment_message'))
          <p class="mb-6 text-sm text-gray-100 border border-neon/30 rounded-lg px-4 py-3 bg-neon/10" data-testid="payment-flash-message">{{ session('payment_message') }}</p>
        @endif

        <dl class="text-sm space-y-3 border border-white/10 rounded-lg p-5 bg-surface/50 mb-8">
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Reference code</dt>
            <dd class="text-gray-100 font-mono text-neon tracking-wider">{{ $registration->reference_code }}</dd>
          </div>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Contest</dt>
            <dd class="text-gray-100">{{ $registration->contest_type->value }}</dd>
          </div>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Fee</dt>
            <dd class="text-gray-100">৳{{ number_format($registration->contestFeeAmount()) }}</dd>
          </div>
          <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
            <dt class="text-dim">Payment status</dt>
            <dd class="@if ($registration->is_paid) text-neon @else text-amber-200 @endif font-medium">
              @if ($registration->is_paid)
                Paid
              @elseif ($registration->payment_transaction_id)
                Verification pending
              @else
                Unpaid
              @endif
            </dd>
          </div>
          @if ($registration->is_confirmed)
            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
              <dt class="text-dim">Final confirmation</dt>
              <dd class="text-neon font-medium">Confirmed</dd>
            </div>
          @endif
        </dl>

        <h2 class="register-step-title mb-4">Progress</h2>
        @include('partials.registration-progress', ['steps' => $registration->progressTimeline()])

        @include('partials.payment-submit-form', ['registration' => $registration])

        @if ($registration->is_paid)
          <p class="mt-8 text-sm text-gray-200 leading-relaxed">Your registration fee is verified. @if (! $registration->is_confirmed) The committee will confirm your spot before finals day. @else You are confirmed for finals day. @endif</p>
        @endif

        <div class="mt-10 flex flex-col sm:flex-row gap-4">
          <a href="{{ route('payment') }}" class="inline-flex justify-center border border-white/25 px-6 py-3.5 text-sm font-medium rounded-lg text-gray-100 hover:border-neon hover:text-neon transition-colors duration-300">Look up another code</a>
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
