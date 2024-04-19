<?php

namespace Tests\Browser;

use App\Enum\UserRoleEnum;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use Carbon\Carbon;
use Facebook\WebDriver\WebDriverKeys;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageOrdersTest extends DuskTestCase
{
    private $admin;

    private function createOrders()
    {
        $this->admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ])->assignRole('admin');

        {
            $user = User::factory()->create([
                'email' => 'one@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'order_status_id' => 1,
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 1,
                'amount' => 1,
                'product_price' => 12.34,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 2,
                'amount' => 2,
                'product_price' => 22.33,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
        }

        {
            $user = User::factory()->create([
                'email' => 'two@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'order_status_id' => 1,
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 1,
                'amount' => 1,
                'product_price' => 12.34,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 2,
                'amount' => 2,
                'product_price' => 22.33,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
        }

        {
            $user = User::factory()->create([
                'email' => 'three@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'order_status_id' => 2,
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 1,
                'amount' => 1,
                'product_price' => 12.34,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 2,
                'amount' => 2,
                'product_price' => 22.33,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
        }

        {
            $user = User::factory()->create([
                'email' => 'four@example.com',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'order_status_id' => 2,
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 1,
                'amount' => 1,
                'product_price' => 12.34,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 2,
                'amount' => 2,
                'product_price' => 22.33,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
        }

        {
            $user = User::factory()->create([
                'email' => 'five@example.com',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'order_status_id' => 3,
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 1,
                'amount' => 1,
                'product_price' => 12.34,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => 2,
                'amount' => 2,
                'product_price' => 22.33,
                'product_size' => 'S',
                'product_image_path' => 'image/products/placeholder.png'
            ]);
        }
    }

    public function test_filters()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $fromDate = Carbon::now()->subMonth(1);
            $tillDate = Carbon::now()->addMonth(1);
            $browser->loginAs($this->admin)

                    ->visit(route('manage.orders.index'))
                    ->responsiveScreenshots('manage-orders/index')

                    // Email
                    ->type('#search', '@example.net')
                    ->keys('input[name=q]', WebDriverKeys::ENTER)

                    ->assertSee('one@example.net')
                    ->assertSee('two@example.net')
                    ->assertSee('three@example.net')
                    ->assertDontSee('four@example.com')
                    ->assertDontSee('five@example.com')

                    // Status
                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    ->select('#filter', '3')

                    ->assertDontSee('one@example.net')
                    ->assertDontSee('two@example.net')
                    ->assertDontSee('three@example.net')
                    ->assertDontSee('four@example.com')
                    ->assertSee('five@example.com')

                    // From
                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    ->keys('#date-from-filter', $fromDate->month)
                    ->keys('#date-from-filter', $fromDate->day)
                    ->keys('#date-from-filter', $fromDate->year)

                    ->assertSee('one@example.net')
                    ->assertSee('two@example.net')
                    ->assertSee('three@example.net')
                    ->assertSee('four@example.com')
                    ->assertSee('five@example.com')
                    ->screenshot('test_jeroen')

                    // Till
                    ->clickLink(__('manage-orders/orders.remove_filters_button'))

                    // From & Till
                    ->clickLink(__('manage-orders/orders.remove_filters_button'))

                    ;
        });
    }

    // public function test_resizability() : void
    // {
    //     $admin = User::factory()->create(['email' => 'res@ponsive'])->assignRole('admin');

    //     $this->browse(function (Browser $browser) use ($admin) {
    //         $browser->loginAs($admin)

    //                 ->visit(route('manage.orders.index'))
    //                 ->responsiveScreenshots('manage-orders/index')

    //                 ->visit(route('manage.orders.order', ['id' => 1]))
    //                 ->responsiveScreenshots('manage-orders/order');
    //     });
    // }
}

