<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Services\MessageTemplateRenderer;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\Locked;
use UnitEnum;

class ManageSiteSeo extends Page
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    #[Locked]
    public SiteSetting $record;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $navigationLabel = 'Site & SEO';

    protected static string|\UnitEnum|null $navigationGroup = 'Site';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'site-seo';

    public function mount(): void
    {
        $this->record = SiteSetting::current();
        $this->form->fill($this->record->attributesToArray());
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['favicon', 'og_image'] as $fileField) {
            if (is_array($data[$fileField] ?? null)) {
                $data[$fileField] = $data[$fileField][array_key_last($data[$fileField])] ?? null;
            }
        }

        $this->record->update($data);
        SiteSetting::clearCache();
        $this->record->refresh();

        Notification::make()
            ->title('Site settings saved')
            ->success()
            ->send();
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->model($this->record)
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')->required()->maxLength(255),
                        TextInput::make('theme_color')->maxLength(16)->default('#1a1d24'),
                        Toggle::make('robots_index')->label('Allow search engines to index the site'),
                    ]),
                Section::make('Home page SEO')
                    ->schema([
                        TextInput::make('meta_title')->label('Meta title')->maxLength(255),
                        Textarea::make('meta_description')->label('Meta description')->rows(3),
                        TextInput::make('meta_keywords')->label('Meta keywords')->maxLength(500),
                    ]),
                Section::make('Registration pages')
                    ->columns(1)
                    ->schema([
                        TextInput::make('register_meta_title')->label('Register page title')->maxLength(255),
                        Textarea::make('register_meta_description')->label('Register page description')->rows(2),
                        TextInput::make('success_meta_title')->label('Success page title')->maxLength(255),
                        Textarea::make('success_meta_description')->label('Success page description')->rows(2),
                    ]),
                Section::make('Social & sharing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('og_title')->label('Open Graph title')->maxLength(255),
                        Textarea::make('og_description')->label('Open Graph description')->rows(2)->columnSpanFull(),
                        FileUpload::make('og_image')
                            ->label('Share image (OG / Twitter)')
                            ->image()
                            ->directory('site')
                            ->disk('public')
                            ->maxSize(2048),
                        TextInput::make('twitter_site')->label('Twitter @handle')->placeholder('@ugv_szpc'),
                    ]),
                Section::make('Favicon & verification')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('site')
                            ->disk('public')
                            ->maxSize(512),
                        TextInput::make('google_site_verification')->label('Google Search Console verification'),
                        TextInput::make('analytics_measurement_id')->label('Google Analytics measurement ID')->placeholder('G-XXXXXXXXXX'),
                    ]),
                Section::make('Registration submitted SMS')
                    ->description('Sent to the primary contact phone when someone completes the public registration form. Requires REVE_SMS_* or legacy SMS_API_* in .env.')
                    ->schema([
                        Toggle::make('registration_submitted_sms_enabled')
                            ->label('Send SMS on new registration')
                            ->inline(false),
                        Textarea::make('registration_submitted_sms_template')
                            ->label('Message template')
                            ->rows(5)
                            ->helperText('Placeholders: '.MessageTemplateRenderer::placeholderHelp())
                            ->placeholder(SiteSetting::defaultAttributes()['registration_submitted_sms_template']),
                    ]),
                Section::make('Contact (footer)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_email')->email()->maxLength(255),
                        TextInput::make('contact_phone')->maxLength(64),
                        Textarea::make('contact_address')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }

    public function getTitle(): string|Htmlable
    {
        return 'Site & SEO';
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFormContentComponent(),
        ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('site-seo-form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Save settings')
                        ->submit('save')
                        ->keyBindings(['mod+s']),
                ]),
            ]);
    }
}
