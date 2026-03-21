<?php

namespace App\Filament\Admin\Widgets;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = now()->toDateString();

        $entradas = InventoryTransaction::where('tipoMovimiento', 'Entrada')
            ->whereDate('created_at', $today)->count();

        $salidas = InventoryTransaction::where('tipoMovimiento', 'Salida')
            ->whereDate('created_at', $today)->count();

        $productos = Product::where('estado', 'activo')->count();

        return [
            Stat::make('Entradas hoy', $entradas)
                ->color('info'),
            Stat::make('Salidas hoy', $salidas)
                ->color('danger'),
            Stat::make('Productos activos', $productos)
                ->color('warning'),
        ];
    }
}
