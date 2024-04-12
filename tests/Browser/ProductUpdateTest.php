<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductUpdateTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testMarkProductAsInactive(): void
    {
        $admin = User::factory()->create(['email' => 'admin@admin.nl']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $product = Product::create([
                'name' => 'TestAll',
                'image_path' => 'https://placehold.co/200x200',
                'product_type_id' => 3,
                'description' => 'Dit is een testproduct voor iedereen.',
            ]);

            $browser->loginAs($admin)
                ->visit(route('product.EditProduct', ['id' => $product->id]))
                ->click('#hs-default-checkbox')
                ->click('#big-screen')
                ->visit(route('orders.product', ['name' => $product->name]))
                ->assertDontSee($product->name);
        });
    }
}
