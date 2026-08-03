<?php

namespace App\Filament\Resources\MessageLogs\Pages;

use App\Filament\Resources\MessageLogs\MessageLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMessageLogs extends ManageRecords
{
    protected static string $resource = MessageLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
