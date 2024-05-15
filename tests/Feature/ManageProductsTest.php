<?php
namespace Tests\Feature;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\DuskTestCase;
class ManageProductsTest extends DuskTestCase
{
use RefreshDatabase;
    public function test_create_product(): void
    {
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $data = [
            'name' => 'Test Product',
            'category' => 'Test Category',
            'af-submit-app-upload-images' => UploadedFile::fake()->image('test.jpg'),
            'priceForSize' => ['Default' => 10],
            'products-group-multiselect' => ['Bevers', 'Welpen']
        ];
        $response = $this->actingAs($admin)->post(route('manage.products.create.store'), $data);
        $response->assertStatus(302);
    }
    public function test_edit_product(): void
    {
        $product = Product::create([
            'name' => 'Existing Product',
            'image_path' => 'fake_image.jpg',
            'product_type_id' => 1
        ]);
        $admin = User::factory()
            ->create(['email' => 'admin@test.nl'])
            ->assignRole('admin');
        $data = [
            'name' => 'Updated Product Name',
            'category' => 'Updated Category',
        ];
        $response = $this->actingAs($admin)->put(route('manage.products.edit.store', $product->id), $data);
        $response->assertStatus(302);
    }
}
