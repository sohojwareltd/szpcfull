<?php

namespace App\Filament\Resources\PendingPayments\Pages;

use App\Filament\Resources\PendingPayments\PendingPaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPendingPayments extends ListRecords
{
    protected static string $resource = PendingPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
