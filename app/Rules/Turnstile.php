<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            $fail('Please complete the security check.');

            return;
        }

        $secret = config('services.turnstile.secret_key');
        if (! $secret) {
            $fail('Security check is not configured. Please contact the organizers.');

            return;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->successful()) {
            $fail('Security check could not be verified. Please try again.');

            return;
        }

        $body = $response->json();
        if (! ($body['success'] ?? false)) {
            $fail('Security check failed. Please try again.');
        }
    }
}
