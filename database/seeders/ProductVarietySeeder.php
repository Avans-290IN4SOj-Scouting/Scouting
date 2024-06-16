<?php

namespace Database\Seeders;

use App\Enum\ProductVarietyEnum;
use App\Models\ProductVariety;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVarietySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $varieties = ProductVarietyEnum::cases();

        foreach ($varieties as $variety) {
            ProductVariety::create([
                'variety' => $variety,
            ]);
        }
    }
}
