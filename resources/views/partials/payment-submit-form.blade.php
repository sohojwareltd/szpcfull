@if ($registration->supportsBkashSelfPay() && ! $registration->is_paid)
  @include('partials.ithq-bkash-instructions', [
    'referenceCode' => $registration->reference_code,
    'feeAmount' => $registration->contestFeeAmount(),
  ])

  @if ($registration->payment_transaction_id)
    <p class="mt-4 text-sm text-gray-200">
      Transaction ID on file: <span class="font-mono text-neon">{{ $registration->payment_transaction_id }}</span>
      @if ($registration->payment_submitted_at)
        <span class="text-dim"> · submitted {{ $registration->payment_submitted_at->format('M j, Y g:i A') }}</span>
      @endif
    </p>
  @endif

  <form
    method="post"
    action="{{ route('payment.transaction', $registration->reference_code) }}"
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
      value="{{ old('payment_transaction_id', $registration->payment_transaction_id) }}"
      required
      autocomplete="off"
      inputmode="text"
    />
    @error('payment_transaction_id')
      <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
    @enderror
    <button type="submit" class="mt-4 w-full sm:w-auto bg-neon text-black font-bold py-3 px-6 text-sm rounded-lg btn-hard">
      {{ $registration->payment_transaction_id ? 'Update transaction ID' : 'Submit transaction ID' }}
    </button>
  </form>
@elseif (! $registration->is_paid)
  <div class="mt-8 border border-white/15 rounded-lg p-5 bg-surface/40 text-sm text-gray-200 leading-relaxed">
    <p class="text-neon text-sm font-medium mb-2">Registration fee</p>
    <p>Fee for {{ $registration->contest_type->value }}: <strong class="text-neon">৳{{ number_format($registration->contestFeeAmount()) }}</strong>.</p>
    <p class="mt-3 text-dim">The registration committee (UGV Programming Club) will contact you at your registered phone number with payment instructions.</p>
  </div>
@endif
