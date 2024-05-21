<?php
namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManageProductsTest extends TestCase
{

    public function test_create_product(): void
    {
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $priceL = 200.00;
        $priceM = 200.00;
        $data = [
            'name' => 'Test Product thingy',
            'category' => 'test category',
            'af-submit-app-upload-images' => UploadedFile::fake()->image('test.jpg'),
            'custom_sizes' => ['L', 'M'],
            'custom_prices' => [$priceL, $priceM],
            'products-group-multiselect' => ['Bevers', 'Welpen'],
        ];
        $response = $this->actingAs($admin)->post(route('manage.products.create.store'), $data);


        $response->assertStatus(302);

//        $createdProductType = ProductType::where('type', 'test category')->first();
//        $this->assertNotNull($createdProductType, 'Product type should exist');

        $createdProduct = Product::where('name', 'Test Product thingy')->first();

        $this->assertNotNull($createdProduct, 'Product should exist');

        foreach ($data['custom_sizes'] as $key => $size) {
            $this->assertDatabaseHas('product_product_size', [
                'product_id' => $createdProduct->id,
                'product_size_id' => 3,
                'price' => number_format($data['custom_prices'][$key], 2),
            ]);
        }
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product thingy',
            'product_type_id' => 4
        ]);
    }

    public function test_edit_product(): void
    {
        $initialProductType = ProductType::create(['type' => 'existing category']);
        $product = Product::create([
            'name' => 'Existing Product',
            'image_path' => 'fake_image.jpg',
            'product_type_id' => $initialProductType->id
        ]);
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');

        $data = [
            'name' => 'Updated Product Name',
            'category' => 'updated category',
            'image_path' => 'fake_image.jpg',
            'custom_sizes' => ['L', 'M'],
            'custom_prices' => [200, 300],
            'products-group-multiselect' => ['Scouts', 'Welpen'],

        ];
        $response = $this->actingAs($admin)->put(route('manage.products.edit.store', $product->id), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'product_type_id' => 5,
        ]);
    }
}
