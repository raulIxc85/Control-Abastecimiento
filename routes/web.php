<?php

use App\Http\Controllers\PilotController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ApplicantController;
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
    Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
    Route::get('/applicants/create', [ApplicantController::class, 'create'])->name('applicants.create');
    Route::get('/applicants/{applicant}/edit', [ApplicantController::class, 'edit'])->name('applicants.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
