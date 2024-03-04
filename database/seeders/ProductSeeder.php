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
        Product::create([
            'name' => 'TestDames',
            'discount' => 0.00,
            'product_type_id' => 1
        ]);
        // // ProductProductSizes::create([
        // //     'product_id' => 1,
        // //     'product_size_id' => 1,
        // //     'price' => 12.34
        // // ]);
        // ProductProductSizes::create([
        //     'product_id' => 1,
        //     'product_size_id' => 2,
        //     'price' => 23.45
        // ]);
        // ProductProductSizes::create([
        //     'product_id' => 1,
        //     'product_size_id' => 3,
        //     'price' => 34.56
        // ]);

        Product::create([
            'name' => 'TestHeren',
            'discount' => 0.00,
            'product_type_id' => 2
        ]);

        Product::create([
            'name' => 'TestUnisex',
            'discount' => 0.00,
            'product_type_id' => 3
        ]);
    }
}
