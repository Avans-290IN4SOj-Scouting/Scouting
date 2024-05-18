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
     */
    public function test_admin_update_stock(): void
    {
        $product = Product::inRandomOrder()->first();
        $stockValue = random_int(1, 9);
        $size = $product->productSizes()->inRandomOrder()->first();
        $typeIndex = random_int(1, 3);

        $accordionItemSelector = '#accordion-item-' . $product->id;
        $sizeSelector = '#size-' . strtolower($size->size) . '-' . $product->id . '-' . $typeIndex;
        $updateSelector = '#update-' . $product->id . '-' . $typeIndex;

        $this->browse(function (Browser $browser) use ($accordionItemSelector, $sizeSelector, $updateSelector, $typeIndex, $stockValue) {
            $browser->loginAs($this->admin)
                ->visitRoute('manage.stocks.index')
                ->pause(1000)
                ->click($accordionItemSelector)
                ->pause(1000)
                ->click($accordionItemSelector . '-' . $typeIndex)
                ->pause(1000)
                ->click($sizeSelector)
                ->pause(1000)
                ->value($sizeSelector, $stockValue)
                ->click($updateSelector)
                ->pause(1000)
                ->click($accordionItemSelector)
                ->pause(1000)
                ->click($accordionItemSelector . '-' . $typeIndex)
                ->pause(1000)
                ->assertValue($sizeSelector, $stockValue);
        });
    }

}
