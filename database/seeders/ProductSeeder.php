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
                'product_type_id' => 1
            ]);
            $product->productSizes()->attach($product->id, ['price' => 12.34]);
        }
        {
            $product = Product::create([
                'name' => 'TestHeren',
                'discount' => 0.00,
                'product_type_id' => 2
            ]);
            $product->productSizes()->attach($product->id, ['price' => 23.45]);
        }
        {
            $product = Product::create([
                'name' => 'TestUnisex',
                'discount' => 0.00,
                'product_type_id' => 3
            ]);
            $product->productSizes()->attach($product->id, ['price' => 34.56]);
        }
    }
}
