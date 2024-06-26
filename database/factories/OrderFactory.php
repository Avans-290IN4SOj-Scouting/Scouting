<?php

namespace Database\Factories;

use App\Enum\DeliveryStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderLine;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_date' => $this->faker->dateTime(),
            'lid_name' => $this->faker->name(),
            'group_id' => $this->faker->numberBetween(1, 4),
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => array_rand(DeliveryStatus::localised()),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            OrderLine::factory()->count(3)->create(['order_id' => $order->id]);
        });
    }
}
