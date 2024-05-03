<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProductsTest extends DuskTestCase
{
    protected $admin;


    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['email' => 'role@test.com']);
        $this->admin->assignRole('admin');
    }

//    public function test_resizability(): void
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->loginAs($this->admin);
//            $browser->resize(1200, 800);
//            $browser->visit(route('manage.products.index'))
//                ->responsiveScreenshots('products/overview/overview-page')
//                ->visit(route('manage.products.create.index'))
//                ->responsiveScreenshots('products/add-product/manage-addProduct');
//        });
//    }
//    public function test_addProduct_flow(): void
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->loginAs($this->admin);
//            $browser->visit(route('manage.products.index'))
//                ->pause(5000)
//                ->screenshot("redirectingCorrectlyWhenSubmitted")
//                ->click('.add-product-button')
//                ->assertSeeIn('#add-product-heading', 'Toevoegen')
//                ->type('name', 'Das')
//                ->type('priceForSize[Default]', '10')
//                ->waitFor('#product-price')
//                ->assertValue('#product-price', '10')
//                ->check('#same-price-all')
//                ->assertSee('Specifieke Maten')
//                ->type('priceForSize[L]', '10')
//                ->click('@multiple-select-' . trans('products.group-multiselect') . ' + *')
//                ->click(__('[data-value="Bevers"]'))
//                ->click(__('[data-value="Kabouters"]'))
//                ->click('@multiple-select-' . trans('products.group-multiselect') . ' + *')
//                ->type('category', 'groen')
//                ->attach('af-submit-app-upload-images', 'public/images/products/placeholder.png')
//                ->click('.submit-add')
//
//                ->assertSee('Product succesvol aangemaakt!');
//        });
//    }

    public function test_editProduct_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->visit(route('manage.products.index'))
                ->click('@edit-product-button')
                ->assertSee(__('manage-products/products.edit_page_title'))
                ->type('priceForSize[Default]', '10')

                ->click('@multiple-select-'.__('manage-products/products.groups-multiselect').' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))
                ->click('.add-product')
                ->screenshot("redirectingCorrectlyWhenSubmittedEdit");
        });
    }
}
