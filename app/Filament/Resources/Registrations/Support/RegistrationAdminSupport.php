<?php

namespace App\Filament\Resources\Registrations\Support;

use App\Models\Registration;
use App\Models\Tag;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Auth;

class RegistrationAdminSupport
{
    public static function progressFormFields(): array
    {
        return [
            Toggle::make('is_contacted')
                ->label('Contacted')
                ->inline(false),
            Toggle::make('is_paid')
                ->label('Paid')
                ->inline(false),
            Toggle::make('is_confirmed')
                ->label('Confirmed')
                ->inline(false),
            Textarea::make('note')
                ->label('Add note (optional)')
                ->rows(3)
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function progressFormDefaults(Registration $registration): array
    {
        return [
            'is_contacted' => $registration->is_contacted,
            'is_paid' => $registration->is_paid,
            'is_confirmed' => $registration->is_confirmed,
        ];
    }

    public static function applyProgress(Registration $registration, array $data): void
    {
        $registration->update([
            'is_contacted' => (bool) $data['is_contacted'],
            'contacted_at' => $data['is_contacted'] ? ($registration->contacted_at ?? now()) : null,
            'is_paid' => (bool) $data['is_paid'],
            'paid_at' => $data['is_paid'] ? ($registration->paid_at ?? now()) : null,
            'is_confirmed' => (bool) $data['is_confirmed'],
            'confirmed_at' => $data['is_confirmed'] ? ($registration->confirmed_at ?? now()) : null,
        ]);

        self::createNoteIfFilled($registration, $data['note'] ?? null);
    }

    public static function tagsSelect(): Select
    {
        return Select::make('tags')
            ->label('Tags')
            ->multiple()
            ->searchable()
            ->preload()
            ->options(fn (): array => Tag::query()->orderBy('name')->pluck('name', 'id')->all())
            ->createOptionForm([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique('tags', 'name'),
                Select::make('color')
                    ->options([
                        'gray' => 'Gray',
                        'info' => 'Blue',
                        'success' => 'Green',
                        'warning' => 'Amber',
                        'danger' => 'Red',
                    ])
                    ->default('gray')
                    ->required(),
            ])
            ->createOptionUsing(function (array $data): int {
                return Tag::query()->create($data)->getKey();
            });
    }

    public static function syncTags(Registration $registration, array $data): void
    {
        $tags = $data['tags'] ?? [];

        if (! is_array($tags)) {
            $tags = filled($tags) ? [$tags] : [];
        }

        $registration->tags()->sync(
            collect($tags)->filter(fn ($id) => filled($id))->map(fn ($id) => (int) $id)->all()
        );
    }

    public static function createNoteIfFilled(Registration $registration, ?string $body): void
    {
        if (! filled($body)) {
            return;
        }

        $registration->notes()->create([
            'body' => $body,
            'user_id' => Auth::id(),
        ]);
    }
}
