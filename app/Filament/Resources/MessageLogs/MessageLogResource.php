<?php

namespace App\Filament\Resources\MessageLogs;

use App\Filament\Resources\MessageLogs\Pages\ManageMessageLogs;
use App\Enums\MessageLogStatus;
use App\Enums\MessageType;
use App\Models\MessageLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MessageLogResource extends Resource
{
    protected static ?string $model = MessageLog::class;

    protected static ?string $navigationLabel = 'Message log';

    protected static string|\UnitEnum|null $navigationGroup = 'Messaging';

    protected static ?int $navigationSort = 11;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sent_at', 'desc')
            ->columns([
                TextColumn::make('sent_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('message_type')
                    ->badge()
                    ->label('Type'),
                TextColumn::make('campaign.name')
                    ->label('Campaign')
                    ->placeholder('Individual')
                    ->toggleable(),
                TextColumn::make('registration.reference_code')
                    ->label('Ref')
                    ->searchable(),
                TextColumn::make('recipient_name')
                    ->searchable(),
                TextColumn::make('recipient_phone')
                    ->searchable(),
                TextColumn::make('teamMember.full_name')
                    ->label('Member')
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (MessageLogStatus $state): string => match ($state) {
                        MessageLogStatus::Sent => 'success',
                        MessageLogStatus::Failed => 'danger',
                        MessageLogStatus::Skipped => 'gray',
                    }),
                TextColumn::make('message_body')
                    ->limit(40)
                    ->tooltip(fn (MessageLog $record): string => $record->message_body),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(MessageLogStatus::cases())->mapWithKeys(fn (MessageLogStatus $s) => [$s->value => $s->label()])),
                SelectFilter::make('message_type')
                    ->options(collect(MessageType::cases())->mapWithKeys(fn (MessageType $t) => [$t->value => $t->label()])),
                SelectFilter::make('message_campaign_id')
                    ->label('Campaign')
                    ->relationship('campaign', 'name'),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMessageLogs::route('/'),
        ];
    }
}
