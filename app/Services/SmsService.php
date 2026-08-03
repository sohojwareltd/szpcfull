<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function isConfigured(): bool
    {
        return filled(config('services.sms.api_url'))
            && filled(config('services.sms.api_key'));
    }

    public function send(Registration $registration, string $message): bool
    {
        $result = $this->sendToPhone($registration->smsRecipientPhone(), $message, $registration);

        return $result['success'];
    }

    /**
     * @return array{success: bool, error: ?string, response: ?string}
     */
    public function sendToPhone(string $phone, string $message, ?Registration $registration = null): array
    {
        if (! filled($phone)) {
            return ['success' => false, 'error' => 'Empty phone', 'response' => null];
        }

        if (! $this->isConfigured()) {
            Log::warning('SMS not sent: API not configured.', [
                'registration_id' => $registration?->id,
                'phone' => $phone,
            ]);

            return ['success' => false, 'error' => 'SMS API not configured', 'response' => null];
        }

        $normalized = $this->normalizePhone($phone);

        $response = Http::withHeaders($this->headers())
            ->timeout(15)
            ->post(config('services.sms.api_url'), [
                'to' => $normalized,
                'message' => $message,
                ...config('services.sms.payload_extra', []),
            ]);

        if ($response->successful()) {
            if ($registration) {
                $registration->update(['last_sms_at' => now()]);
            }

            return ['success' => true, 'error' => null, 'response' => $response->body()];
        }

        Log::error('SMS API error', [
            'registration_id' => $registration?->id,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return [
            'success' => false,
            'error' => 'Provider error '.$response->status(),
            'response' => $response->body(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $key = config('services.sms.api_key');
        $headerName = config('services.sms.api_key_header', 'Authorization');

        if ($headerName === 'Authorization') {
            $headers['Authorization'] = 'Bearer '.$key;
        } else {
            $headers[$headerName] = $key;
        }

        return $headers;
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? $phone;

        if (str_starts_with($digits, '0')) {
            $digits = '88'.substr($digits, 1);
        }

        return $digits;
    }
}
