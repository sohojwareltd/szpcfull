<!doctype html>
<html lang="en">
<head>
  @include('partials.site-head', ['seoPage' => $seoPage ?? 'success'])
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

        @if (session('payment_message'))
          <p class="mt-6 text-sm text-gray-100 border border-neon/30 rounded-lg px-4 py-3 bg-neon/10">{{ session('payment_message') }}</p>
        @endif

        @if ($isIthq)
          @include('partials.ithq-bkash-instructions', [
            'referenceCode' => $reg['reference_code'],
            'feeAmount' => config('services.contest_payment.fees.ITHQ-2026'),
          ])

          <form
            method="post"
            action="{{ route('payment.transaction', $reg['reference_code']) }}"
            class="mt-6 border border-white/10 rounded-lg p-5 bg-surface/40"
            data-testid="payment-transaction-form"
          >
            @csrf
            <label for="payment_transaction_id" class="register-panel field-label block mb-2">bKash transaction ID</label>
            <input
              type="text"
              name="payment_transaction_id"
              id="payment_transaction_id"
              class="register-panel field-input w-full"
              placeholder="e.g. 8N90ABCD12"
              value="{{ old('payment_transaction_id') }}"
              required
              autocomplete="off"
            />
            @error('payment_transaction_id')
              <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
            <button type="submit" class="mt-4 w-full sm:w-auto bg-neon text-black font-bold py-3 px-6 text-sm rounded-lg btn-hard">Submit transaction ID</button>
          </form>

          <p class="mt-6 text-sm text-dim leading-relaxed">
            You can return anytime to check verification status:
            <a href="{{ route('payment.show', $reg['reference_code']) }}" class="text-neon hover:underline">payment status page</a>.
          </p>
        @else
          <p class="mt-8 text-sm text-gray-200 leading-relaxed">
            Save your reference code. The registration committee will contact you at the number above with payment instructions, usually within 48 hours.
          </p>
          <p class="mt-4 text-sm text-dim">
            Track progress anytime on the
            <a href="{{ route('payment.show', $reg['reference_code']) }}" class="text-neon hover:underline">payment &amp; status page</a>.
          </p>
        @endif

        <p class="mt-4 text-sm text-dim">Finals day: 29 August 2026 — University of Global Village, Barishal.</p>

        <div class="mt-10 flex flex-col sm:flex-row gap-4">
          <a href="{{ route('register') }}" class="inline-flex justify-center bg-neon text-black font-bold py-3.5 px-6 text-sm rounded-lg btn-hard">Register another entry</a>
          <a href="{{ route('payment') }}" class="inline-flex justify-center border border-white/25 px-6 py-3.5 text-sm font-medium rounded-lg text-gray-100 hover:border-neon hover:text-neon transition-colors duration-300">Payment lookup</a>
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
