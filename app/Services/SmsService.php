<?php

namespace App\Services;

use App\Models\Registration;
use App\Services\Sms\ReveSmsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function __construct(
        private readonly ReveSmsService $reveSms,
    ) {}

    public function isConfigured(): bool
    {
        return $this->reveSms->isConfigured() || $this->legacyIsConfigured();
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

        if ($this->reveSms->isConfigured()) {
            return $this->sendViaReve($phone, $message, $registration);
        }

        if ($this->legacyIsConfigured()) {
            return $this->sendViaLegacyHttp($phone, $message, $registration);
        }

        Log::warning('SMS not sent: gateway not configured.', [
            'registration_id' => $registration?->id,
            'phone' => $phone,
        ]);

        return ['success' => false, 'error' => 'SMS gateway not configured (set REVE_SMS_* in .env)', 'response' => null];
    }

    /**
     * @return array{success: bool, error: ?string, response: ?string}
     */
    private function sendViaReve(string $phone, string $message, ?Registration $registration): array
    {
        $result = $this->reveSms->send($phone, $message);

        if ($result->success) {
            if ($registration) {
                $registration->update(['last_sms_at' => now()]);
            }

            return [
                'success' => true,
                'error' => null,
                'response' => json_encode($result->raw, JSON_UNESCAPED_UNICODE),
            ];
        }

        return [
            'success' => false,
            'error' => $result->statusDescription ?: 'SMS rejected by gateway',
            'response' => json_encode($result->raw, JSON_UNESCAPED_UNICODE),
        ];
    }

    /**
     * @return array{success: bool, error: ?string, response: ?string}
     */
    private function sendViaLegacyHttp(string $phone, string $message, ?Registration $registration): array
    {
        $normalized = $this->normalizePhoneLegacy($phone);

        $response = Http::withHeaders($this->legacyHeaders())
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

        Log::error('Legacy SMS API error', [
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

    private function legacyIsConfigured(): bool
    {
        return filled(config('services.sms.api_url'))
            && filled(config('services.sms.api_key'));
    }

    /**
     * @return array<string, string>
     */
    private function legacyHeaders(): array
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

    private function normalizePhoneLegacy(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? $phone;

        if (str_starts_with($digits, '0')) {
            $digits = '88'.substr($digits, 1);
        }

        return $digits;
    }
}
