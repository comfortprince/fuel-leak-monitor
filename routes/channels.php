<?php

use App\Models\Alert;
use App\Models\SensorReading;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('fuelLeakAlerts', function (User $user) {
    return true;
});

Broadcast::channel('newSensorReadingStored', function (User $user) {
    return true;
});

Broadcast::channel('unresolvedFuelAlertCount', function (User $user) {
    return true;
});