<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\RegistrationNote;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestRegistrationNotesWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Latest registration notes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => RegistrationNote::query()
                    ->with(['registration', 'author'])
                    ->latest()
                    ->limit(15)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')
                    ->label('When')
                    ->since()
                    ->sortable(),
                TextColumn::make('registration.reference_code')
                    ->label('Ref')
                    ->url(fn (RegistrationNote $record): ?string => $record->registration
                        ? RegistrationResource::getUrl('view', ['record' => $record->registration])
                        : null)
                    ->color('primary'),
                TextColumn::make('registration.contest_type')
                    ->label('Contest')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('author.name')
                    ->label('By')
                    ->placeholder('—'),
                TextColumn::make('body')
                    ->wrap()
                    ->limit(80),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
