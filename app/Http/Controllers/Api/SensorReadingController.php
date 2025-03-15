<?php

namespace App\Http\Controllers\Api;

use App\Events\FuelLeakAlertCount;
use App\Events\SensorReadingStored;
use App\Http\Controllers\Controller;
use App\Mail\FuelLeakAlert;
use App\Models\Alert;
use App\Models\Sensor;
use App\Models\SensorReading;
use App\Models\StorageTank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        $tank = $mq2Reading->sensor->storageTank->load(['sensors.sensorReadings']);

        SensorReadingStored::dispatch($tank);

        // send readings to client

        $alerts = [];
        $customAlerts = $tank->customAlerts;
        
        foreach ($customAlerts as $customAlert) {
            $alert = $this->checkAlert($customAlert, $mq2Reading, $bmp180Reading);
            
            if($alert){
                $alert->load(['bmp180Reading', 'mq2Reading']);
                $alerts = [ ...$alerts, $alert ];
            }
        }
        
        // send alerts via email and event broadcasting
        foreach ($alerts as $alert) {
            $email = $alert->customAlert->storageTank->user->email;
            Mail::to($email)->send(new FuelLeakAlert($alert));
            \App\Events\FuelLeakAlert::dispatch($alert);
        }

        if ($alerts) {
            $firstAlert = $alerts[0];
            $user = $firstAlert->customAlert->storageTank->user;

            $unresolvedAlertsCount = $user->storageTanks()
                ->with(['customAlerts.alerts' => function($query) {
                    $query->where('status', 'unresolved');
                }])
                ->get()
                ->pluck('customAlerts')
                ->flatten()
                ->pluck('alerts')    
                ->flatten()
                ->count();

            FuelLeakAlertCount::dispatch($unresolvedAlertsCount);
        }

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


