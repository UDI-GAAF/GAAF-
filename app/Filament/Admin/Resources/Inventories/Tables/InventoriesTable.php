<?php
namespace App\Filament\Admin\Resources\Inventories\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product.categories.nombre')
                    ->label('Categoría')
                    ->badge(),
                TextColumn::make('cantidadDisponible')
                    ->label('Cantidad Disponible')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('product')
                    ->relationship('product', 'nombre')
                    ->label('Filtrar por producto')
                    ->searchable(),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
