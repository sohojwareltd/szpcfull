<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('color')
                    ->options([
                        'gray' => 'Gray',
                        'info' => 'Blue',
                        'success' => 'Green',
                        'warning' => 'Amber',
                        'danger' => 'Red',
                    ])
                    ->default('gray')
                    ->required(),
            ]);
    }
}
