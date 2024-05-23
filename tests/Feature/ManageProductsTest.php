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
        $data = [
            'name' => 'Grootste Vlinderdas',
            'products-category-multiselect' => ['Groen', 'Blauw'],
            'af-submit-app-upload-images' => UploadedFile::fake()->image('test.jpg'),
            'custom_sizes' => ['L', 'M'],
            'custom_prices' => [200.00, 300.00],
            'products-group-multiselect' => ['Bevers', 'Welpen'],
        ];
        $response = $this->actingAs($admin)->post(route('manage.products.create.store'), $data);

        $response->assertStatus(302);

        $response->assertRedirect(route('manage.products.index'))
            ->assertSessionHas('toast-type', 'success')
            ->assertSessionHas('toast-message', __('toast/messages.success-product-add'));
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
            'products-category-multiselect' => ['Groen', 'Blauw'],
            'image_path' => 'fake_image.jpg',
            'custom_sizes' => ['L', 'M'],
            'custom_prices' => [200, 300],
            'products-group-multiselect' => ['Scouts', 'Welpen'],
        ];
        $response = $this->actingAs($admin)->put(route('manage.products.edit.store', $product->id), $data);

        $response->assertStatus(302);

        $response->assertRedirect(route('manage.products.index'))
            ->assertSessionHas('success', __('manage-products/products.update_success'));
    }
}
