<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AccountsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_can_update_roles(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $userToBeModified = User::factory()->create(['email' => 'user@test.com']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'teamleader']);

        $admin->assignRole('admin');
        $userToBeModified->assignRole('user');

        $userRolesData = [
            [
                'email' => $userToBeModified->email,
                'oldRole' => $userToBeModified->roles()->first()->name,
                'newRole' => 'admin'
            ]
        ];

        $response = $this->actingAs($admin)
            ->post(route('manage-accounts.updateRoles'), [
                'userRoles' => json_encode($userRolesData),
            ]);

        $response->assertStatus(302);

        $this->assertTrue($userToBeModified->fresh()->hasRole('admin'));
    }
}
