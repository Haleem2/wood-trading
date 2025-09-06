<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        $species = $this->faker->randomElement(['Pine', 'Oak', 'Beech', 'Maple', 'Cherry']);
        $grade = $this->faker->randomElement(['A', 'B', 'Premium', 'Standard']);
        $unit = $this->faker->randomElement(['piece', 'm', 'm²', 'm³', 'sheet']);

        return [
            'code' => strtoupper($species) . '-' . $this->faker->unique()->numerify('###'),
            'name' => $species . ' ' . $this->faker->word . ' ' . $this->faker->randomElement(['2x4', '2x6', '1x4', '1x6']),
            'species' => $species,
            'grade' => $grade,
            'thickness' => $this->faker->randomFloat(2, 10, 50),
            'width' => $this->faker->randomFloat(2, 50, 200),
            'length' => $this->faker->randomFloat(2, 1000, 3000),
            'unit' => $unit,
            'barcode' => $this->faker->unique()->ean13,
            'moisture_level' => $this->faker->randomFloat(1, 8, 20),
            'low_stock_threshold' => $this->faker->randomFloat(2, 10, 100),
            'costing_method' => $this->faker->randomElement(['FIFO', 'Average']),
            'is_active' => true,
        ];
    }
}
