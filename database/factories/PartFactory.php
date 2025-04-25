<?php

namespace Database\Factories;

use App\Models\PartCategory;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Part>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 1, 1000), // Random price between 1 and 1000
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 100
            'vehicle_id' => Vehicle::factory(),
            'part_name_id' => PartCategory::factory(),
        ];
    }
}
