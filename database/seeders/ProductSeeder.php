<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $product = Product::create([
                'name' => 'TestDames',
                'discount' => 0.00,
                'image_path' => 'https://placehold.co/200x200',
                'product_type_id' => 1
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);
        }
        {
            $product = Product::create([
                'name' => 'TestHeren',
                'discount' => 0.20,
                'image_path' => 'https://placehold.co/200x200',
                'product_type_id' => 2
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);
        }
        {
            $product = Product::create([
                'name' => 'TestUnisex',
                'discount' => 0.00,
                'image_path' => 'https://placehold.co/200x200',
                'product_type_id' => 3
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);
        }
    }
}
