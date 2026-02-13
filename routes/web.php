<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\PemeriksaanBalitaController;
use App\Http\Controllers\PemeriksaanIbuHamilController;
use App\Http\Controllers\PemeriksaanLansiaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data Routes
    Route::resource('keluarga', KeluargaController::class);
    Route::resource('balita', BalitaController::class);
    Route::resource('ibu-hamil', IbuHamilController::class);
    Route::resource('lansia', LansiaController::class);
    
    // Pemeriksaan Routes
    Route::resource('pemeriksaan-balita', PemeriksaanBalitaController::class);
    Route::resource('pemeriksaan-ibu-hamil', PemeriksaanIbuHamilController::class);
    Route::resource('pemeriksaan-lansia', PemeriksaanLansiaController::class);
    
    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/balita', [LaporanController::class, 'balita'])->name('laporan.balita');
    Route::get('/laporan/ibu-hamil', [LaporanController::class, 'ibuHamil'])->name('laporan.ibu-hamil');
    Route::get('/laporan/lansia', [LaporanController::class, 'lansia'])->name('laporan.lansia');
    Route::get('/laporan/export-excel/{type}', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf/{type}', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});

// Admin Only Routes (Full Power)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Activity Logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    
    // System Information
    Route::get('/system-info', [AdminController::class, 'systemInfo'])->name('system-info');
});

// User Management (Admin Only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
});

