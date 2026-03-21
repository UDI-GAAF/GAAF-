<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoriesWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 2;

    protected function getStats(): array
    {
        return Category::where('estado', 'activo')
            ->withCount('products')
            ->get()
            ->map(fn($cat) => Stat::make($cat->nombre, $cat->products_count)
                ->description($cat->descripcion)
            )->toArray();
    }
}
