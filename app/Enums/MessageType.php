<?php

namespace App\Enums;

enum MessageType: string
{
    case Campaign = 'campaign';
    case Individual = 'individual';

    public function label(): string
    {
        return match ($this) {
            self::Campaign => 'Campaign',
            self::Individual => 'Individual',
        };
    }
}
