<?php

namespace Database\Factories;

use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderLine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::query()->inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'product_id' => $product->id,
            'product_price' => $this->faker->randomFloat(2, 1, 100),
            'product_size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'product_image_path' => $this->faker->imageUrl(),
            'amount' => $this->faker->numberBetween(1, 10),
        ];
    }
}
