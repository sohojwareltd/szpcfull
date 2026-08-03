<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Overview')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('reference_code')->label('Reference'),
                        TextEntry::make('contest_type')->badge(),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('tags.name')
                            ->label('Tags')
                            ->badge()
                            ->separator(',')
                            ->placeholder('None'),
                    ]),
                Section::make('Contact & details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('team_name')->placeholder('—'),
                        TextEntry::make('full_name')->label('Participant name')->placeholder('—'),
                        TextEntry::make('university')->placeholder('—'),
                        TextEntry::make('institution_name')->placeholder('—'),
                        TextEntry::make('district')->placeholder('—'),
                        TextEntry::make('category')->placeholder('—'),
                        TextEntry::make('phone'),
                        TextEntry::make('email')->placeholder('—'),
                        TextEntry::make('address')->columnSpanFull()->placeholder('—'),
                    ]),
                Section::make('Team')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('team.name')->label('Team name')->placeholder('—'),
                        TextEntry::make('team.leader.full_name')->label('Leader')->placeholder('—'),
                    ]),
                Section::make('Members')
                    ->schema([
                        RepeatableEntry::make('members')
                            ->schema([
                                TextEntry::make('sort_order')->label('#'),
                                TextEntry::make('full_name'),
                                TextEntry::make('phone')->placeholder('—'),
                                TextEntry::make('tshirt_size')->label('T-shirt')->placeholder('—'),
                            ])
                            ->columns(4)
                            ->placeholder('No members recorded'),
                    ]),
                Section::make('Progress')
                    ->columns(3)
                    ->schema([
                        IconEntry::make('is_contacted')->label('Contacted')->boolean(),
                        TextEntry::make('contacted_at')->dateTime()->placeholder('—'),
                        IconEntry::make('is_paid')->label('Paid')->boolean(),
                        TextEntry::make('paid_at')->dateTime()->placeholder('—'),
                        IconEntry::make('is_confirmed')->label('Confirmed')->boolean(),
                        TextEntry::make('confirmed_at')->dateTime()->placeholder('—'),
                        TextEntry::make('last_sms_at')->dateTime()->label('Last SMS')->placeholder('—'),
                    ]),
            ]);
    }
}
