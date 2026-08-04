<?php

namespace App\Enums;

enum MessageType: string
{
    case Campaign = 'campaign';
    case Individual = 'individual';
    case RegistrationSubmitted = 'registration_submitted';

    public function label(): string
    {
        return match ($this) {
            self::Campaign => 'Campaign',
            self::Individual => 'Individual',
            self::RegistrationSubmitted => 'Registration submitted',
        };
    }
}
