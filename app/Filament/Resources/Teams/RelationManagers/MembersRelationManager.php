<?php

namespace App\Filament\Resources\Teams\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(32),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('tshirt_size')
                    ->maxLength(8),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Toggle::make('is_leader')
                    ->label('Team leader'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('sort_order')->label('#'),
                TextColumn::make('full_name')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('tshirt_size')->label('T-shirt'),
                IconColumn::make('is_leader')->label('Leader')->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
