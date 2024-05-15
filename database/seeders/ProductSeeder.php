<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCollection;
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
        {
            $productCollection = ProductCollection::create([
                'name' => 'TestAll',
            ]);
            $product = Product::create([
                'name' => 'TestAll1',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 3,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 34.56]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 45.67]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 4, 'price' => 56.78]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 5, 'price' => 67.89]);

            $product = Product::create([
                'name' => 'TestAll2',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 1,
                'product_collection_id' => $productCollection->id
            ]);

            $product->productSizes()->attach($product->id, ['product_size_id' => 4, 'price' => 56.78]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 5, 'price' => 67.89]);
         }

        {
            $productCollection = ProductCollection::create([
                'name' => 'TestDames',
            ]);
            $product = Product::create([
                'name' => 'TestDames1',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 1,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);
        }
        {
            $productCollection = ProductCollection::create([
                'name' => 'TestHeren',
            ]);
            $product = Product::create([
                'name' => 'TestHeren1',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 2,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 34.56]);
        }
        {
            $productCollection = ProductCollection::create([
                'name' => 'TestUnisex',
            ]);
            $product = Product::create([
                'name' => 'TestUnisex1',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 3,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 12.34]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);
        }
        {
            $productCollection = ProductCollection::create([
                'name' => 'TestSingleSize',
            ]);
            $product = Product::create([
                'name' => 'TestSingleSize1',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 3,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 23.45]);

            $product = Product::create([
                'name' => 'TestSingleSize2',
                'image_path' => '/images/products/placeholder.png',
                'product_type_id' => 2,
                'product_collection_id' => $productCollection->id
            ]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 1, 'price' => 23.45]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 2, 'price' => 34.56]);
            $product->productSizes()->attach($product->id, ['product_size_id' => 3, 'price' => 45.67]);

        }
    }
}
