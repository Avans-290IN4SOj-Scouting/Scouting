<?php
namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ManageProductsTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_product(): void
    {
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $image = new UploadedFile(
            public_path('images/products/placeholder.png'),
            'placeholder.jpg', // The name of the file
            'image/jpeg',      // The MIME type of the file
            null,              // The size of the file in bytes (null will let Laravel determine it)
            true               // Whether the file is test mode (true means yes)
        );

        $data = [
            'name' => 'Grootste Vlinderdas',
            'size_input' => ['1', '2'],
            'price_input' => [200.00, 300.00],
            'products-group-multiselect' => ['Bevers', 'Welpen'],
            'products-category-select' => 'Donkerblauw',
            'products-variety-select' => 'Unisex',
            'af-submit-app-upload-images' => $image,
        ];
        $this->actingAs($admin)->post(route('manage.products.create.store'), $data);

        $this->assertTrue(Product::where('name', $data['name'])->exists());
    }

    public function test_edit_product(): void
    {
        $initialProductType = ProductType::create(['type' => 'existing category']);
        $product = Product::create([
            'name' => 'Existing Product',
            'image_path' => 'fake_image.jpg',
            'product_type_id' => $initialProductType->id,
            'variety_id' => 1,
            'type_id' => 1,
        ]);
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $data = [
            'name' => 'Updated Product Name',
            'size_input' => ['1', '2'],
            'price_input' => [200, 300],
            'products-group-multiselect' => ['Scouts', 'Welpen'],
            'products-category-select' => 'Donkerblauw',
            'products-variety-select' => 'Unisex',
            'image_path' => 'fake_image.jpg',
        ];
        $this->actingAs($admin)->put(route('manage.products.edit.store', $product->id), $data);

        $this->assertTrue(Product::where('name', $data['name'])->exists());
    }
}
