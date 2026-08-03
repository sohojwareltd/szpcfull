<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Team')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('contest_type')->badge(),
                        TextEntry::make('registration.reference_code')->label('Reference'),
                        TextEntry::make('leader.full_name')->label('Leader'),
                        TextEntry::make('created_at')->dateTime(),
                    ]),
            ]);
    }
}
