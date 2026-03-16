<?php

namespace App\Filament\Admin\Resources\Inventories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cantidadDisponible')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
