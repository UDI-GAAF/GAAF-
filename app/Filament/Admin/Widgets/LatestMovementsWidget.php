<?php

namespace App\Filament\Admin\Widgets;

use App\Models\InventoryTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMovementsWidget extends BaseWidget
{
    protected static ?string $heading = 'Últimos movimientos';
    protected int | string | array $columnSpan = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(InventoryTransaction::latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->formatStateUsing(fn($state) => '#MOV-' . str_pad($state, 4, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('product.nombre')
                    ->label('Producto'),
                Tables\Columns\BadgeColumn::make('tipoMovimiento')
                    ->label('Tipo')
                    ->colors([
                        'info' => 'Entrada',
                        'danger' => 'Salida',
                        'warning' => 'Ajuste',
                    ]),
                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cant.'),
            ]);
    }
}
