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
        {
            $product = Product::create([
                'name' => 'TestAll',
                'image_path' => '/images/products/placeholder.png',
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 34.56]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 45.67]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 4, 'price' => 56.78]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 5, 'price' => 67.89]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 2]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 3]);
        }

        {
            $product = Product::create([
                'name' => 'TestDames',
                'image_path' => '/images/products/placeholder.png',
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 2]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 3]);
        }
        {
            $product = Product::create([
                'name' => 'TestHeren',
                'image_path' => '/images/products/placeholder.png',
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 2]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 3]);
        }
        {
            $product = Product::create([
                'name' => 'TestUnisex',
                'image_path' => '/images/products/placeholder.png',
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 2]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 3]);
        }
        {
            $product = Product::create([
                'name' => 'TestSingleSize',
                'image_path' => '/images/products/placeholder.png',
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);

            $product->productTypes()->attach($product->id, ['product_type_id' => 1]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 2]);
            $product->productTypes()->attach($product->id, ['product_type_id' => 3]);
        }
    }

}
