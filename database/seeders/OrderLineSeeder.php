<?php

namespace Database\Seeders;

use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderLine::create([
            'order_id' => 1,
            'product_id' => 1,
            'amount' => 1,
            'product_price' => 12.34,
            'product_size' => 'S',
            'product_image_path' => Product::where('id', 1)->first()->image_path,
            'product_type_id' => 1
        ]);

        OrderLine::create([
            'order_id' => 1,
            'product_id' => 2,
            'amount' => 2,
            'product_price' => 23.45,
            'product_size' => 'S',
            'product_image_path' => Product::where('id', 2)->first()->image_path,
            'product_type_id' => 1
        ]);
    }
}
