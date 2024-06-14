<?php

namespace Tests\Browser;

use App\Enum\UserRoleEnum;
use App\Models\User;
use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

class ManageAccountFilterTest extends DuskTestCase
{
    private $admin;

    private function createUsers()
    {
        $this->admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ])->assignRole('admin');

        User::factory()->create([
            'email' => 'aaa',
            'password' => 'password',
        ])->assignRole('user');

        User::factory()->create([
            'email' => 'zzz',
            'password' => 'password',
        ])->assignRole('user');

        User::factory()->create([
            'email' => 'aab',
            'password' => 'password',
        ])->assignRole('admin');

        User::factory()->create([
            'email' => 'abzzza',
            'password' => 'password',
        ]);
    }

    /**
     * @group manage
     * @return void
     */
    public function test_sorting_by_email()
    {
        $this->createUsers();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
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
        $this->createUsers();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
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
        $this->createUsers();

        $roleToFilter = Role::where('name', 'admin')->first();
        $formattedRoleName = Str::title(str_replace('_', ' ', $roleToFilter->name));

        $this->browse(function (Browser $browser) use ($formattedRoleName) {
            $browser->loginAs($this->admin)
                ->visit(route('manage.accounts.index'))
                ->select('filter', $formattedRoleName)
                ->assertDontSee('aaa')
                ->assertSee('aab');
        });
    }
}
