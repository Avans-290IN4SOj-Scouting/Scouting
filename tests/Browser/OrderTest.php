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
            $browser->visit(route('home', ['category' => 'Bevers', 'size' => 'S']))
                ->assertSee('- ' . __('orders.products'));
        });
    }

    public function test_to_product(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('home', ['category' => 'Bevers', 'size' => 'S']))
                ->click('.product a')
                ->assertUrlIs(route('orders.product', ['id' => 2, 'size' => 'S']));
        });
    }

    public function test_size_no_products(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('home', ['category' => 'Bevers', 'size' => 'XXL']))
                ->assertSee(__('orders.no-products-to-show'));
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
