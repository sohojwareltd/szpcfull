<?php

namespace App\Services\Sms;

class SmsSendResult
{
    /**
     * @param  array<string, mixed>  $raw
     */
    public function __construct(
        public readonly bool $success,
        public readonly string $status,
        public readonly string $statusDescription,
        public readonly string $text,
        public readonly string $messageId,
        public readonly array $raw,
    ) {}

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromApiResponse(array $response): self
    {
        $status = (string) ($response['Status'] ?? '');
        $text = (string) ($response['Text'] ?? '');

        return new self(
            success: $status === '0' && strtoupper($text) !== 'REJECTD',
            status: $status,
            statusDescription: (string) ($response['StatusDescription'] ?? ''),
            text: $text,
            messageId: (string) ($response['Message_ID'] ?? ''),
            raw: $response,
        );
    }
}
