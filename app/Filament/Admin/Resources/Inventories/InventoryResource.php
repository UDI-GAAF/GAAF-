<?php

namespace App\Filament\Admin\Resources\Inventories;

use App\Filament\Admin\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Admin\Resources\Inventories\Pages\EditInventory;
use App\Filament\Admin\Resources\Inventories\Pages\ListInventories;
use App\Filament\Admin\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Admin\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
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
            'index' => ListInventories::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
