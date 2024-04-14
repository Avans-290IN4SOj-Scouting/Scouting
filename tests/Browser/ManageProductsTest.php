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

    public function test_responsiveness_screenshots()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin);
            $browser->responsiveScreenshots('products/test/manage-accounts');
        });
    }

    public function test_visit_product_overview_page_as_admin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(route('manage-products'))
                ->responsiveScreenshots('products/overview/overview-page');
        });
    }

    public function test_responsive_add_product_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(route('manage-addProduct'))
                ->responsiveScreenshots('products/manage-addProduct');
        });
    }





    /*  public function testImageUpload(): void
      {
          $this->browse(function (Browser $browser) {
              $browser->loginAs($this->admin)
                  ->visit('/product/create')
                  ->attach('af-submit-app-upload-images', storage_path('app/public/test_image.jpg'))
                  ->assertVisible('#file-image');
          });
      }

      public function testSelectOption(): void
      {
          $this->browse(function (Browser $browser) {
              $browser->loginAs($this->admin)
                  ->visit('/product/create')
                  ->select('category[]', 'Category') // Replace with actual select name and option
                  ->press('Product Toevoegen')
                  ->assertPathIs('/product/overview'); // Replace with actual path after submission
          });
      }

      public function testDynamicInputField()
      {
          $this->browse(function (Browser $browser) {
              $browser->loginAs($this->admin)
                  ->visit('/product/create')
                  ->press('Voeg maat toe')
                  ->assertVisible('#custom-size-inputs input[type="text"]');
          });
      }

      public function testCheckboxFunctionality()
      {
          $this->browse(function (Browser $browser) {
              $browser->visit('/product/create')
                  ->assertMissing('#size-price-inputs') // Assert size-price inputs are hidden by default
                  ->check('#same-price-all')
                  ->assertVisible('#size-price-inputs'); // Assert size-price inputs are shown after checking checkbox
          });
      }*/

    protected function tearDown(): void
    {
        $this->admin->delete();

        parent::tearDown();
    }
}
