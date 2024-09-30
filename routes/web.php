<?php

use App\Http\Controllers\PilotController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pilots', [PilotController::class, 'index'])->name('pilots.index');
    Route::get('/pilots/create', [PilotController::class, 'create'])->name('pilots.create');
    Route::get('/pilots/{pilot}/edit', [PilotController::class, 'edit'])->name('pilots.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
    Route::get('/agencies/create', [AgencyController::class, 'create'])->name('agencies.create');
    Route::get('/agencies/{agency}/edit', [AgencyController::class, 'edit'])->name('agencies.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');
    Route::get('/planning/create', [PlanningController::class, 'create'])->name('planning.create');
    Route::get('/planning/{application}/edit', [PlanningController::class, 'edit'])->name('planning.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{application}/edit', [OrderController::class, 'edit'])->name('orders.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
