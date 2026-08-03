<?php

namespace App\Filament\Resources\Tags\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('color')->badge(),
                TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Used on'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
