<?php

namespace App\Filament\Admin\Resources\InventoryTransactions;

use App\Filament\Admin\Resources\InventoryTransactions\Pages\CreateInventoryTransaction;
use App\Filament\Admin\Resources\InventoryTransactions\Pages\EditInventoryTransaction;
use App\Filament\Admin\Resources\InventoryTransactions\Pages\ListInventoryTransactions;
use App\Filament\Admin\Resources\InventoryTransactions\Schemas\InventoryTransactionForm;
use App\Filament\Admin\Resources\InventoryTransactions\Tables\InventoryTransactionsTable;
use App\Models\InventoryTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventoryTransactionResource extends Resource
{
    protected static ?string $model = InventoryTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?string $modelLabel = 'Movimiento';
    protected static ?string $pluralModelLabel = 'Movimientos';

    public static function form(Schema $schema): Schema
    {
        return InventoryTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryTransactionsTable::configure($table);
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
            'index' => ListInventoryTransactions::route('/'),
            'create' => CreateInventoryTransaction::route('/create'),
        ];
    }
}
