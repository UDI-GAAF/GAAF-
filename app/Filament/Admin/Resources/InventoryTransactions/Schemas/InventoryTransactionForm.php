<?php
namespace App\Filament\Admin\Resources\InventoryTransactions\Schemas;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;

class InventoryTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'nombre')
                    ->required()
                    ->label('Material'),
                Select::make('tipoMovimiento')
                    ->options([
                        'Entrada' => 'Entrada',
                        'Salida' => 'Salida',
                        'Ajuste' => 'Ajuste',
                    ])
                    ->required()
                    ->live()
                    ->label('Tipo de Movimiento'),
                TextInput::make('cantidad')
                    ->required()
                    ->numeric()
                    ->minValue(0.01)
                    ->label('Cantidad'),
                DateTimePicker::make('fechaMovimiento')
                    ->required()
                    ->default(fn () => now())
                    ->label('Fecha del Movimiento'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->default(fn () => auth()->id())
                    ->label('Usuario Responsable'),
                Textarea::make('observacion')
                    ->label('Observaciones')
                    ->columnSpanFull(),
            ]);
    }
}
