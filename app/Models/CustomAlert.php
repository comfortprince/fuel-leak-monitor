<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_tank_id',
        'mq2_min',
        'mq2_max',
        'bmp180_min',
        'bmp180_max',
        'level',
        'description',
        'action_required',
    ];

    public function storageTank() {
        return $this->belongsTo(StorageTank::class);
    }
}
