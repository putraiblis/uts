<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController; 
use App\Http\Controllers\SettingController;
// HALAMAN UTAMA (LANDING)
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD (Setelah login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ===============================
// CRUD ADMIN (ADMIN SAJA)
// ===============================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('users', UserController::class);
    Route::resource('kelas', KelasController::class);
    
    // Route::get('recap', [RecapController::class, 'index'])->name('recap.index'); // <-- PINDAHKAN DARI SINI
    
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

// ===============================
// FITUR UNTUK SEMUA USER (ADMIN & USER BISA)
// ===============================
Route::middleware(['auth'])->group(function () {
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    // <-- PINDAHKAN KE SINI -->
    // Sekarang semua user yang login bisa mengakses rekap
    Route::get('recap', [RecapController::class, 'index'])->name('recap.index');
});

// AUTH ROUTES (BREEZE DEFAULT)
require __DIR__.'/auth.php';