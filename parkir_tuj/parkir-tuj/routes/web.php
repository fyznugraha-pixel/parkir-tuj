<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\AksesParkirController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PortalController; 


// ===== PUBLIC ROUTES (Tanpa Login) =====

// Landing Page (Homepage untuk publik)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// ===== PROTECTED ROUTES (Harus Login sebagai Admin) =====
Route::middleware(['auth.admin'])->group(function () {
    // Scan Barcode
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan/process', [ScanController::class, 'process'])->name('scan.process');
    Route::post('/scan/process-with-vehicle', [ScanController::class, 'processWithVehicle'])->name('scan.process-with-vehicle');
    Route::post('/scan/process-with-vehicle', [ScanController::class, 'processWithVehicle'])
    ->name('scan.process-with-vehicle');
    
    // Logout (harus login dulu baru bisa logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard (halaman setelah login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Home Page (untuk admin yang sudah login)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Manajemen Pengguna (CRUD)
    Route::resource('pengguna', PenggunaController::class);
    
    // Manajemen Kendaraan (CRUD)
    Route::resource('kendaraan', KendaraanController::class);
    
    // Akses Parkir (Transaksi Masuk/Keluar)
    Route::prefix('akses-parkir')->name('akses-parkir.')->group(function () {
        Route::get('/', [AksesParkirController::class, 'index'])->name('index');
        Route::post('/masuk', [AksesParkirController::class, 'masuk'])->name('masuk');
        Route::post('/keluar/{id}', [AksesParkirController::class, 'keluar'])->name('keluar');
    });

    Route::prefix('portal')->group(function () {
        Route::get('/login', [PortalController::class, 'showLogin'])->name('portal.login');
        Route::post('/login', [PortalController::class, 'login'])->name('portal.login.post');

        Route::middleware('auth.portal')->group(function () {
            Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('portal.dashboard');
            Route::post('/logout', [PortalController::class, 'logout'])->name('portal.logout');
        });
    });

        
        // Log Aktivitas
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
        Route::get('/log-aktivitas/export', [LogAktivitasController::class, 'export'])->name('log.export');
    });

// ===== FALLBACK ROUTE =====
Route::fallback(function () {
    return redirect()->route('welcome');
});