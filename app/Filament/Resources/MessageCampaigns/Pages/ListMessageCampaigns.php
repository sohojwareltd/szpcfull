<?php

namespace App\Filament\Resources\MessageCampaigns\Pages;

use App\Filament\Resources\MessageCampaigns\MessageCampaignResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMessageCampaigns extends ListRecords
{
    protected static string $resource = MessageCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
