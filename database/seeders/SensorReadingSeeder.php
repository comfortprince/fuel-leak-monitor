<?php

namespace Database\Seeders;

use App\Models\Sensor;
use App\Models\SensorReading;
use App\Models\StorageTank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorReadingSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(SensorSeeder::class);

        $storageTanks = StorageTank::with('sensors')->get();

        $sensorReadings = [];
        foreach ($storageTanks as $tank) {
            $sensors = $tank->sensors;
            
            for ($i=0; $i < 50; $i++) { 
                $timestamp = now()->addMinutes(10*$i);
                foreach ($sensors as $sensor) {
                    if($sensor->sensor_type === 'mq2'){
                        $sensorReadings[] = [
                            'sensor_id' => $sensor->id,
                            'value' => rand(200, 10000),
                            'timestamp' => $timestamp
                        ];
                    }
                    
                    if($sensor->sensor_type === 'bmp180'){
                        $sensorReadings[] = [
                            'sensor_id' => $sensor->id,
                            'value' => rand(30000, 110000),
                            'timestamp' => $timestamp
                        ];
                    }
                }
            }
        }

        SensorReading::insert($sensorReadings);
    }
}
