<?php

namespace App\Filament\Resources\Teams\Schemas;

use App\Enums\ContestType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Team')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('contest_type')
                            ->options(collect(ContestType::cases())->mapWithKeys(fn (ContestType $c) => [$c->value => $c->label()]))
                            ->required()
                            ->disabledOn('edit'),
                        TextInput::make('registration.reference_code')
                            ->label('Registration ref')
                            ->disabled()
                            ->dehydrated(false),
                        Select::make('leader_id')
                            ->label('Team leader')
                            ->relationship('leader', 'full_name')
                            ->searchable()
                            ->preload(),
                    ]),
            ]);
    }
}
