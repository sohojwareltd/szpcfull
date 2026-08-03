<?php

namespace App\Filament\Resources\MessageCampaigns\Schemas;

use App\Enums\CampaignAudience;
use App\Enums\ContestType;
use App\Services\MessageTemplateRenderer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MessageCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('contest_filter')
                            ->label('Contest')
                            ->options([
                                '' => 'All contests',
                                ...collect(ContestType::cases())->mapWithKeys(fn (ContestType $c) => [$c->value => $c->label()])->all(),
                            ])
                            ->nullable(),
                        Select::make('audience')
                            ->options(collect(CampaignAudience::cases())->mapWithKeys(fn (CampaignAudience $a) => [$a->value => $a->label()]))
                            ->required()
                            ->default(CampaignAudience::AllMembers->value),
                        Textarea::make('body')
                            ->label('Message template')
                            ->required()
                            ->rows(6)
                            ->helperText('Placeholders: '.MessageTemplateRenderer::placeholderHelp()),
                    ]),
            ]);
    }
}
