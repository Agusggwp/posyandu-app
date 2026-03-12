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
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (without register)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Password Reset Routes (optional)
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data Routes - Kader dan Admin dapat menginput
    Route::middleware(['permission:manage_keluarga'])->group(function () {
        Route::resource('keluarga', KeluargaController::class)->except(['destroy']);
    });
    
    Route::middleware(['permission:manage_balita'])->group(function () {
        Route::resource('balita', BalitaController::class)->except(['destroy']);
    });
    
    Route::middleware(['permission:manage_ibu_hamil'])->group(function () {
        Route::resource('ibu-hamil', IbuHamilController::class)->except(['destroy']);
    });
    
    Route::middleware(['permission:manage_lansia'])->group(function () {
        Route::resource('lansia', LansiaController::class)->except(['destroy']);
    });
    
    // Delete routes - Hanya Admin
    Route::middleware(['permission:delete_data'])->group(function () {
        Route::delete('keluarga/{keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');
        Route::delete('balita/{balita}', [BalitaController::class, 'destroy'])->name('balita.destroy');
        Route::delete('ibu-hamil/{ibu_hamil}', [IbuHamilController::class, 'destroy'])->name('ibu-hamil.destroy');
        Route::delete('lansia/{lansia}', [LansiaController::class, 'destroy'])->name('lansia.destroy');
        Route::delete('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'destroy'])->name('pemeriksaan-balita.destroy');
        Route::delete('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'destroy'])->name('pemeriksaan-ibu-hamil.destroy');
        Route::delete('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'destroy'])->name('pemeriksaan-lansia.destroy');
    });
    
    // Pemeriksaan Routes - Bidan dan Admin dapat menginput
    Route::middleware(['permission:manage_pemeriksaan'])->group(function () {
        Route::get('pemeriksaan-balita/create', [PemeriksaanBalitaController::class, 'create'])->name('pemeriksaan-balita.create');
        Route::post('pemeriksaan-balita', [PemeriksaanBalitaController::class, 'store'])->name('pemeriksaan-balita.store');
        Route::get('pemeriksaan-ibu-hamil/create', [PemeriksaanIbuHamilController::class, 'create'])->name('pemeriksaan-ibu-hamil.create');
        Route::post('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'store'])->name('pemeriksaan-ibu-hamil.store');
        Route::get('pemeriksaan-lansia/create', [PemeriksaanLansiaController::class, 'create'])->name('pemeriksaan-lansia.create');
        Route::post('pemeriksaan-lansia', [PemeriksaanLansiaController::class, 'store'])->name('pemeriksaan-lansia.store');
    });
    
    // Edit Pemeriksaan - Bidan dan Admin
    Route::middleware(['permission:edit_pemeriksaan'])->group(function () {
        Route::get('pemeriksaan-balita/{pemeriksaan_balita}/edit', [PemeriksaanBalitaController::class, 'edit'])->name('pemeriksaan-balita.edit');
        Route::put('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'update'])->name('pemeriksaan-balita.update');
        Route::get('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}/edit', [PemeriksaanIbuHamilController::class, 'edit'])->name('pemeriksaan-ibu-hamil.edit');
        Route::put('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'update'])->name('pemeriksaan-ibu-hamil.update');
        Route::get('pemeriksaan-lansia/{pemeriksaan_lansia}/edit', [PemeriksaanLansiaController::class, 'edit'])->name('pemeriksaan-lansia.edit');
        Route::put('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'update'])->name('pemeriksaan-lansia.update');
    });
    
    // View Pemeriksaan - Semua role bisa lihat
    Route::middleware(['permission:view_data'])->group(function () {
        Route::get('pemeriksaan-balita', [PemeriksaanBalitaController::class, 'index'])->name('pemeriksaan-balita.index');
        Route::get('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'show'])->name('pemeriksaan-balita.show');
        Route::get('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'index'])->name('pemeriksaan-ibu-hamil.index');
        Route::get('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'show'])->name('pemeriksaan-ibu-hamil.show');
        Route::get('pemeriksaan-lansia', [PemeriksaanLansiaController::class, 'index'])->name('pemeriksaan-lansia.index');
        Route::get('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'show'])->name('pemeriksaan-lansia.show');
    });
    
    // Laporan Routes - Semua role bisa lihat
    Route::middleware(['permission:view_reports'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/balita', [LaporanController::class, 'balita'])->name('laporan.balita');
        Route::get('/laporan/ibu-hamil', [LaporanController::class, 'ibuHamil'])->name('laporan.ibu-hamil');
        Route::get('/laporan/lansia', [LaporanController::class, 'lansia'])->name('laporan.lansia');
    });
    
    // Export - Hanya Admin
    Route::middleware(['permission:export_data'])->group(function () {
        Route::get('/laporan/export-excel/{type}', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
        Route::get('/laporan/export-pdf/{type}', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    });
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

