<?php

namespace Database\Seeders;

use App\Enum\ProductSizesEnum;
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
        $allSizes = ProductSizesEnum::cases();

        foreach ($allSizes as $size) {
            ProductSize::create([
                'size' => $size->value,
            ]);
        }
    }
}
