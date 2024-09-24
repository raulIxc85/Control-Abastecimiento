<?php

use App\Http\Controllers\PilotController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pilots', [PilotController::class, 'index'])->name('pilots.index');
    Route::get('/pilots/create', [PilotController::class, 'create'])->name('pilots.create');
    Route::get('/pilots/{pilot}/edit', [PilotController::class, 'edit'])->name('pilots.edit');
});

Route::get('/agencies', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('agencies');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
