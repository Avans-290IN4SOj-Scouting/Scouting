<?php

namespace Database\Factories;

use App\Enum\ProductSizesEnum;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductProductType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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
            'product_size' => $this->faker->randomElement(ProductSizesEnum::cases()),
            'product_image_path' => $product->image_path,
            'amount' => $this->faker->numberBetween(1, 10),
            'product_type_id' => ProductProductType::where('product_id', $product->id)->first()->product_type_id,
        ];
    }
}
