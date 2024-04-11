<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ManageAccountsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_can_update_roles(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $userToBeModified = User::factory()->create(['email' => 'user@test.com']);

        $rolesToCheck = ['admin', 'user', 'teamleader'];

        foreach ($rolesToCheck as $roleName) {
            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName]);
            }
        }

        $admin->assignRole('admin');
        $userToBeModified->assignRole('user');

        $userRolesData = [
            [
                'email' => $userToBeModified->email,
                'oldRoles' => $userToBeModified->roles()->first()->name,
                'newRoles' => ['admin'],
            ]
        ];

        $response = $this->actingAs($admin)
            ->post(route('manage.accounts.update.roles'), [
                'userRoles' => json_encode($userRolesData),
            ]);

        $response->assertStatus(302);

        $this->assertTrue($userToBeModified->fresh()->hasRole('admin'));
    }
}
