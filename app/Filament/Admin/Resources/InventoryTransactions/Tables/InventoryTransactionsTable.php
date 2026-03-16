<?php

namespace App\Filament\Admin\Resources\InventoryTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.nombre')->label('Material'),
                TextColumn::make('tipoMovimiento')->label('Tipo'),
                TextColumn::make('cantidad')->label('Cantidad'),
                TextColumn::make('fechaMovimiento')->dateTime()->label('Fecha'),
                TextColumn::make('user.name')->label('Usuario'),
                TextColumn::make('observacion')->label('Observación'),
            ])
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
