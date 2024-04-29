<?php

namespace Tests\Browser;

use App\Enum\DeliveryStatus;
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
                'email' => '_one@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now(),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'status' => DeliveryStatus::AwaitingPayment->value,
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
                'email' => '_two@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now()->addMonth(1),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'status' => DeliveryStatus::AwaitingPayment->value,
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
                'email' => '_three@example.net',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now()->addMonth(2),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'status' => DeliveryStatus::Cancelled->value,
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
                'email' => '_four@example.com',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now()->addMonth(3),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'status' => DeliveryStatus::Cancelled->value,
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
                'email' => '_five@example.com',
                'password' => 'password',
            ])->assignRole('user');

            $order = Order::create([
                'order_date' => Carbon::now()->addMonth(4),
                'lid_name' => 'test',
                'group_id' => 1,
                'user_id' => $user->id,
                'status' => DeliveryStatus::Finalized->value,
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

    public function test_email_filter()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    // Email
                    ->type('#search', '@example.net')
                    ->keys('input[name=q]', WebDriverKeys::ENTER)
                    ->waitFor('#link-email > :first-child')->click('#link-email > :first-child')

                    ->assertSee('_one@example.net')
                    ->assertSee('_two@example.net')
                    ->assertSee('_three@example.net')
                    ->assertDontSee('_four@example.com')
                    ->assertDontSee('_five@example.com');
        });
    }

    public function test_status_filter()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    ->select('#filter', DeliveryStatus::Finalized->value)
                    ->waitFor('#link-email > :first-child')->click('#link-email > :first-child')

                    ->assertDontSee('_one@example.net')
                    ->assertDontSee('_two@example.net')
                    ->assertDontSee('_three@example.net')
                    ->assertDontSee('_four@example.com')
                    ->assertSee('_five@example.com');
        });
    }

    public function test_from_date_filter()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $fromDate = Carbon::now()->subMonth(1);
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    ->keys('#date-from-filter', $fromDate->month)
                    ->keys('#date-from-filter', $fromDate->day)
                    ->keys('#date-from-filter', $fromDate->year)
                    ->waitFor('#link-email > :first-child')->click('#link-email > :first-child')

                    ->assertSee('_one@example.net')
                    ->assertDontSee('_two@example.net')
                    ->assertDontSee('_three@example.net')
                    ->assertDontSee('_four@example.com')
                    ->assertDontSee('_five@example.com');
        });
    }

    public function test_till_date_filter()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $tillDate = Carbon::now()->addMonth(1)->addDay(1);
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    ->keys('#date-till-filter', $tillDate->month)
                    ->keys('#date-till-filter', $tillDate->day)
                    ->keys('#date-till-filter', $tillDate->year)
                    ->waitFor('#link-email > :first-child')->click('#link-email > :first-child')

                    ->assertSee('_one@example.net')
                    ->assertSee('_two@example.net')
                    ->assertDontSee('_three@example.net')
                    ->assertDontSee('_four@example.com')
                    ->assertDontSee('_five@example.com');
        });
    }

    public function test_combined_filter()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $tillDate = Carbon::now()->addMonth(1)->addDay(1);
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    ->clickLink(__('manage-orders/orders.remove_filters_button'))
                    // Email
                    ->type('#search', '@example.net')

                    // Status
                    ->select('#filter', DeliveryStatus::AwaitingPayment->value)

                    // Date Till
                    ->keys('#date-till-filter', $tillDate->month)
                    ->keys('#date-till-filter', $tillDate->day)
                    ->keys('#date-till-filter', $tillDate->year)

                    // Ensure our subjects are first
                    ->waitFor('#link-email > :first-child')->click('#link-email > :first-child')

                    ->assertSee('_one@example.net')
                    ->assertSee('_two@example.net')
                    ->assertDontSee('_three@example.net')
                    ->assertDontSee('_four@example.com')
                    ->assertDontSee('_five@example.com');
        });
    }

    public function test_cancel_order()
    {
        $this->createOrders();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)->visit(route('manage.orders.index'))

                    ->type('#search', '_one@example.net')
                    ->keys('input[name=q]', WebDriverKeys::ENTER)
                    ->waitFor('#table-body')->click('#table-body > :first-child')

                    ->click('@cancel-order')

                    ->type('#search', '_one@example.net')
                    ->keys('input[name=q]', WebDriverKeys::ENTER)

                    ->assertSee(DeliveryStatus::localisedValue(DeliveryStatus::Cancelled->value));

        });
    }

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

