<?php

namespace App\Filament\Resources\Registrations\Actions;

use App\Filament\Resources\Registrations\Support\RegistrationAdminSupport;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class UpdateRegistrationProgressAction
{
    public static function make(): Action
    {
        return Action::make('updateProgress')
            ->label('Update status')
            ->icon(Heroicon::OutlinedCheckBadge)
            ->fillForm(fn (Registration $record): array => RegistrationAdminSupport::progressFormDefaults($record))
            ->form(RegistrationAdminSupport::progressFormFields())
            ->action(function (Registration $record, array $data): void {
                RegistrationAdminSupport::applyProgress($record, $data);

                Notification::make()
                    ->title('Status updated')
                    ->success()
                    ->send();
            });
    }
}
