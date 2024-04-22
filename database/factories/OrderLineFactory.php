<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderLine>
 */
class OrderLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $product = Product::inRandomOrder()->first();
        $order = Order::inRandomOrder()->first();

        return [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'amount' => $this->faker->numberBetween(1,3),
            'product_price' => $this->faker->randomFloat(2, 15, 70),
            'product_size' => ProductSize::inRandomOrder()->first()->size
        ];
    }
}
