<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Select::make('tipoMaterial')
                    ->options([
                        'MateriaPrima' => 'Materia Prima',
                        'ProductoTerminado' => 'Producto Terminado',
                        'Residual' => 'Residual',
                    ])
                    ->required(),
                TextInput::make('unidadMedida')
                    ->required()
                    ->maxLength(255),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                Toggle::make('estado')
                    ->default(true),
                Select::make('categories')
                    ->multiple()
                    ->relationship('categories', 'nombre')
                    ->preload(),
            ]);
    }
}
