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
            $sizes = [
                ProductSizesEnum::_116,
                ProductSizesEnum::_128,
                ProductSizesEnum::_140,
                ProductSizesEnum::_152,
                ProductSizesEnum::_164,
            ];

            $polo = Product::create([
                'name' => 'Polo - Bevers',
                'image_path' => '/images/products/polo-bevers.jpg',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $polo->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::Red)->first()->id
            ]);

            $trui = Product::create([
                'name' => 'Trui - Bevers',
                'image_path' => '/images/products/trui-bevers.jpeg',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $trui->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::Red)->first()->id
            ]);

            foreach ($sizes as $size) {
                $polo->productSizes()->attach($polo->id, [
                    'product_size_id' => ProductSize::where('size', $size)->first()->id,
                    'price' => 18.50
                ]);
                $trui->productSizes()->attach($trui->id, [
                    'product_size_id' => ProductSize::where('size', $size)->first()->id,
                    'price' => 20.00
                ]);
            }
        }
        // Gidsen
        {
            $sizes = [
                ProductSizesEnum::_140,
                ProductSizesEnum::_152,
                ProductSizesEnum::_164,
                ProductSizesEnum::S,
                ProductSizesEnum::M,
                ProductSizesEnum::L,
            ];

            $polo = Product::create([
                'name' => 'Polo - Gidsen',
                'image_path' => '/images/products/polo-gidsen.jpg',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $polo->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::DarkBlue)->first()->id
            ]);

            $trui = Product::create([
                'name' => 'Trui - Gidsen',
                'image_path' => '/images/products/trui-gidsen.jpg',
                'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
            ]);

            $trui->productTypes()->attach($product->id, [
                'product_type_id' => ProductType::where('type', ProductTypeEnum::DarkBlue)->first()->id
            ]);

            foreach ($sizes as $size) {
                $poloPrice = ($size == ProductSizesEnum::S || $size == ProductSizesEnum::M || $size == ProductSizesEnum::L) ? 23.00 : 18.50;
                $truiPrice = ($size == ProductSizesEnum::S || $size == ProductSizesEnum::M || $size == ProductSizesEnum::L) ? 26.00 : 20.00;

                $polo->productSizes()->attach($polo->id, [
                    'product_size_id' => ProductSize::where('size', $size)->first()->id,
                    'price' => $poloPrice
                ]);
                $trui->productSizes()->attach($trui->id, [
                    'product_size_id' => ProductSize::where('size', $size)->first()->id,
                    'price' => $truiPrice
                ]);
            }
            // Kabouters
            {
                $sizes = [
                    ProductSizesEnum::_116,
                    ProductSizesEnum::_128,
                    ProductSizesEnum::_140,
                    ProductSizesEnum::_152,
                    ProductSizesEnum::_164,
                ];

                $polo = Product::create([
                    'name' => 'Polo - Kabouters',
                    'image_path' => '/images/products/polo-kabouter.jpg',
                    'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
                ]);

                $polo->productTypes()->attach($product->id, [
                    'product_type_id' => ProductType::where('type', ProductTypeEnum::LightBlue)->first()->id
                ]);

                $trui = Product::create([
                    'name' => 'Trui - Kabouters',
                    'image_path' => '/images/products/trui-kabouter.jpeg',
                    'variety_id' => ProductVariety::where('variety', ProductVarietyEnum::Unisex)->first()->id,
                ]);

                $trui->productTypes()->attach($product->id, [
                    'product_type_id' => ProductType::where('type', ProductTypeEnum::LightBlue)->first()->id
                ]);

                foreach ($sizes as $size) {
                    $polo->productSizes()->attach($polo->id, [
                        'product_size_id' => ProductSize::where('size', $size)->first()->id,
                        'price' => 18.50
                    ]);
                    $trui->productSizes()->attach($trui->id, [
                        'product_size_id' => ProductSize::where('size', $size)->first()->id,
                        'price' => 20.00
                    ]);
                }
            }
        }
    }

}
