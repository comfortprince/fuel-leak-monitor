<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AlertController;
use App\Http\Controllers\Web\CustomAlertController;
use App\Http\Controllers\Web\SensorController;
use App\Http\Controllers\Web\StorageTankController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login', 301);;

Route::redirect('/dashboard', '/storage-tanks')
    ->middleware(['auth', 'verified'])    
    ->name('dashboard');

Route::middleware('auth')
->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('storage-tanks', StorageTankController::class)
    ->middleware(['auth', 'verified']);

Route::get('storage-tanks/{storageTank}/analytics', [StorageTankController::class, 'analytics'])
    ->name('storage-tanks.analytics')
    ->middleware(['auth', 'verified']);


Route::resource('sensors', SensorController::class)
    ->only(['store', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('sensors/create/{storageTank}', [SensorController::class, 'create'])
    ->name('sensors.create')
    ->middleware(['auth', 'verified']);

Route::resource('custom-alerts', CustomAlertController::class)
    ->only(['store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('custom-alerts/create/{storageTank}', [CustomAlertController::class, 'create'])
    ->name('custom-alerts.create')
    ->middleware(['auth', 'verified']);

Route::resource('alerts', AlertController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

Route::put('alerts/{alert}', [AlertController::class, 'resolve'])
    ->name('alerts.resolve')
    ->middleware(['auth', 'verified']);

Route::get('debug', function () {
    return view('emails.fuel-leak-alert');
});

require __DIR__.'/auth.php';
