<?php

namespace App\Filament\Resources\Registrations\Pages;

use App\Filament\Resources\Registrations\Actions\AddRegistrationNoteAction;
use App\Filament\Resources\Registrations\Actions\ManageRegistrationTagsAction;
use App\Filament\Resources\Registrations\Actions\UpdateRegistrationProgressAction;
use App\Filament\Resources\Registrations\RegistrationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistration extends ViewRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            UpdateRegistrationProgressAction::make()
                ->after(fn () => $this->dispatch('$refresh')),
            ManageRegistrationTagsAction::make()
                ->after(fn () => $this->dispatch('$refresh')),
            AddRegistrationNoteAction::make()
                ->after(fn () => $this->dispatch('$refresh')),
            EditAction::make(),
        ];
    }
}
