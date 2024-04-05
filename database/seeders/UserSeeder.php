<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUserWithRole("gebruiker@mail.com", "gebruiker", "gebruiker123", "user");
        $this->createUserWithRole("teamleider@mail.com", "teamleider", "teamleider123", "team_bevers");
        $this->createUserWithRole("admin@mail.com", "admin", "admin123", "admin");
    }

    private function createUserWithRole($email, $name, $password, $roleName)
    {
        $role = Role::where("name", $roleName)->first();

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                // 'name' => $name,
                'password' => bcrypt($password),
            ]
        );

        $user->assignRole($role);
    }
}
