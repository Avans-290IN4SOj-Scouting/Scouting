<?php

namespace Database\Seeders;

use App\Enum\ProductSizesEnum;
use App\Enum\ProductTypeEnum;
use App\Enum\ProductVarietyEnum;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\ProductVariety;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Das
        {
            $product = Product::create([
                'name' => 'Das',
                'image_path' => '/images/products/das.png',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $product->productSizes()->attach($product->id, [
                'product_size_id' => ProductSize::where('size', ProductSizesEnum::nvt)->first()->id,
                'price' => 7.75
            ]);

            $product->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::Default)->first()->id
            ]);
        }
        // Dasring
        {
            $product = Product::create([
                'name' => 'Dasring',
                'image_path' => '/images/products/dasring.png',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $product->productSizes()->attach($product->id, [
                'product_size_id' => ProductSize::where('size', ProductSizesEnum::nvt)->first()->id,
                'price' => 2.75
            ]);

            $product->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::Default)->first()->id
            ]);
        }
        // Bevers
        {
            $polo = Product::create([
                'name' => 'Polo - Bevers',
                'image_path' => '/images/products/polo-bevers.jpg',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $poloSizes = [
                ProductSizesEnum::_116,
                ProductSizesEnum::_128,
                ProductSizesEnum::_140,
                ProductSizesEnum::_152,
                ProductSizesEnum::_164,
            ];

            foreach ($poloSizes as $size) {
                $polo->productSizes()->attach($polo->id, [
                    'product_size_id' => ProductSize::where('size', $size)->first()->id,
                    'price' => 18.50
                ]);
            }

            $polo->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::Red)->first()->id
            ]);
        }
    }

}
