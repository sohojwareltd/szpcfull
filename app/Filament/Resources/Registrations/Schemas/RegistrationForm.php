<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Enums\ContestType;
use App\Filament\Resources\Registrations\Support\RegistrationAdminSupport;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registration')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reference_code')
                            ->disabled()
                            ->dehydrated(false),
                        Select::make('contest_type')
                            ->options(collect(ContestType::cases())->mapWithKeys(fn (ContestType $c) => [$c->value => $c->label()]))
                            ->required()
                            ->disabledOn('edit'),
                        TextInput::make('team_name'),
                        TextInput::make('university'),
                        TextInput::make('institution_name'),
                        TextInput::make('district'),
                        TextInput::make('category'),
                        TextInput::make('full_name'),
                        TextInput::make('email')->email(),
                        TextInput::make('phone')->required(),
                        Textarea::make('address')->columnSpanFull(),
                        RegistrationAdminSupport::tagsSelect()->columnSpanFull(),
                    ]),
                Section::make('Progress tracking')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_contacted')
                            ->label('Contacted')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('contacted_at', $state ? now() : null);
                            }),
                        DateTimePicker::make('contacted_at'),
                        Toggle::make('is_paid')
                            ->label('Paid')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('paid_at', $state ? now() : null);
                            }),
                        DateTimePicker::make('paid_at'),
                        Toggle::make('is_confirmed')
                            ->label('Confirmed')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('confirmed_at', $state ? now() : null);
                            }),
                        DateTimePicker::make('confirmed_at'),
                        DateTimePicker::make('last_sms_at')->disabled(),
                    ]),
            ]);
    }
}
