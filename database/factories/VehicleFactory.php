<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\Vehicle;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = (new \Faker\Factory())->create();
        $faker->addProvider(new FakeCar($faker));

        return [
            'shipment_id' => Shipment::factory(), // Creates a linked shipment
            'input_date' => $this->faker->date(),
            'provider_name' => 'KARMEN',
            'origin_id' => 'karmen_' . $this->faker->randomNumber(),
            'make_id' => $this->faker->randomNumber(),
            'make_title' => $this->faker->vehicleBrand(),
            'model_id' => $this->faker->randomNumber(),
            'model_title' => $this->faker->vehicleModel(),
            'grade' => $this->faker->word(),
            'chassis_model' => $this->faker->word(),
            'chassis_number' => $this->faker->numerify('######'),
            'veh_fuel' => $this->faker->randomElement(['Gasoline', 'Diesel', 'Electric']),
            'veh_trans' => $this->faker->randomElement(['ATM', 'MT']),
            'veh_traction' => $this->faker->randomElement(['2WD', '4WD']),
            'veh_km' => $this->faker->numberBetween(5000, 100000),
            'veh_cc' => $this->faker->numberBetween(1000, 5000),
            'veh_year' => $this->faker->year(),
            'veh_month' => $this->faker->numberBetween(1, 12),
            'veh_color' => $this->faker->safeColorName(),
            'gross_weight' => $this->faker->numberBetween(1500, 3000),
            'net_weight' => $this->faker->numberBetween(1000, 2000),
            'veh_length' => $this->faker->numberBetween(300, 500),
            'veh_height' => $this->faker->numberBetween(100, 200),
            'veh_width' => $this->faker->numberBetween(150, 200),
            'other_info' => $this->faker->sentence(),
            'engine_type' => $this->faker->word(),
            'engine_no' => $this->faker->numerify('#####'),
            'purchase_price' => $this->faker->randomFloat(2, 1000, 50000),
        ];

    }
}
