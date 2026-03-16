<?php

namespace App\Filament\Admin\Resources\Inventories\Pages;

use App\Filament\Admin\Resources\Inventories\InventoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;
}
