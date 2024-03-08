<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrderTest extends DuskTestCase
{
    public function test_on_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product-categorie/Bevers/S')
                    ->assertSee('- ' . __('orders.products'));
        });
    }

    public function test_to_product(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product-categorie/Bevers/S')
                    ->click('.product a')
                    ->assertUrlIs(env('APP_URL') . '/product/2/S');
        });
    }

    public function test_size_no_products(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product-categorie/Bevers/XXL')
                    ->assertSee(__('orders.no-products-to-show'));
        });
    }

    public function test_product_has_sale(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product-categorie/Bevers/S')
                    ->assertVisible('.product .pre-discount-price');
        });
    }

    // public function test_shoppingcart(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/product-categorie/Bevers/S')
    //                 ->click('.product .add-product')
    //                 ->screenshot('shoppingcart-cookie-never-set')
    //                 ->assertHasCookie('shopping-cart');
    //     });
    // }
}
