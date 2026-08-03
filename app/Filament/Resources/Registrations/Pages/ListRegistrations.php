<?php

namespace App\Filament\Resources\Registrations\Pages;

use App\Enums\ContestType;
use App\Filament\Resources\Registrations\RegistrationResource;
use App\Filament\Widgets\RegistrationContestStatsWidget;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            RegistrationContestStatsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All contests'),
        ];

        foreach (ContestType::cases() as $contest) {
            $tabs[$contest->value] = Tab::make($contest->value)
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('contest_type', $contest));
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
