<?php

namespace Database\Seeders;

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
        DB::table('products')->insert([
            'name' => 'TestDames',
            'discount' => 0.00,
            'product_type_id' => 1
        ]);

        DB::table('products')->insert([
            'name' => 'TestHeren',
            'discount' => 0.00,
            'product_type_id' => 2
        ]);

        DB::table('products')->insert([
            'name' => 'TestUnisex',
            'discount' => 0.00,
            'product_type_id' => 3
        ]);
    }
}
