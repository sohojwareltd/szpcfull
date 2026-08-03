<?php

namespace App\Filament\Widgets;

use App\Enums\ContestType;
use App\Models\Registration;
use App\Models\Team;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = Registration::count();
        $paid = Registration::where('is_paid', true)->count();
        $confirmed = Registration::where('is_confirmed', true)->count();
        $teams = Team::count();

        $byContest = Registration::query()
            ->selectRaw('contest_type, count(*) as aggregate')
            ->groupBy('contest_type')
            ->pluck('aggregate', 'contest_type');

        $contestSummary = collect(ContestType::cases())
            ->map(fn (ContestType $c) => $c->value.': '.($byContest[$c->value] ?? 0))
            ->implode(' · ');

        return [
            Stat::make('Registrations', (string) $total)
                ->description($contestSummary)
                ->descriptionIcon('heroicon-m-clipboard-document-list'),
            Stat::make('Teams', (string) $teams)
                ->description('Synced from registrations'),
            Stat::make('Paid', (string) $paid)
                ->description('Confirmed: '.$confirmed),
        ];
    }
}
