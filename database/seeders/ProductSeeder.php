<?php

namespace Database\Seeders;

use App\Enum\ProductSizesEnum;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Das
        {
            $product = Product::create([
                'name' => 'Das',
                'image_path' => '/images/products/das.png',
            ]);

            $product->productSizes()->attach($product->id, [
                'product_size_id' => ProductSize::where('size', ProductSizesEnum::nvt)->first()->id,
                'price' => 7.75
            ]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
        }
        // Dasring
        {
            $product = Product::create([
                'name' => 'Dasring',
                'image_path' => '/images/products/dasring.png',
            ]);

            $product->productSizes()->attach($product->id, [
                'product_size_id' => ProductSize::where('size', ProductSizesEnum::nvt)->first()->id,
                'price' => 2.75
            ]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
        }
    }

}
