<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->product = Product::create([
            'nombre' => 'Material A',
            'tipoMaterial' => 'MateriaPrima',
            'unidadMedida' => 'kg',
            'descripcion' => 'Test material',
            'estado' => true,
        ]);
    }

    public function test_can_create_material_and_assign_categories()
    {
        $category1 = Category::create(['nombre' => 'Cat 1']);
        $category2 = Category::create(['nombre' => 'Cat 2']);
        
        $this->product->categories()->attach([$category1->id, $category2->id]);
        
        $this->assertCount(2, $this->product->categories);
    }

    public function test_inventory_increases_on_entrada()
    {
        InventoryTransaction::create([
            'product_id' => $this->product->id,
            'tipoMovimiento' => 'Entrada',
            'cantidad' => 100.50,
            'fechaMovimiento' => now(),
            'user_id' => $this->user->id,
        ]);

        $inventory = Inventory::where('product_id', $this->product->id)->first();
        
        $this->assertNotNull($inventory);
        $this->assertEquals(100.50, $inventory->cantidadDisponible);
    }

    public function test_inventory_decreases_on_salida()
    {
        // First Input
        InventoryTransaction::create([
            'product_id' => $this->product->id,
            'tipoMovimiento' => 'Entrada',
            'cantidad' => 200,
            'fechaMovimiento' => now(),
            'user_id' => $this->user->id,
        ]);

        // Output
        InventoryTransaction::create([
            'product_id' => $this->product->id,
            'tipoMovimiento' => 'Salida',
            'cantidad' => 50,
            'fechaMovimiento' => now(),
            'user_id' => $this->user->id,
        ]);

        $inventory = Inventory::where('product_id', $this->product->id)->first();
        $this->assertEquals(150, $inventory->cantidadDisponible);
    }

    public function test_inventory_prevents_salida_when_insufficient_stock()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('La cantidad solicitada supera el inventario disponible.');

        InventoryTransaction::create([
            'product_id' => $this->product->id,
            'tipoMovimiento' => 'Salida',
            'cantidad' => 10,
            'fechaMovimiento' => now(),
            'user_id' => $this->user->id,
        ]);
    }

    public function test_inventory_updates_on_ajuste()
    {
        InventoryTransaction::create([
            'product_id' => $this->product->id,
            'tipoMovimiento' => 'Ajuste',
            'cantidad' => 25,
            'fechaMovimiento' => now(),
            'user_id' => $this->user->id,
        ]);

        $inventory = Inventory::where('product_id', $this->product->id)->first();
        $this->assertEquals(25, $inventory->cantidadDisponible);
    }
}
