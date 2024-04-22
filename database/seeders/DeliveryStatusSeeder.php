<?php

namespace Database\Seeders;
use App\Models\DeliveryStatus;
use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{

    public function run()
    {
        DeliveryStatus::create([
            "status" => \App\Enum\DeliveryStatus::Pending
        ]);
        DeliveryStatus::create([
            "status" => \App\Enum\DeliveryStatus::Completed
        ]);
        DeliveryStatus::create([
            "status" => \App\Enum\DeliveryStatus::Cancelled
        ]);
    }
}

