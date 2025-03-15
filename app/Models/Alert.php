<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'mq2_reading_id',
        'bmp180_reading_id',
        'custom_alert_id',
        'triggered_at',
        'status'
    ];

    public function customAlert() {
        return $this->belongsTo(CustomAlert::class);
    }

    public function mq2Reading() {
        return $this->belongsTo(SensorReading::class, 'mq2_reading_id');
    }

    public function bmp180Reading() {
        return $this->belongsTo(SensorReading::class, 'bmp180_reading_id');
    }
}
