<?php

// ============================================================================
// CONTOH IMPLEMENTASI MIDDLEWARE PERMISSION & ROLE
// File: routes/web-with-permissions.php.example
// ============================================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\KeluargaController;
use App\Http\Controllers\MasterData\BalitaController;
use App\Http\Controllers\MasterData\IbuHamilController;
use App\Http\Controllers\MasterData\LansiaController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanBalitaController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanIbuHamilController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanLansiaController;
use App\Http\Controllers\Reports\LaporanController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// ============================================================================
// BASIC AUTHENTICATED ROUTES (Semua user yang login)
// ============================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ============================================================================
// ADMIN ONLY ROUTES (Hanya Admin - Full Power)
// ============================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User Management - Hanya Admin
    Route::resource('users', UserController::class);
    
    // Settings - Hanya Admin
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// ============================================================================
// MASTER DATA ROUTES (Admin & Kader)
// Permission: manage_keluarga, manage_balita, manage_ibu_hamil, manage_lansia
// ============================================================================
Route::middleware(['auth', 'permission:manage_keluarga'])->group(function () {
    Route::resource('keluarga', KeluargaController::class);
});

Route::middleware(['auth', 'permission:manage_balita'])->group(function () {
    Route::resource('balita', BalitaController::class);
});

Route::middleware(['auth', 'permission:manage_ibu_hamil'])->group(function () {
    Route::resource('ibu-hamil', IbuHamilController::class);
});

Route::middleware(['auth', 'permission:manage_lansia'])->group(function () {
    Route::resource('lansia', LansiaController::class);
});

// ============================================================================
// PEMERIKSAAN ROUTES (Admin, Kader, & Bidan)
// Permission: manage_pemeriksaan
// ============================================================================
Route::middleware(['auth', 'permission:manage_pemeriksaan'])->group(function () {
    Route::resource('pemeriksaan-balita', PemeriksaanBalitaController::class);
    Route::resource('pemeriksaan-ibu-hamil', PemeriksaanIbuHamilController::class);
    Route::resource('pemeriksaan-lansia', PemeriksaanLansiaController::class);
});

// ============================================================================
// LAPORAN ROUTES (Semua Role bisa lihat)
// Permission: view_reports
// ============================================================================
Route::middleware(['auth', 'permission:view_reports'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/balita', [LaporanController::class, 'balita'])->name('laporan.balita');
    Route::get('/laporan/ibu-hamil', [LaporanController::class, 'ibuHamil'])->name('laporan.ibu-hamil');
    Route::get('/laporan/lansia', [LaporanController::class, 'lansia'])->name('laporan.lansia');
});

// Export - Hanya Admin (permission: export_data)
Route::middleware(['auth', 'permission:export_data'])->group(function () {
    Route::get('/laporan/export-excel/{type}', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf/{type}', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});

// ============================================================================
// ALTERNATIVE: MENGGUNAKAN MULTIPLE MIDDLEWARE
// ============================================================================

// Contoh 1: Kombinasi Role dan Permission
Route::middleware(['auth', 'role:admin,kader', 'permission:manage_keluarga'])->group(function () {
    // Hanya admin atau kader dengan permission manage_keluarga
});

// Contoh 2: Multiple Roles
Route::middleware(['auth', 'role:admin,bidan'])->group(function () {
    // Hanya admin atau bidan
});

// Contoh 3: Multiple Permissions (salah satu saja)
Route::middleware(['auth', 'permission:manage_balita,manage_ibu_hamil'])->group(function () {
    // User dengan salah satu permission manage_balita atau manage_ibu_hamil
});

// ============================================================================
// CATATAN PENTING:
// 
// 1. Admin BYPASS semua permission check - Admin punya akses ke semua
// 2. Middleware 'role' cek berdasarkan nama role
// 3. Middleware 'permission' cek berdasarkan permission yang dimiliki role
// 4. Bisa combine multiple middleware sekaligus
// 5. Order middleware penting: auth -> role -> permission
// ============================================================================
