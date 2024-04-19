<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageProductsTest extends DuskTestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['email' => 'role.dropdown.test']);
        $this->admin->assignRole('admin');
    }

    public function test_resizability(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);

            // Ensure the browser window is in a normal state before starting the test
            $browser->resize(1200, 800);

            $browser->visit(route('manage.products.index'))
                ->responsiveScreenshots('products/overview/overview-page')
                ->visit(route('manage.products.create.index'))
                ->responsiveScreenshots('products/add-product/manage-addProduct');
        });
    }
    public function test_addProduct_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->visit(route('manage.products.index'))
                ->click('.add-product-button')
                ->assertSeeIn('#add-product-heading', 'Toevoegen')
                ->type('name', 'Das')
                ->type('priceForSize[Default]', '10')
                ->waitFor('#product-price')
                ->assertValue('#product-price', '10')
                ->check('#same-price-all')
                ->assertSee('Specifieke Maten')

                ->click('@multiple-select-'.trans('products.group-multiselect').' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))

                ->screenshot("test1");
        });
    }

    /*    public function test_editProduct_flow(): void
        {
            $this->browse(function (Browser $browser) {
                $browser->loginAs($this->admin);
                $browser->visit(route('manage-products'))
                    ->click('.edit-product-button')
                    ->assertSeeIn('#edit-product-heading', 'Bewerken')
                    ->type('name', 'Test Product')
                    ->type('priceForSize[Default]', '50')
                    ->type('description', 'New Test Description')
                    ->select('#groups', ['scouts', 'kabouters'])
                    ->press('submit-product')
                    ->pause(5000)
                    ->assertPathIs('/admin.products');
            });
        }*/

}
