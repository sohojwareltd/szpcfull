<?php

namespace App\Console\Commands;

use App\Services\Sms\ReveSmsService;
use Illuminate\Console\Command;

class SendSmsCommand extends Command
{
    protected $signature = 'sms:send {phone : Recipient phone} {message : Message body}';

    protected $description = 'Send a test SMS via the REVE gateway';

    public function handle(ReveSmsService $smsService): int
    {
        if (! $smsService->isConfigured()) {
            $this->error('REVE SMS is not configured. Set REVE_SMS_API_KEY, REVE_SMS_SECRET_KEY, and REVE_SMS_CALLER_ID in .env.');

            return self::FAILURE;
        }

        $result = $smsService->send(
            $this->argument('phone'),
            $this->argument('message'),
        );

        if ($result->success) {
            $this->info('SMS sent. Message ID: '.$result->messageId);

            return self::SUCCESS;
        }

        $this->error('SMS failed: '.$result->statusDescription.' (status '.$result->status.')');

        return self::FAILURE;
    }
}
