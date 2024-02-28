<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::create([
            'type' => 'dames'
        ]);
        ProductType::create([
            'type' => 'unisex'
        ]);
        ProductType::create([
            'type' => 'heren'
        ]);
    }
}
