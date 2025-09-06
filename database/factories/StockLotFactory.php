<?php

namespace Database\Factories;

use App\Models\StockLot;
use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockLotFactory extends Factory
{
    protected $model = StockLot::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'warehouse_id' => Warehouse::factory(),
            'lot_no' => 'LOT-' . $this->faker->unique()->numerify('########'),
            'qty_on_hand' => $this->faker->randomFloat(2, 0, 1000),
            'qty_reserved' => $this->faker->randomFloat(2, 0, 100),
            'qty_available' => function (array $attributes) {
                return $attributes['qty_on_hand'] - $attributes['qty_reserved'];
            },
            'cost' => $this->faker->randomFloat(2, 10, 500),
            'received_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'expires_at' => $this->faker->dateTimeBetween('now', '+365 days'),
        ];
    }
}
