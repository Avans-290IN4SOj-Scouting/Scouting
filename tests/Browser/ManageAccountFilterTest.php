<?php

namespace Tests\Browser;

use App\Enum\UserRoleEnum;
use App\Models\User;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageAccountFilterTest extends DuskTestCase
{
    /**
     * @group manage
     * @return void
     */
    public function test_sorting_by_email()
    {
        $admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ]);

        $first_user = User::factory()->create([
            'email' => 'aaa',
            'password' => 'password',
        ]);

        $last_user = User::factory()->create([
            'email' => 'zzz',
            'password' => 'password',
        ]);

        $first_user->assignRole('user');
        $last_user->assignRole('user');

        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->clickLink(__('manage-accounts/accounts.email'))
                ->assertSee('aaa')
                ->clickLink(__('manage-accounts/accounts.email'))
                ->assertSee('zzz');
        });
    }

    /**
     * @group manage
     * @return void
     */
    public function test_searching_by_email()
    {
        $admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ]);

        $first_user = User::factory()->create([
            'email' => 'aaa',
            'password' => 'password',
        ]);

        $last_user = User::factory()->create([
            'email' => 'zzz',
            'password' => 'password',
        ]);

        $user = User::factory()->create([
            'email' => 'abzzza',
            'password' => 'password',
        ]);

        $first_user->assignRole('user');
        $last_user->assignRole('user');

        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->type('q', 'zzz')
                ->keys('input[name=q]', WebDriverKeys::ENTER)
                ->assertSee('zzz')
                ->assertSee('abzzza')
                ->assertDontSee('aaa');
        });
    }

    /**
     * @group manage
     * @return void
     */
    public function test_filtering_by_role()
    {
        $admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ]);

        $first_user = User::factory()->create([
            'email' => 'aaa',
            'password' => 'password',
        ]);

        $last_user = User::factory()->create([
            'email' => 'aab',
            'password' => 'password',
        ]);

        $first_user->assignRole('user');
        $last_user->assignRole('admin');

        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('manage.accounts.index'))
                ->select('filter', UserRoleEnum::localisedValue(UserRoleEnum::Admin->value))
                ->assertDontSee('aaa')
                ->assertSee('aab');
        });
    }
}
