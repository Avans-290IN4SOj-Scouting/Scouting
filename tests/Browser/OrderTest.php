<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrderTest extends DuskTestCase
{
    public function test_product_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@Bevers')
                    ->click('@TestAll')
                    ->press(__('orders/orders.add-to-shoppingcart'))
                    ->assertSee(__('orders/orders.product-added'));
        });
    }

    public function test_order_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('orders.shoppingcart.index'))
                    ->click('@shoppingcart-next-button')
                    ->assertSee(__('orders/orders.order'));
        });
    }

    public function test_resizability() : void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->responsiveScreenshots('orders/home')

                    ->visit(route('orders.overview.admin', 'welpen'))
                    ->responsiveScreenshots('orders/product-overview')

                    ->visit(route('orders.product', '/TestAll/Welpen'))
                    ->responsiveScreenshots('orders/product')

                    ->visit(route('orders.shoppingcart.index'))
                    ->responsiveScreenshots('orders/shopping-cart')

                    ->visit(route('orders.checkout.order'))
                    ->responsiveScreenshots('orders/order');
        });
    }

    // This test is commented out because to my current knowledge, its not possible to test cookies with Dusk
    // if someone finds a way, it can be tested with below function
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
