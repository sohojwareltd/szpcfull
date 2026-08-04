<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReveSmsService
{
    private string $apiKey;

    private string $secretKey;

    private string $callerId;

    private string $baseUrl;

    private int $timeout;

    public function __construct()
    {
        $this->apiKey = config('services.reve_sms.api_key', '');
        $this->secretKey = config('services.reve_sms.secret_key', '');
        $this->callerId = config('services.reve_sms.caller_id', '');
        $this->baseUrl = rtrim(config('services.reve_sms.base_url', ''), '/');
        $this->timeout = (int) config('services.reve_sms.timeout', 30);
    }

    public function send(string $to, string $message, ?string $callerId = null): SmsSendResult
    {
        return $this->sendToMany([$to], $message, $callerId);
    }

    /**
     * @param  array<int, string>|string  $recipients
     */
    public function sendToMany(array|string $recipients, string $message, ?string $callerId = null): SmsSendResult
    {
        if (! $this->isConfigured()) {
            Log::error('REVE SMS is not configured. Set REVE_SMS_API_KEY, REVE_SMS_SECRET_KEY, and REVE_SMS_CALLER_ID in .env.');

            return new SmsSendResult(
                success: false,
                status: '-1',
                statusDescription: 'SMS service is not configured',
                text: 'REJECTD',
                messageId: '-1',
                raw: [],
            );
        }

        $toUser = $this->formatRecipients($recipients);

        if ($toUser === '') {
            return new SmsSendResult(
                success: false,
                status: '-1',
                statusDescription: 'No valid recipient phone numbers provided',
                text: 'REJECTD',
                messageId: '-1',
                raw: [],
            );
        }

        try {
            $response = Http::timeout($this->timeout)
                ->get("{$this->baseUrl}/sendtext", [
                    'apikey' => $this->apiKey,
                    'secretkey' => $this->secretKey,
                    'callerID' => $callerId ?? $this->callerId,
                    'toUser' => $toUser,
                    'messageContent' => $message,
                ]);

            if (! $response->successful()) {
                Log::warning('REVE SMS request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'to' => $toUser,
                ]);

                return new SmsSendResult(
                    success: false,
                    status: (string) $response->status(),
                    statusDescription: 'HTTP request failed',
                    text: 'REJECTD',
                    messageId: '-1',
                    raw: ['body' => $response->body()],
                );
            }

            $payload = $response->json();

            if (! is_array($payload)) {
                Log::warning('REVE SMS returned a non-JSON response', [
                    'body' => $response->body(),
                    'to' => $toUser,
                ]);

                return new SmsSendResult(
                    success: false,
                    status: '-1',
                    statusDescription: 'Invalid response from SMS gateway',
                    text: 'REJECTD',
                    messageId: '-1',
                    raw: ['body' => $response->body()],
                );
            }

            $result = SmsSendResult::fromApiResponse($payload);

            if (! $result->success) {
                Log::warning('REVE SMS rejected message', [
                    'status' => $result->status,
                    'status_description' => $result->statusDescription,
                    'text' => $result->text,
                    'to' => $toUser,
                ]);
            }

            return $result;
        } catch (\Throwable $exception) {
            Log::error('REVE SMS error: '.$exception->getMessage(), [
                'to' => $toUser,
            ]);

            return new SmsSendResult(
                success: false,
                status: '-1',
                statusDescription: $exception->getMessage(),
                text: 'REJECTD',
                messageId: '-1',
                raw: [],
            );
        }
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== ''
            && $this->secretKey !== ''
            && $this->callerId !== ''
            && $this->baseUrl !== '';
    }

    public function formatRecipient(string $number): ?string
    {
        return $this->formatPhoneNumber($number);
    }

    /**
     * @param  array<int, string>|string  $recipients
     */
    private function formatRecipients(array|string $recipients): string
    {
        $numbers = is_array($recipients) ? $recipients : explode(',', $recipients);

        $formatted = collect($numbers)
            ->map(fn (string $number) => $this->formatPhoneNumber($number))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return implode(',', $formatted);
    }

    private function formatPhoneNumber(string $number): ?string
    {
        $digits = preg_replace('/\D+/', '', $number);

        if ($digits === null || $digits === '') {
            return null;
        }

        if (str_starts_with($digits, '880')) {
            return $digits;
        }

        if (str_starts_with($digits, '0')) {
            return '88'.$digits;
        }

        if (str_starts_with($digits, '1') && strlen($digits) === 10) {
            return '880'.$digits;
        }

        return $digits;
    }
}
