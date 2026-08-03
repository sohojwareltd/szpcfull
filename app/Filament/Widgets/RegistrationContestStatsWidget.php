<?php

namespace App\Filament\Widgets;

use App\Enums\ContestType;
use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationContestStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected ?string $heading = 'Registrations by contest';

    protected ?string $description = 'Use the competition tabs below to filter the table.';

    protected function getColumns(): int|array|null
    {
        return [
            '@xl' => 4,
            'lg' => 2,
            'sm' => 1,
        ];
    }

    protected function getStats(): array
    {
        $stats = [];

        $allQuery = Registration::query();
        $stats[] = $this->contestStat(
            'All contests',
            $allQuery,
        );

        foreach (ContestType::cases() as $contest) {
            $stats[] = $this->contestStat(
                $contest->value,
                Registration::query()->where('contest_type', $contest),
            );
        }

        return $stats;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Registration>  $query
     */
    private function contestStat(string $label, $query): Stat
    {
        $registered = (clone $query)->count();
        $contacted = (clone $query)->where('is_contacted', true)->count();
        $paid = (clone $query)->where('is_paid', true)->count();
        $confirmed = (clone $query)->where('is_confirmed', true)->count();

        return Stat::make($label, (string) $registered)
            ->description("Contacted {$contacted} · Paid {$paid} · Confirmed {$confirmed}")
            ->descriptionIcon('heroicon-m-clipboard-document-list');
    }
}
