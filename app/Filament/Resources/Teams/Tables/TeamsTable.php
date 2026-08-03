<?php

namespace App\Filament\Resources\Teams\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('registration.reference_code')
                    ->label('Ref')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contest_type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('leader.full_name')
                    ->label('Leader')
                    ->searchable(),
                TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Members'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('contest_type')
                    ->options([
                        'SZPC-2026' => 'SZPC-2026',
                        'JPC-2026' => 'JPC-2026',
                        'ITHQ-2026' => 'ITHQ-2026',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
