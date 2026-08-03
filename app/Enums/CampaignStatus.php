<?php

namespace App\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Sending = 'sending';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Sending => 'Sending',
            self::Completed => 'Completed',
        };
    }
}
