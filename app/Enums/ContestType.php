<?php

namespace App\Enums;

enum ContestType: string
{
    case Szpc = 'SZPC-2026';
    case Jpc = 'JPC-2026';
    case Ithq = 'ITHQ-2026';

    public function label(): string
    {
        return match ($this) {
            self::Szpc => 'SZPC-2026 (University)',
            self::Jpc => 'JPC-2026 (Junior)',
            self::Ithq => 'ITHQ-2026 (Quiz)',
        };
    }
}
