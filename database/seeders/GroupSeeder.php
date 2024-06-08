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
            "size_id" => "1"
        ]);

        Group::create([
            "name" => "Gidsen",
            "image_url" => "/images/groups/gidsen.png",
            "size_id" => "2"
        ]);

        Group::create([
            "name" => "Kabouters",
            "image_url" => "/images/groups/kabouters.png",
            "size_id" => "3"
        ]);

        Group::create([
            "name" => "Scouts",
            "image_url" => "/images/groups/verkenners.png",
            "size_id" => "4"
        ]);

        Group::create([
            "name" => "Zeeverkenners",
            "image_url" => "/images/groups/zee_verkenners.png",
            "size_id" => "5"
        ]);

        Group::create([
            "name" => "Welpen",
            "image_url" => "/images/groups/welpen.png",
            "size_id" => "6"
        ]);
    }
}
