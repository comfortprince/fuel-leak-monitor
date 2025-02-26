<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AlertController;
use App\Http\Controllers\Web\CustomAlertController;
use App\Http\Controllers\Web\SensorController;
use App\Http\Controllers\Web\StorageTankController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    ->only(['create', 'store'])
    ->middleware(['auth', 'verified']);

Route::resource('custom-alerts', CustomAlertController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('alerts', AlertController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

Route::put('alerts/{alert}', [AlertController::class, 'resolve'])
    ->name('alerts.resolve')
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
