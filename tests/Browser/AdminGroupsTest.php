<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminGroupsTest extends DuskTestCase
{
    private $admin;

    private function createUsers()
    {
        $this->admin = User::factory()->create([
            'email' => 'admin',
            'password' => 'password',
        ])->assignRole('admin');
    }

    public function test_sort_alphabetical_order()
    {
        $this->createUsers();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(route('manage.groups.index'));

                // Get group names
                $elements = $browser->elements('@group_name');
                $groupNames = array_map(function ($element) {
                    return $element->getText();
                }, $elements);

                // Sort alphabetically
                $sortedTexts = $groupNames;
                sort($sortedTexts);

                $mismatch = false;
                for ($i = 0; $i < count($groupNames); $i++) {
                    if ($sortedTexts[$i] !== $groupNames[$i]) {
                        $mismatch = true;
                        break;
                    }
                }

                $this->assertFalse($mismatch);
        });
    }

    public function test_resizability() : void
    {
        $this->createUsers();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(route('manage.groups.index'))
                ->click('@group_name')
                ->pause(1000)
                ->responsiveScreenshots('groups/index');
        });
    }
}
