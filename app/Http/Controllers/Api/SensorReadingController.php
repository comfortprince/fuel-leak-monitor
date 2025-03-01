<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Sensor;
use App\Models\SensorReading;
use App\Models\StorageTank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SensorReadingController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            "tank_identifier" => [
                Rule::in(StorageTank::all()->pluck('identifier')->toArray()),
                'required'
            ]
        ]);

        $tank = StorageTank::where('identifier', '=', $request->input("tank_identifier"))
                ->first();
        
        // Validate Readings
        $request->validate([
            "sensor_readings" => 'required|array',
            "sensor_readings.*.sensor_identifier" => [
                'required',
                Rule::in($tank->sensors->pluck('identifier')->toArray())
            ],
            "sensor_readings.*.value" => [
                'required',
                'numeric'
            ],
            "sensor_readings.*.timestamp" => [
                'required',
                'date'
            ]
        ]);

        $sensorReadings = $request->input('sensor_readings');
        $mq2Reading = null;
        $bmp180Reading = null;

        // Save Readings
        foreach ($sensorReadings as $sensorReading) {
            $sensor = Sensor::where('identifier', '=', $sensorReading['sensor_identifier'])
                    ->first();
            
            $reading = SensorReading::create([
                'sensor_id' => $sensor->id,
                'value' => $sensorReading['value'],
                'timestamp' => $sensorReading['timestamp']
            ]);

            if($sensor->sensor_type === "mq2"){
                $mq2Reading = $reading;
            }

            if($sensor->sensor_type === "bmp180"){
                $bmp180Reading = $reading;
            }
        }

        // send readings to client

        $alerts = [];
        $customAlerts = $tank->customAlerts;
        
        foreach ($customAlerts as $customAlert) {
            $alert = $this->checkAlert($customAlert, $mq2Reading, $bmp180Reading);
            
            if($alert){
                $alerts = [ ...$alerts, $alert ];
            }
        }

        // send alerts to client
        // send alerts via email 

        return "Successfull";
    }
    
    private function checkAlert($customAlert, $mq2SensorReading, $bmp180SensorReading) {
        $alert = null;
        
        if($this->isReadingWithinRange($mq2SensorReading->value, $customAlert->mq2_min, $customAlert->mq2_max)
            && $this->isReadingWithinRange($bmp180SensorReading->value, $customAlert->bmp180_min, $customAlert->bmp180_max))
        {
            $alert = Alert::create([
                'custom_alert_id' => $customAlert->id,
                'mq2_reading_id' => $mq2SensorReading->id,
                'bmp180_reading_id' => $bmp180SensorReading->id,
                'triggered_at' => $mq2SensorReading->timestamp,
                'status' => 'unresolved'
            ]);
        }

        return $alert;
    }

    private function isReadingWithinRange($value, $min, $max) {
        return $value > $min && $value < $max;
    }
}


