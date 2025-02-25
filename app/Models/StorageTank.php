<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageTank extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'fuel_type',
        'location'
    ];

    public function user(): BelongsTo  {
        return $this->belongsTo(User::class);
    }

    public function sensors() {
        return $this->hasMany(Sensor::class);
    }

    public function customAlerts() {
        return $this->hasMany(CustomAlert::class);
    }
}
