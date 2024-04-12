<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_mark_product_as_inactive(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        $admin->assignRole('admin');

        $product = Product::create([
            'name' => 'TestAll',
            'image_path' => 'https://placehold.co/200x200',
            'product_type_id' => 3,
            'description' => 'Dit is een testproduct voor iedereen.',
        ]);

        $response = $this->actingAs($admin)->put(route('product.update', ['id' => $product->id]),
            [
                'name' => $product->name,
                'inactive' => 'true'
            ]
        );

        $response->assertRedirect(route('product.EditProduct', ['id' => $product->id]))
            ->assertSessionHas('success', 'Product updated successfully.');

        $updatedProduct = Product::find($product->id);

        $this->assertEquals(1, $updatedProduct->inactive);
    }
}
