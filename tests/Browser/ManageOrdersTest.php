<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageOrdersTest extends DuskTestCase
{
    public function test_resizability() : void
    {
        $admin = User::factory()->create(['email' => 'res@ponsive'])->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)

                    ->visit(route('manage.orders.index'))
                    ->responsiveScreenshots('manage-orders/index')

                    ->visit(route('manage.orders.order', ['id' => 1]))
                    ->responsiveScreenshots('manage-orders/order');
        });
    }
}

