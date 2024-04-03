<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_date' => $this->faker->dateTimeThisYear(),
            'email' => $this->faker->safeEmail(),
            'lid_name' => $this->faker->name(),
            'postal_code' => $this->faker->postcode(),
            'house_number' => $this->faker->numberBetween(0, 212),
            'streetname' => $this->faker->streetName(),
            'cityname' => $this->faker->city(),
            'group_id' =>  $this->faker->numberBetween(1, 4)
        ];
    }
}
