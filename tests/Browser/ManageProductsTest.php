<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Laravel\Prompts\pause;
use Illuminate\Support\Facades\Log;

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
                $this->assertTrue(false, __('manage-products/products.not_found'));
            }
        });
    }

    public function test_add_product_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->visit(route('manage.products.index'))
                ->click('.add-product-button')
                ->assertSee(__('manage-products/products.create_page_title'))
                ->type('name', 'Das')
                ->click('@addPriceSize')
                ->click('@addPriceSize')
                ->pause(500);

                // Either Dusk can't do this or I spent too much time on it
                $browser->script('
                    let i = 1;
                    document.querySelectorAll("#size_input").forEach((selectInput) => {
                        selectInput.value = i++;
                    });
                ');

                $priceValues = ['12.34', '23.45', '34.56'];
                $priceElements = $browser->elements('@price-input');
                foreach ($priceElements as $index => $element) {
                    $element->sendKeys($priceValues[$index]);
                }

                $browser->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))
                ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                ->click('@multiple-select-' . trans('manage-products/products.category-multiselect') . ' + *')
                ->click(__('[data-value="blauw"]'))
                ->click(__('[data-value="geel"]'))
                ->attach('af-submit-app-upload-images', 'public/images/products/placeholder.png');
                $browser->script('document.querySelector("#add-product-button").click();');
                $browser->assertSee(__('toast/messages.success-product-add'));
        });
    }

    public function test_edit_product_flow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->visit(route('manage.products.index'))
                ->click('@edit-product-button')
                ->assertSee(__('manage-products/products.edit_page_title'))

                ->click('@removePriceSize')

                ->click('@multiple-select-' . trans('manage-products/products.groups-multiselect') . ' + *')
                ->click(__('[data-value="Bevers"]'))
                ->click(__('[data-value="Kabouters"]'))
                ->click('@multiple-select-' . trans('manage-products/products.category-multiselect') . ' + *')
                ->click(__('[data-value="groen"]'))
                ->attach('af-submit-app-upload-images', 'public/images/products/placeholder.png')
                ->screenshot('test_jeroen')
                ;
                $browser->script('document.querySelector("#update-product-button").click();');
                $browser->screenshot('test_jeroen2');
                $browser->assertSee(__('toast/messages.success-product-update'));
        });
    }
}
