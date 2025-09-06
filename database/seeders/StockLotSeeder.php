<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockLot;
use App\Models\Item;
use App\Models\Warehouse;
use Carbon\Carbon;

class StockLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        $warehouses = Warehouse::where('is_active', true)->get();

        foreach ($items as $item) {
            foreach ($warehouses as $warehouse) {
                // Create 2-3 stock lots per item per warehouse
                $lotCount = rand(2, 3);
                
                for ($i = 0; $i < $lotCount; $i++) {
                    $quantity = rand(20, 100);
                    $cost = rand(50, 200) + (rand(0, 99) / 100); // Random cost between 50-200
                    
                    StockLot::create([
                        'item_id' => $item->id,
                        'warehouse_id' => $warehouse->id,
                        'lot_no' => 'LOT-' . $item->code . '-' . $warehouse->id . '-' . ($i + 1),
                        'qty_on_hand' => $quantity,
                        'qty_reserved' => rand(0, 10),
                        'qty_available' => $quantity - rand(0, 10),
                        'cost' => $cost,
                        'received_at' => Carbon::now()->subDays(rand(1, 30)),
                        'expires_at' => Carbon::now()->addDays(rand(30, 365)),
                    ]);
                }
            }
        }
    }
}
