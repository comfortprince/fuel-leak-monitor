<?php

use App\Http\Controllers\Api\SensorReadingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('sensor-readings', [SensorReadingController::class, 'store']);
