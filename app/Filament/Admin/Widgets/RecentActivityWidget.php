<?php

namespace App\Filament\Admin\Widgets;

use App\Models\InventoryTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?string $heading = 'Actividad reciente';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(InventoryTransaction::with(['product', 'user'])->latest()->limit(6))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
                Tables\Columns\TextColumn::make('tipoMovimiento')->label('Tipo')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'Entrada' => 'success',
                        'Salida' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('product.nombre')->label('Producto'),
                Tables\Columns\TextColumn::make('cantidad')->label('Cantidad'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')
                    ->dateTime('d/m/Y · H:i'),
            ]);
    }
}
