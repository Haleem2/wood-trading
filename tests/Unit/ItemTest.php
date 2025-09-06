<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Models\StockLot;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_can_calculate_total_stock()
    {
        $item = Item::factory()->create();
        $warehouse = Warehouse::factory()->create();

        StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'qty_on_hand' => 100,
        ]);

        StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'qty_on_hand' => 50,
        ]);

        $this->assertEquals(150, $item->total_stock);
    }

    public function test_item_can_calculate_available_stock()
    {
        $item = Item::factory()->create();
        $warehouse = Warehouse::factory()->create();

        StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'qty_on_hand' => 100,
            'qty_reserved' => 20,
        ]);

        $this->assertEquals(80, $item->available_stock);
    }

    public function test_item_can_detect_low_stock()
    {
        $item = Item::factory()->create([
            'low_stock_threshold' => 50,
        ]);
        $warehouse = Warehouse::factory()->create();

        StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'qty_on_hand' => 30,
            'qty_reserved' => 10,
        ]);

        $this->assertTrue($item->isLowStock());
    }

    public function test_item_does_not_detect_low_stock_when_above_threshold()
    {
        $item = Item::factory()->create([
            'low_stock_threshold' => 50,
        ]);
        $warehouse = Warehouse::factory()->create();

        StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'qty_on_hand' => 100,
            'qty_reserved' => 20,
        ]);

        $this->assertFalse($item->isLowStock());
    }

    public function test_item_has_stock_lots_relationship()
    {
        $item = Item::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $stockLot = StockLot::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $this->assertTrue($item->stockLots->contains($stockLot));
    }

    public function test_item_has_stock_movements_relationship()
    {
        $item = Item::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $stockMovement = \App\Models\StockMovement::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $this->assertTrue($item->stockMovements->contains($stockMovement));
    }
}
