<?php

namespace App\Filament\Admin\Resources\Inventories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.nombre')->label('Material'),
                TextColumn::make('cantidadDisponible')->label('Cantidad Disponible')->numeric(),
                TextColumn::make('updated_at')->label('Última Actualización')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
