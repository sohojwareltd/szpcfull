<?php

namespace App\Filament\Resources\MessageCampaigns;

use App\Filament\Resources\MessageCampaigns\Pages\CreateMessageCampaign;
use App\Filament\Resources\MessageCampaigns\Pages\EditMessageCampaign;
use App\Filament\Resources\MessageCampaigns\Pages\ListMessageCampaigns;
use App\Filament\Resources\MessageCampaigns\Schemas\MessageCampaignForm;
use App\Filament\Resources\MessageCampaigns\Tables\MessageCampaignsTable;
use App\Models\MessageCampaign;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MessageCampaignResource extends Resource
{
    protected static ?string $model = MessageCampaign::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $navigationLabel = 'Message campaigns';

    protected static string|\UnitEnum|null $navigationGroup = 'Messaging';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return MessageCampaignForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MessageCampaignsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessageCampaigns::route('/'),
            'create' => CreateMessageCampaign::route('/create'),
            'edit' => EditMessageCampaign::route('/{record}/edit'),
        ];
    }
}
