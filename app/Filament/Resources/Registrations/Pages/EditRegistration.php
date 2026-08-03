<?php

namespace App\Filament\Resources\Registrations\Pages;

use App\Filament\Resources\Registrations\RegistrationResource;
use App\Filament\Resources\Registrations\Support\RegistrationAdminSupport;
use App\Services\TeamProvisioner;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    /** @var array<int|string>|null */
    protected ?array $pendingTagIds = null;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncTeam')
                ->label('Sync team')
                ->icon(Heroicon::OutlinedUserGroup)
                ->action(function (TeamProvisioner $provisioner): void {
                    $this->record->load('members');
                    $provisioner->syncFromRegistration($this->record);
                    Notification::make()->title('Team synced')->success()->send();
                }),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['tags'] = $this->record->tags->pluck('id')->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->pendingTagIds = $data['tags'] ?? [];
        unset($data['tags']);

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->pendingTagIds !== null) {
            RegistrationAdminSupport::syncTags($this->record, ['tags' => $this->pendingTagIds]);
        }
    }
}
