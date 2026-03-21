<?php
namespace App\Filament\Admin\Resources\Inventories\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Producto'),
                TextInput::make('cantidadDisponible')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->label('Cantidad Disponible'),
            ]);
    }
}
