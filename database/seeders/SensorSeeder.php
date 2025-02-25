<?php

namespace Database\Seeders;

use App\Helpers\SystemHelper;
use App\Models\Sensor;
use App\Models\StorageTank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(StorageTankSeeder::class);
        $storageTanks = StorageTank::all();
        $sensorTypes = SystemHelper::getSensorTypes();        
        $sensorData = [];

        foreach ($storageTanks as $storageTank) {
            foreach ($sensorTypes as $sensorType) {
                $sensorData[] = [
                    'storage_tank_id' => $storageTank->id,
                    'sensor_type' => $sensorType,
                    'identifier' => fake()->uuid()
                ];
            }
        }

        Sensor::insert($sensorData);
    }
}
