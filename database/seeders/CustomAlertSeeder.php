<?php

namespace Database\Seeders;

use App\Models\CustomAlert;
use App\Models\StorageTank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomAlertSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storageTanks = StorageTank::all();

        foreach ($storageTanks as $tank) {
            // Warning alert
            CustomAlert::create([
                'storage_tank_id' => $tank->id,
                'mq2_min' => 1000,
                'mq2_max' => 5000,
                'bmp180_min' => 90000,
                'bmp180_max' => 103000,
                'level' => 'warning',
                'description' => 'Potential leak detected. Elevated gas concentration.',
                'action_required' => 'Inspect the storage tank for leaks.',
            ]);

            // Danger alert
            CustomAlert::create([
                'storage_tank_id' => $tank->id,
                'mq2_min' => 5000,
                'mq2_max' => 10000,
                'bmp180_min' => 50000,
                'bmp180_max' => 90000,
                'level' => 'danger',
                'description' => 'High risk of explosion detected.',
                'action_required' => 'Evacuate area and shut down fuel sources immediately.',
            ]);
        }
    }
}
