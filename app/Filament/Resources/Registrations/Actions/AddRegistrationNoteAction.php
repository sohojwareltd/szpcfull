<?php

namespace App\Filament\Resources\Registrations\Actions;

use App\Filament\Resources\Registrations\Support\RegistrationAdminSupport;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class AddRegistrationNoteAction
{
    public static function make(): Action
    {
        return Action::make('addNote')
            ->label('Add note')
            ->icon(Heroicon::OutlinedDocumentPlus)
            ->form([
                Textarea::make('body')
                    ->label('Note')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->action(function (Registration $record, array $data): void {
                RegistrationAdminSupport::createNoteIfFilled($record, $data['body']);

                Notification::make()
                    ->title('Note added')
                    ->success()
                    ->send();
            });
    }
}
