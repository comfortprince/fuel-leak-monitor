<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_tank_id',
        'sensor_type',
        'identifier'
    ];

    public function user(): BelongsTo  {
        return $this->belongsTo(User::class);
    }

    public function storageTank(): BelongsTo  {
        return $this->belongsTo(StorageTank::class);
    }

    public function sensorReadings()  {
        return $this->hasMany(SensorReading::class);
    }
}
