<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            "name" => "Kabouters",
            "min_age" => "4",
            "max_age" => "6",
        ]);

        Group::create([
            "name" => "Welpen",
            "min_age" => "7",
            "max_age" => "11",
        ]);

        Group::create([
            "name" => "Scouts",
            "min_age" => "12",
            "max_age" => "15",
        ]);
    }
}
