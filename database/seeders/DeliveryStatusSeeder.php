<?php

namespace Database\Seeders;

use App\Models\DeliveryState;
use App\Models\DeliveryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryStatus::create([
            "status"=> "Pending"
        ]);
        DeliveryStatus::create([
            "status"=> "Completed"
        ]);
        DeliveryStatus::create([
            "status"=> "Canceled"
        ]);
    }
}
