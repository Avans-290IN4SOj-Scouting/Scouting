<?php

namespace Tests\Browser;

use App\Models\Product;
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
        $this->admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ])->assignRole('admin');
    }

    public function test_resizability(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->resize(1200, 800);
            $product = Product::get()->first();
            if ($product) {
                $productId = $product->id;

                $browser->visit(route('manage.products.index'))
                    ->responsiveScreenshots('products/products/products-page')
                    ->visit(route('manage.products.create.index'))
                    ->responsiveScreenshots('products/add-product/manage-addProduct')
                    ->visit(route('manage.products.edit.index', ['id' => $productId]))
                    ->responsiveScreenshots('products/edit-product/manage-editProduct');
            } else {
                $this->assertTrue(false, 'No product found in the database.');
            }
        });
    }
    public function test_addProduct_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->visit(route('manage.products.index'))
                ->click('.add-product-button')
                ->assertSee(__('manage-products/products.create_page_title'))
                ->type('name', 'Das')
                ->type('priceForSize[Default]', '10')
                ->assertValue('input[name="priceForSize[Default]"]', '10')
                ->check('#same-price-all')
                ->assertSee(__('manage-products/products.custom_sizes_label'))
                ->type('input[name="custom_sizes[]"]', 'L')
                ->type('input[name="custom_prices[]"]', '10')
                ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))
                ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')

                ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))


                ->type('category', 'groen')
                ->attach('af-submit-app-upload-images', 'public/images/products/placeholder.png')
                ->click('.submit-add')
                ->assertSee(__('toast/messages.success-product-add'));
            });
        }

        public function test_editProduct_flow(): void
        {
            $this->browse(function (Browser $browser) {
                $browser->loginAs($this->admin);
                $browser->visit(route('manage.products.index'))
                    ->click('@edit-product-button')
                    ->assertSee(__('manage-products/products.edit_page_title'))
                    ->type('priceForSize[L]', '10')
                    ->assertValue('input[name="priceForSize[L]"]', '10')
                    ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                    ->click(__('[data-value="Bevers"]'))
                    ->click(__('[data-value="Kabouters"]'))
                    ->attach('af-submit-app-upload-images', 'public/images/products/placeholder.png')
                    ->click('.submit-edit')
                    ->assertSee(__('manage-products/products.update_succes'));
        });
    }
}
