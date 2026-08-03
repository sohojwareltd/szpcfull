<?php

namespace App\Filament\Resources\MessageCampaigns\Tables;

use App\Enums\CampaignStatus;
use App\Models\MessageCampaign;
use App\Services\MessagingService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MessageCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contest_filter')
                    ->label('Contest')
                    ->formatStateUsing(fn ($state) => $state ?: 'All')
                    ->badge(),
                TextColumn::make('audience')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (CampaignStatus $state): string => match ($state) {
                        CampaignStatus::Draft => 'gray',
                        CampaignStatus::Sending => 'warning',
                        CampaignStatus::Completed => 'success',
                    }),
                TextColumn::make('sent_count')
                    ->label('Sent'),
                TextColumn::make('failed_count')
                    ->label('Failed'),
                TextColumn::make('recipients_count')
                    ->label('Recipients'),
                TextColumn::make('sent_at')
                    ->dateTime()
                    ->toggleable(),
            ])
            ->recordActions([
                Action::make('send')
                    ->label('Send')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->requiresConfirmation()
                    ->modalDescription('This will send SMS to all matching team members and log each message.')
                    ->visible(fn (MessageCampaign $record): bool => $record->status !== CampaignStatus::Sending)
                    ->action(function (MessageCampaign $record, MessagingService $messaging): void {
                        $campaign = $messaging->sendCampaign($record, Auth::user());

                        Notification::make()
                            ->title('Campaign finished')
                            ->body("Sent {$campaign->sent_count}, failed {$campaign->failed_count}, skipped ".($campaign->recipients_count - $campaign->sent_count - $campaign->failed_count).'.')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ]);
    }
}
