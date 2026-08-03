<?php

namespace App\Filament\Resources\MessageCampaigns\Pages;

use App\Filament\Resources\MessageCampaigns\MessageCampaignResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMessageCampaign extends CreateRecord
{
    protected static string $resource = MessageCampaignResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        if (($data['contest_filter'] ?? '') === '') {
            $data['contest_filter'] = null;
        }

        return $data;
    }
}
