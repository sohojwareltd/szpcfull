<?php

namespace App\Filament\Resources\PendingPayments;

use App\Filament\Resources\PendingPayments\Pages\ListPendingPayments;
use App\Filament\Resources\PendingPayments\Tables\PendingPaymentsTable;
use App\Filament\Resources\Registrations\Schemas\RegistrationInfolist;
use App\Models\Registration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PendingPaymentResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $slug = 'pending-payments';

    protected static ?string $navigationLabel = 'Pending payments';

    protected static ?string $modelLabel = 'pending payment';

    protected static ?string $pluralModelLabel = 'Pending payments';

    protected static ?string $recordTitleAttribute = 'reference_code';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * @return Builder<Registration>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->pendingPaymentVerification();
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Registration::query()->pendingPaymentVerification()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RegistrationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PendingPaymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendingPayments::route('/'),
        ];
    }
}
