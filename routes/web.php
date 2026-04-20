<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\KeluargaController;
use App\Http\Controllers\MasterData\BalitaController;
use App\Http\Controllers\MasterData\IbuHamilController;
use App\Http\Controllers\MasterData\LansiaController;
use App\Http\Controllers\MasterData\NifasController;
use App\Http\Controllers\MasterData\RemajaController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanBalitaController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanIbuHamilController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanLansiaController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanNifasController;
use App\Http\Controllers\Pemeriksaan\PemeriksaanRemajaController;
use App\Http\Controllers\Reports\LaporanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\KepalaKeluargaAuthController;

Route::get('/', function () {
    if (Auth::guard('kepala_keluarga')->check()) {
        return redirect()->route('kepala-keluarga.dashboard');
    }

    if (Auth::guard('web')->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::prefix('kepala-keluarga')->name('kepala-keluarga.')->group(function () {
    Route::middleware('guest:kepala_keluarga')->group(function () {
        Route::get('login', [KepalaKeluargaAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [KepalaKeluargaAuthController::class, 'login'])->name('login.post');
        Route::get('register', [KepalaKeluargaAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [KepalaKeluargaAuthController::class, 'register'])->name('register.post');
        Route::get('password/reset', [App\Http\Controllers\KepalaKeluargaForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [App\Http\Controllers\KepalaKeluargaForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [App\Http\Controllers\KepalaKeluargaResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [App\Http\Controllers\KepalaKeluargaResetPasswordController::class, 'reset'])->name('password.update');
        Route::get('activate/{id}/{hash}', [KepalaKeluargaAuthController::class, 'activate'])
            ->middleware('signed')
            ->name('activate');
    });

    Route::middleware('auth:kepala_keluarga')->group(function () {
        Route::get('dashboard', [KepalaKeluargaAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('anggota/{tipe}/{id}', [KepalaKeluargaAuthController::class, 'showMemberDetail'])->name('anggota.show');
        Route::get('anggota/{tipe}/{id}/pemeriksaan', [KepalaKeluargaAuthController::class, 'showMemberPemeriksaanStats'])->name('anggota.pemeriksaan');
        Route::get('anggota/{tipe}/{id}/pemeriksaan/export/{format}', [KepalaKeluargaAuthController::class, 'exportMemberPemeriksaan'])->name('anggota.pemeriksaan.export');
        Route::post('logout', [KepalaKeluargaAuthController::class, 'logout'])->name('logout');
    });
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
        Route::resource('balita', BalitaController::class)
            ->parameters(['balita' => 'balita'])
            ->except(['destroy']);
    });
    
    Route::middleware(['permission:manage_ibu_hamil'])->group(function () {
        Route::resource('ibu-hamil', IbuHamilController::class)->except(['destroy']);
        Route::resource('nifas', NifasController::class)
            ->parameters(['nifas' => 'nifas'])
            ->except(['destroy']);
    });
    
    Route::middleware(['permission:manage_lansia'])->group(function () {
        Route::resource('lansia', LansiaController::class)
            ->parameters(['lansia' => 'lansia'])
            ->except(['destroy']);
        Route::resource('remaja', RemajaController::class)->except(['destroy']);
    });
    
    // Delete routes - Hanya Admin
    Route::middleware(['permission:delete_data'])->group(function () {
        Route::delete('keluarga/{keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');
        Route::delete('balita/{balita}', [BalitaController::class, 'destroy'])->name('balita.destroy');
        Route::delete('ibu-hamil/{ibu_hamil}', [IbuHamilController::class, 'destroy'])->name('ibu-hamil.destroy');
        Route::delete('lansia/{lansia}', [LansiaController::class, 'destroy'])->name('lansia.destroy');
        Route::delete('nifas/{nifas}', [NifasController::class, 'destroy'])->name('nifas.destroy');
        Route::delete('remaja/{remaja}', [RemajaController::class, 'destroy'])->name('remaja.destroy');
        Route::delete('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'destroy'])->name('pemeriksaan-balita.destroy');
        Route::delete('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'destroy'])->name('pemeriksaan-ibu-hamil.destroy');
        Route::delete('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'destroy'])->name('pemeriksaan-lansia.destroy');
        Route::delete('pemeriksaan-nifas/{pemeriksaan_nifas}', [PemeriksaanNifasController::class, 'destroy'])->name('pemeriksaan-nifas.destroy');
        Route::delete('pemeriksaan-remaja/{pemeriksaan_remaja}', [PemeriksaanRemajaController::class, 'destroy'])->name('pemeriksaan-remaja.destroy');
    });
    
    // Pemeriksaan Routes - Bidan dan Admin dapat menginput
    Route::middleware(['permission:manage_pemeriksaan'])->group(function () {
        Route::get('pemeriksaan-balita/create', [PemeriksaanBalitaController::class, 'create'])->name('pemeriksaan-balita.create');
        Route::post('pemeriksaan-balita', [PemeriksaanBalitaController::class, 'store'])->name('pemeriksaan-balita.store');
        Route::get('pemeriksaan-ibu-hamil/create', [PemeriksaanIbuHamilController::class, 'create'])->name('pemeriksaan-ibu-hamil.create');
        Route::post('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'store'])->name('pemeriksaan-ibu-hamil.store');
        Route::get('pemeriksaan-lansia/create', [PemeriksaanLansiaController::class, 'create'])->name('pemeriksaan-lansia.create');
        Route::post('pemeriksaan-lansia', [PemeriksaanLansiaController::class, 'store'])->name('pemeriksaan-lansia.store');
        Route::get('pemeriksaan-nifas/create', [PemeriksaanNifasController::class, 'create'])->name('pemeriksaan-nifas.create');
        Route::post('pemeriksaan-nifas', [PemeriksaanNifasController::class, 'store'])->name('pemeriksaan-nifas.store');
        Route::get('pemeriksaan-remaja/create', [PemeriksaanRemajaController::class, 'create'])->name('pemeriksaan-remaja.create');
        Route::post('pemeriksaan-remaja', [PemeriksaanRemajaController::class, 'store'])->name('pemeriksaan-remaja.store');
    });
    
    // Edit Pemeriksaan - Bidan dan Admin
    Route::middleware(['permission:edit_pemeriksaan'])->group(function () {
        Route::get('pemeriksaan-balita/{pemeriksaan_balita}/edit', [PemeriksaanBalitaController::class, 'edit'])->name('pemeriksaan-balita.edit');
        Route::put('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'update'])->name('pemeriksaan-balita.update');
        Route::get('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}/edit', [PemeriksaanIbuHamilController::class, 'edit'])->name('pemeriksaan-ibu-hamil.edit');
        Route::put('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'update'])->name('pemeriksaan-ibu-hamil.update');
        Route::get('pemeriksaan-lansia/{pemeriksaan_lansia}/edit', [PemeriksaanLansiaController::class, 'edit'])->name('pemeriksaan-lansia.edit');
        Route::put('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'update'])->name('pemeriksaan-lansia.update');
        Route::get('pemeriksaan-nifas/{pemeriksaan_nifas}/edit', [PemeriksaanNifasController::class, 'edit'])->name('pemeriksaan-nifas.edit');
        Route::put('pemeriksaan-nifas/{pemeriksaan_nifas}', [PemeriksaanNifasController::class, 'update'])->name('pemeriksaan-nifas.update');
        Route::get('pemeriksaan-remaja/{pemeriksaan_remaja}/edit', [PemeriksaanRemajaController::class, 'edit'])->name('pemeriksaan-remaja.edit');
        Route::put('pemeriksaan-remaja/{pemeriksaan_remaja}', [PemeriksaanRemajaController::class, 'update'])->name('pemeriksaan-remaja.update');
    });
    
    // View Pemeriksaan - Semua role bisa lihat
    Route::middleware(['permission:view_data'])->group(function () {
        Route::get('pemeriksaan-balita', [PemeriksaanBalitaController::class, 'index'])->name('pemeriksaan-balita.index');
        Route::get('pemeriksaan-balita/{pemeriksaan_balita}', [PemeriksaanBalitaController::class, 'show'])->name('pemeriksaan-balita.show');
        Route::get('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'index'])->name('pemeriksaan-ibu-hamil.index');
        Route::get('pemeriksaan-ibu-hamil/{pemeriksaan_ibu_hamil}', [PemeriksaanIbuHamilController::class, 'show'])->name('pemeriksaan-ibu-hamil.show');
        Route::get('pemeriksaan-lansia', [PemeriksaanLansiaController::class, 'index'])->name('pemeriksaan-lansia.index');
        Route::get('pemeriksaan-lansia/{pemeriksaan_lansia}', [PemeriksaanLansiaController::class, 'show'])->name('pemeriksaan-lansia.show');
        Route::get('pemeriksaan-nifas', [PemeriksaanNifasController::class, 'index'])->name('pemeriksaan-nifas.index');
        Route::get('pemeriksaan-nifas/{pemeriksaan_nifas}', [PemeriksaanNifasController::class, 'show'])->name('pemeriksaan-nifas.show');
        Route::get('pemeriksaan-remaja', [PemeriksaanRemajaController::class, 'index'])->name('pemeriksaan-remaja.index');
        Route::get('pemeriksaan-remaja/{pemeriksaan_remaja}', [PemeriksaanRemajaController::class, 'show'])->name('pemeriksaan-remaja.show');
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

    // Search API Routes - Real-time search (semua role yang login)
    Route::get('/api/search/balita', [BalitaController::class, 'search'])->name('api.search.balita');
    Route::get('/api/search/ibu-hamil', [IbuHamilController::class, 'search'])->name('api.search.ibu-hamil');
    Route::get('/api/search/lansia', [LansiaController::class, 'search'])->name('api.search.lansia');
    Route::get('/api/search/nifas', [NifasController::class, 'search'])->name('api.search.nifas');
    Route::get('/api/search/remaja', [RemajaController::class, 'search'])->name('api.search.remaja');
    Route::get('/api/search/keluarga', [KeluargaController::class, 'search'])->name('api.search.keluarga');
});

// Admin Only Routes (Full Power)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('updateSettings');
    
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


