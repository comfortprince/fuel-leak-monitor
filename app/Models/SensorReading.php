<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'timestamp'
    ];

    public function sensor() {
        return $this->belongsTo(Sensor::class);
    }
}
