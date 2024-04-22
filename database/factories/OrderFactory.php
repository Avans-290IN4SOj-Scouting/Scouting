<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
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
            'user_id' => User::inRandomOrder()->first()->id,
            'order_status_id' => OrderStatus::inRandomOrder()->first()->id,
            'group_id' =>  Group::inRandomOrder()->first()->id
        ];
    }
}
