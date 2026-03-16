<?php

namespace App\Filament\Admin\Resources\InventoryTransactions\Pages;

use App\Filament\Admin\Resources\InventoryTransactions\InventoryTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryTransaction extends EditRecord
{
    protected static string $resource = InventoryTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
