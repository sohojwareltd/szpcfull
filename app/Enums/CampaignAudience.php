<?php

namespace App\Enums;

enum CampaignAudience: string
{
    case TeamLeaders = 'team_leaders';
    case AllMembers = 'all_members';
    case Both = 'both';

    public function label(): string
    {
        return match ($this) {
            self::TeamLeaders => 'Team leaders only',
            self::AllMembers => 'All members with phone',
            self::Both => 'Leaders + all members (deduplicated by phone)',
        };
    }
}
