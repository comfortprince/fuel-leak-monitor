<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\SensorReading;
use App\Models\StorageTank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(SensorSeeder::class);
        $this->call(CustomAlertSeeder::class);

        $storageTanks = StorageTank::with(['sensors', 'customAlerts'])->get();

        foreach ($storageTanks as $tank) {
            $sensors = $tank->sensors;
            $timestamp = now()->subDays(10);
            
            for ($i=0; $i < 2000; $i++) { 
                // $timestamp = now()->addMinutes(10*$i);
                $timestamp = $timestamp->addMinutes(10);
                $mq2SensorReading = null;
                $bmp180SensorReading = null;
                foreach ($sensors as $sensor) {
                    if($sensor->sensor_type === 'mq2'){
                        $mq2SensorReading = SensorReading::create([
                            'sensor_id' => $sensor->id,
                            'value' => fake()->numberBetween(200, 10000),
                            'timestamp' => $timestamp
                        ]);
                    }
                    
                    if($sensor->sensor_type === 'bmp180'){
                        $bmp180SensorReading = SensorReading::create([
                            'sensor_id' => $sensor->id,
                            'value' => fake()->numberBetween(30000, 110000),
                            'timestamp' => $timestamp
                        ]);
                    }
                }

                $customAlerts = $tank->customAlerts;
                foreach ($customAlerts as $customAlert) {
                    $this->checkAlert($customAlert, $mq2SensorReading, $bmp180SensorReading);
                }
                
            }
        }
    }

    private function checkAlert($customAlert, $mq2SensorReading, $bmp180SensorReading) {
        if($this->isReadingWithinRange($mq2SensorReading->value, $customAlert->mq2_min, $customAlert->mq2_max)
            && $this->isReadingWithinRange($bmp180SensorReading->value, $customAlert->bmp180_min, $customAlert->bmp180_max)){
            Alert::create([
                'custom_alert_id' => $customAlert->id,
                'mq2_reading_id' => $mq2SensorReading->id,
                'bmp180_reading_id' => $bmp180SensorReading->id,
                'triggered_at' => $mq2SensorReading->timestamp,
                'status' => 'unresolved'
            ]);
        }
    }

    private function isReadingWithinRange($value, $min, $max) {
        return $value > $min && $value < $max;
    }
}
