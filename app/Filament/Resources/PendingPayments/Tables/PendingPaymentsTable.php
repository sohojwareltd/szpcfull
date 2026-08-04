<?php

namespace App\Filament\Resources\PendingPayments\Tables;

use App\Filament\Resources\Registrations\Actions\AddRegistrationNoteAction;
use App\Filament\Resources\Registrations\Actions\UpdateRegistrationProgressAction;
use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PendingPaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('payment_submitted_at', 'desc')
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Ref')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->url(fn (Registration $record): string => RegistrationResource::getUrl('view', ['record' => $record])),
                TextColumn::make('contest_type')
                    ->label('Contest')
                    ->badge()
                    ->sortable(),
                TextColumn::make('display_name')
                    ->label('Name / team')
                    ->getStateUsing(fn (Registration $record): string => $record->displayName())
                    ->searchable(['team_name', 'full_name', 'institution_name']),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('payment_transaction_id')
                    ->label('bKash trx ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->color('warning'),
                TextColumn::make('payment_submitted_at')
                    ->label('Trx submitted')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('contest_type')
                    ->label('Contest')
                    ->options([
                        'SZPC-2026' => 'SZPC-2026',
                        'JPC-2026' => 'JPC-2026',
                        'ITHQ-2026' => 'ITHQ-2026',
                    ]),
            ])
            ->emptyStateHeading('No pending payment verifications')
            ->emptyStateDescription('Registrations appear here after a participant submits a bKash transaction ID and is not yet marked paid.')
            ->recordActions([
                Action::make('markPaid')
                    ->label('Mark paid')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark registration as paid?')
                    ->modalDescription(fn (Registration $record): string => "Confirm fee received for {$record->reference_code} (trx {$record->payment_transaction_id}).")
                    ->action(function (Registration $record): void {
                        $record->update([
                            'is_paid' => true,
                            'paid_at' => now(),
                        ]);

                        $record->notes()->create([
                            'body' => 'Marked paid from Pending payments (verified bKash trx '.$record->payment_transaction_id.').',
                            'user_id' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Marked as paid')
                            ->success()
                            ->send();
                    }),
                ActionGroup::make([
                    UpdateRegistrationProgressAction::make(),
                    AddRegistrationNoteAction::make(),
                ])
                    ->label('More')
                    ->icon(Heroicon::OutlinedEllipsisHorizontal)
                    ->color('gray')
                    ->button(),
                ViewAction::make()
                    ->url(fn (Registration $record): string => RegistrationResource::getUrl('view', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markPaid')
                        ->label('Mark paid')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function (Registration $record): void {
                                $record->update([
                                    'is_paid' => true,
                                    'paid_at' => now(),
                                ]);

                                $record->notes()->create([
                                    'body' => 'Marked paid from Pending payments (bulk).',
                                    'user_id' => Auth::id(),
                                ]);
                            });

                            Notification::make()
                                ->title("Marked {$records->count()} as paid")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->poll('30s');
    }
}
