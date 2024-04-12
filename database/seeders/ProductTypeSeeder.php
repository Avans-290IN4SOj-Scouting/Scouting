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
            'type' => 'rood'
        ]);
        ProductType::create([
            'type' => 'groen'
        ]);
        ProductType::create([
            'type' => 'blauw'
        ]);
    }
}
