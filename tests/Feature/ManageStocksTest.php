<?php


use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Tests\TestCase;

class ManageStocksTest extends TestCase
{

    /**
     * @throws Throwable
     */
    public function test_admin_update_stock_success(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::inRandomOrder()->first();
        $type = $product->productTypes()->inRandomOrder()->first();
        $productSize = $product->productSizes()->inRandomOrder()->first();

        $newAmount = 2;

        $response = $this->actingAs($admin)
            ->put(route('manage.stocks.update', ['product' => $product->id, 'type' => $type->id]), ['size-' . strtolower($productSize->size) => $newAmount]);

        $response->assertRedirect()
            ->assertSessionHas('toast-type', 'success')
            ->assertSessionHas('toast-message', __('manage-stocks/stocks.update_inventory_success'));

        $stock = Stock::where([
            'product_id' => $product->id,
            'product_type_id' => $type->id,
            'product_size_id' => $productSize->id
        ])->first();

        $this->assertEquals($newAmount, $stock->amount);
    }

    /**
     * @throws Throwable
     */
    public function test_admin_update_stock_fail(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::inRandomOrder()->first();
        $type = $product->productTypes()->inRandomOrder()->first();
        $productSize = $product->productSizes()->inRandomOrder()->first();

        $originalStock = Stock::where([
            'product_id' => $product->id,
            'product_type_id' => $type->id,
            'product_size_id' => $productSize->id
        ])->first();
        $originalAmount = $originalStock?->amount;

        $newAmount = -1;

        $response = $this->actingAs($admin)
            ->put(route('manage.stocks.update', ['product' => $product->id, 'type' => $type->id]), ['size-' . strtolower($productSize->size) => $newAmount]);

        $response->assertRedirect()
            ->assertSessionHas('toast-type', 'error')
            ->assertSessionHas('toast-message', __('manage-stocks/stocks.invalid_amount'));

        $updatedStock = Stock::where([
            'product_id' => $product->id,
            'product_type_id' => $type->id,
            'product_size_id' => $productSize->id
        ])->first();

        if (!$updatedStock || $updatedStock->amount === $originalAmount) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

}
