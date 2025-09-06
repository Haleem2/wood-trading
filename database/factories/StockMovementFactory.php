<?php

namespace Database\Factories;

use App\Models\StockMovement;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\StockLot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'warehouse_id' => Warehouse::factory(),
            'stock_lot_id' => StockLot::factory(),
            'type' => $this->faker->randomElement(['purchase_receipt', 'sales_issue', 'adjustment', 'transfer', 'return']),
            'movement' => $this->faker->randomElement(['in', 'out']),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
            'unit_cost' => $this->faker->randomFloat(2, 10, 500),
            'reference_type' => $this->faker->randomElement(['purchase_order', 'sales_order', 'adjustment']),
            'reference_id' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->sentence,
            'created_by' => User::factory(),
        ];
    }
}
