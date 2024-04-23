<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderDetailsTest extends DuskTestCase
{
    public function test_responsiveness_screenshots(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/orderDetails')
                ->responsiveScreenshots('orderDetails/orderDetails');
        });
    }
}
