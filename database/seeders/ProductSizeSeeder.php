<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductSize::create([
            'size' => 'S'
        ]);
        ProductSize::create([
            'size' => 'M'
        ]);
        ProductSize::create([
            'size' => 'L'
        ]);
        ProductSize::create([
            'size' => 'XL'
        ]);
        ProductSize::create([
            'size' => 'XXL'
        ]);
    }
}
