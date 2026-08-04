@php
  $bkashNumber = config('services.contest_payment.ithq_bkash_number');
  $bkashLabel = config('services.contest_payment.ithq_bkash_label');
  $fee = $feeAmount ?? 100;
@endphp
<div class="mt-8 border border-neon/35 rounded-lg p-5 bg-surface/60" data-testid="ithq-bkash-instructions">
  <p class="text-neon text-sm font-medium mb-3">Pay registration fee (ITHQ-2026)</p>
  <ol class="text-sm text-gray-200 space-y-2 list-decimal list-inside leading-relaxed">
    <li>Open bKash and send <strong class="text-neon">৳{{ number_format($fee) }}</strong> to <strong class="font-mono text-neon">{{ $bkashNumber }}</strong> ({{ $bkashLabel }}).</li>
    <li>In the payment reference / note field, enter your registration code: <strong class="font-mono text-neon">{{ $referenceCode }}</strong>.</li>
    <li>Save the bKash transaction ID from the SMS or app receipt.</li>
    <li>Submit the transaction ID below so we can verify your payment.</li>
  </ol>
</div>
