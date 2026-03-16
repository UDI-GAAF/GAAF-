<?php

namespace App\Filament\Admin\Resources\InventoryTransactions\Pages;

use App\Filament\Admin\Resources\InventoryTransactions\InventoryTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryTransaction extends CreateRecord
{
    protected static string $resource = InventoryTransactionResource::class;
}
