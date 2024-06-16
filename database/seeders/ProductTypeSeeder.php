<?php

namespace Database\Seeders;

use App\Enum\ProductTypeEnum;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ProductTypeEnum::cases();

        foreach ($types as $type) {
            ProductType::create([
                'type' => $type->value
            ]);
        }
    }
}
