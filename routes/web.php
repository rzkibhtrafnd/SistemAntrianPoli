<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\UserController;

// Auth routes (manual implementation)
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $patientsCount = \App\Models\Patient::count();
        $doctorsCount = \App\Models\Doctor::count();

        return view('admin.dashboard', compact('patientsCount', 'doctorsCount'));
    })->name('admin.dashboard');
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/print-card', [PatientController::class, 'printCard'])->name('patients.print-card');
    Route::resource('doctors', DoctorController::class);
    Route::resource('polis', PoliController::class);
    Route::resource('users', UserController::class);
});

// Staff Poli routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/poli-queue', [QueueController::class, 'getByPoli'])->name('queues.by-poli');
    Route::post('/queue/call-next', [QueueController::class, 'callNext'])->name('queues.call-next');
    Route::post('/queue/{id}/complete', [QueueController::class, 'complete'])->name('queues.complete');
});

// Public routes
Route::get('/', [QueueController::class, 'create'])->name('queues.create');
Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');
Route::get('/queues/{id}/print', [QueueController::class, 'printTicket'])->name('queues.print');

// Public dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
