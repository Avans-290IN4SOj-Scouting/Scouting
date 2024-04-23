<?php

namespace Tests\Feature;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)->post(route('profile.update'), [
            'old-password' => 'password',
            'new-password' => 'new-password',
            'repeat-password' => 'new-password',
        ]);

        $this->post(route('logoutpost'));

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'new-password',
        ]);

        $response->assertRedirectToRoute('home');
    }
}
