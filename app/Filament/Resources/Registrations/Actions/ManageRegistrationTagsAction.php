<?php

namespace App\Filament\Resources\Registrations\Actions;

use App\Filament\Resources\Registrations\Support\RegistrationAdminSupport;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ManageRegistrationTagsAction
{
    public static function make(): Action
    {
        return Action::make('manageTags')
            ->label('Tags')
            ->icon(Heroicon::OutlinedTag)
            ->fillForm(fn (Registration $record): array => [
                'tags' => $record->tags->pluck('id')->all(),
            ])
            ->form([
                RegistrationAdminSupport::tagsSelect(),
            ])
            ->action(function (Registration $record, array $data): void {
                RegistrationAdminSupport::syncTags($record, $data);
                $record->unsetRelation('tags');

                Notification::make()
                    ->title('Tags updated')
                    ->success()
                    ->send();
            });
    }
}
