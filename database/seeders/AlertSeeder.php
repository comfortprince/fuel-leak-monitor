<?php

namespace Database\Seeders;

use App\Models\CustomAlert;
use App\Models\StorageTank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storageTanks = StorageTank::with('sensors.sensorReadings')->get();

        foreach ($storageTanks as $tank) {
            $groupedReadings = collect();

            // Group readings by timestamp
            foreach ($tank->sensors as $sensor) {
                foreach ($sensor->sensorReadings as $reading) {
                    $groupedReadings[$reading->recorded_at][] = $reading;
                }
            }

            // Now $groupedReadings is a collection grouped by timestamp
            foreach ($groupedReadings as $timestamp => $readings) {
                foreach ($readings as $reading) {
                    echo "Sensor ID: {$reading->sensor_id}, Value: {$reading->value}\n";
                }
            }
        }
    }
}
