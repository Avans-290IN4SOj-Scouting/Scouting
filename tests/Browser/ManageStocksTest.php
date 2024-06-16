<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ManageStocksTest extends DuskTestCase
{
    private User $admin;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['email' => 'admin@test.com'])->assignRole('admin');
    }


    /**
     * @throws Throwable
     * @group manage-stocks
     */
    public function test_admin_update_stock(): void
    {
        $product = Product::first();
        $stockValue = random_int(1, 100);
        $size = $product->productSizes()->inRandomOrder()->first();

        $accordionItemSelector = '#accordion-item-' . $product->id;
        $sizeSelector = 'input[name="size-' . strtolower($size->size) . '-' . $product->id . '-' . $size->id . '"]';
        $updateSelector = '#update-' . $product->id;

        $this->browse(function (Browser $browser) use ($accordionItemSelector, $sizeSelector, $updateSelector, $stockValue) {
            $browser->loginAs($this->admin)
                ->visitRoute('manage.stocks.index')
                ->pause(1000)
                ->click($accordionItemSelector)
                ->pause(1000)
                ->value($sizeSelector, $stockValue)
                ->click($updateSelector)
                ->pause(1000)
                ->click($accordionItemSelector)
                ->pause(1000)
                ->assertValue($sizeSelector, $stockValue);
        });
    }
    
}
