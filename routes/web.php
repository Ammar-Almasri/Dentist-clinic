<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('Home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Doctors
    Route::post('/doctors', [DoctorController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('doctors.store');
    Route::resource('doctors', DoctorController::class)->except(['store']);

    // Patients
    Route::post('/patients', [PatientController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('patients.store');
    Route::resource('patients', PatientController::class)->except(['store']);

    // Appointments
    Route::post('/appointments', [AppointmentController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('appointments.store');
    Route::resource('appointments', AppointmentController::class)->except(['store']);

    Route::resource('users', UserController::class);

});

Route::resource('services', ServiceController::class);
