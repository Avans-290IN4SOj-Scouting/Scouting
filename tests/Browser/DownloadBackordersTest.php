<?php

namespace Tests\Browser;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DownloadBackordersTest extends DuskTestCase
{
    public function test_download_backorders_with_backorders_toast()
    {
        $admin = User::factory()->create([
            'email' => 'admin@admin.admin',
            'password' => 'password',
        ])->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visitRoute('manage.backorders.download')
                ->assertDontSee(__('orders/backorders.no_backorders'));
        });
    }
}
