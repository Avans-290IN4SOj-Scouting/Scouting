<?php

namespace Database\Seeders;

use App\Models\Product;
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

            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 7.75]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
        }
    }

}
