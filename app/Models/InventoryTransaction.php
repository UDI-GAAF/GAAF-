<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = ['product_id', 'tipoMovimiento', 'cantidad', 'fechaMovimiento', 'user_id', 'observacion'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            $inventory = Inventory::firstOrCreate(
                ['product_id' => $transaction->product_id],
                ['cantidadDisponible' => 0]
            );

            if ($transaction->tipoMovimiento === 'Entrada') {
                $inventory->cantidadDisponible += $transaction->cantidad;
            } elseif ($transaction->tipoMovimiento === 'Salida') {
                if ($inventory->cantidadDisponible < $transaction->cantidad) {
                    throw new \Exception('La cantidad solicitada supera el inventario disponible.');
                }
                $inventory->cantidadDisponible -= $transaction->cantidad;
            } elseif ($transaction->tipoMovimiento === 'Ajuste') {
                $inventory->cantidadDisponible += $transaction->cantidad;
            }
            $inventory->save();
        });
    }
}
