<?php

namespace App\Http\Controllers;

use App\Enums\ContestType;
use App\Http\Requests\LookupPaymentRequest;
use App\Http\Requests\SubmitPaymentTransactionRequest;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('payment', [
            'referencePrefill' => strtoupper(trim((string) request()->query('ref', ''))),
            'seoPage' => 'payment',
        ]);
    }

    public function lookup(LookupPaymentRequest $request): RedirectResponse
    {
        $code = $request->validated('reference_code');

        if (! Registration::where('reference_code', $code)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['reference_code' => 'No registration found with that reference code. Check the code and try again.']);
        }

        return redirect()->route('payment.show', ['reference_code' => $code]);
    }

    public function show(string $reference_code): View|RedirectResponse
    {
        $code = strtoupper(trim($reference_code));
        $registration = Registration::where('reference_code', $code)->first();

        if (! $registration) {
            return redirect()
                ->route('payment')
                ->withErrors(['reference_code' => 'No registration found with that reference code.']);
        }

        return view('payment-status', [
            'registration' => $registration,
            'seoPage' => 'payment',
        ]);
    }

    public function storeTransaction(SubmitPaymentTransactionRequest $request, string $reference_code): RedirectResponse
    {
        $code = strtoupper(trim($reference_code));
        $registration = Registration::where('reference_code', $code)->firstOrFail();

        if ($registration->contest_type !== ContestType::Ithq) {
            return back()->withErrors([
                'payment_transaction_id' => 'Online bKash payment with transaction ID is only available for ITHQ-2026. Other contests are contacted by the registration committee.',
            ]);
        }

        if ($registration->is_paid) {
            return redirect()
                ->route('payment.show', ['reference_code' => $code])
                ->with('payment_message', 'This registration is already marked as paid.');
        }

        $trxId = $request->validated('payment_transaction_id');

        if ($registration->payment_transaction_id === $trxId) {
            return redirect()
                ->route('payment.show', ['reference_code' => $code])
                ->with('payment_message', 'This transaction ID is already on file. We will verify it shortly.');
        }

        $registration->update([
            'payment_transaction_id' => $trxId,
            'payment_submitted_at' => now(),
        ]);

        $registration->notes()->create([
            'body' => "Participant submitted bKash transaction ID: {$trxId}",
            'user_id' => null,
        ]);

        return redirect()
            ->route('payment.show', ['reference_code' => $code])
            ->with('payment_message', 'Transaction ID received. The registration committee will verify your payment and update your status here.');
    }
}
