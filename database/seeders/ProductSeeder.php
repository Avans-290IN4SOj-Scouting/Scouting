<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = ['Wandelschoenen', 'Vest', 'Shirt', 'Broek', 'Hoed', 'Sjaal', 'Riem'];

        foreach ($productNames as $productName) {
            $product = Product::create([
                'name' => $productName,
                'image_path' => '/images/products/placeholder.png',
            ]);

            for ($i = 1; $i <= 5; $i++) {
                $product->productSizes()->attach($product->id, ['product_size_id' => $i, 'price' => 23.45]);
            }

            for ($i = 1; $i <= 3; $i++) {
                $product->productTypes()->attach($product->id, ['product_type_id' => $i]);
            }
        }
    }
}
