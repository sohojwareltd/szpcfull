<?php

namespace App\Filament\Resources\MessageCampaigns\Pages;

use App\Filament\Resources\MessageCampaigns\MessageCampaignResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMessageCampaign extends EditRecord
{
    protected static string $resource = MessageCampaignResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['contest_filter'] ?? '') === '') {
            $data['contest_filter'] = null;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
