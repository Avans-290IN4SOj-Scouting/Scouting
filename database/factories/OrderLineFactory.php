<?php

namespace Database\Factories;

use App\Enum\ProductSizesEnum;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductProductSize;
use App\Models\ProductProductType;
use App\Models\ProductSize;
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
        $product = Product::query()->inRandomOrder()->first();
        $sizes = ProductProductSize::where('product_id', $product->id)->get() ?? ProductSizesEnum::nvt;
        $size = ProductSize::where('id', $sizes->random()->product_size_id)->first();
        $amount = $this->faker->numberBetween(1, 2);

        return [
            'product_id' => $product->id,
            'product_price' => ProductProductSize::where('product_size_id', $size->id)->first()->price * $amount,
            'product_size' => $size,
            'product_image_path' => $product->image_path,
            'amount' => $amount,
            'product_type_id' => ProductProductType::where('product_id', $product->id)->first()->product_type_id,
        ];
    }
}
