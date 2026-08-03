<?php

namespace App\Enums;

enum MessageLogStatus: string
{
    case Sent = 'sent';
    case Failed = 'failed';
    case Skipped = 'skipped';

    public function label(): string
    {
        return match ($this) {
            self::Sent => 'Sent',
            self::Failed => 'Failed',
            self::Skipped => 'Skipped (no phone)',
        };
    }
}
