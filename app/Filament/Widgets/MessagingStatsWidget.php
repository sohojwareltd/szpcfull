<?php

namespace App\Filament\Widgets;

use App\Enums\MessageLogStatus;
use App\Models\MessageCampaign;
use App\Models\MessageLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MessagingStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $sent = MessageLog::where('status', MessageLogStatus::Sent)->count();
        $failed = MessageLog::where('status', MessageLogStatus::Failed)->count();
        $today = MessageLog::where('status', MessageLogStatus::Sent)
            ->whereDate('sent_at', today())
            ->count();
        $campaigns = MessageCampaign::count();

        return [
            Stat::make('Messages sent', (string) $sent)
                ->description('Failed: '.$failed)
                ->color('success'),
            Stat::make('Sent today', (string) $today),
            Stat::make('Campaigns', (string) $campaigns),
        ];
    }
}
