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
            "name" => "Bevers",
            "image_url" => "/images/groups/bevers.png",
        ]);

        Group::create([
            "name" => "Gidsen",
            "image_url" => "/images/groups/gidsen.png",
        ]);

        Group::create([
            "name" => "Kabouters",
            "image_url" => "/images/groups/kabouters.png",
        ]);

        Group::create([
            "name" => "Scouts",
            "image_url" => "/images/groups/verkenners.png",
        ]);

        Group::create([
            "name" => "Waterwerk",
            "image_url" => "/images/groups/zee_verkenners.png",
        ]);

        Group::create([
            "name" => "Welpen",
            "image_url" => "/images/groups/welpen.png",
        ]);

        Group::create([
            "name" => "Leiders",
            "image_url" => "/images/groups/leiders.png",
        ]);
    }
}
