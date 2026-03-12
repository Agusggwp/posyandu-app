# Sistem Permission & Role

## Overview
Aplikasi Posyandu telah dilengkapi dengan sistem permission untuk mengontrol akses user berdasarkan role mereka sesuai dengan tabel hak akses.

## Role & Permissions

### 1. **Admin (Full Power - Super Admin)**
Admin memiliki akses penuh ke semua fitur aplikasi.

**Permissions:**
- `manage_users` - ✅ Mengelola akun pengguna
- `manage_roles` - Mengelola role dan permissions  
- `manage_keluarga` - ✅ Menginput data ibu/keluarga
- `manage_balita` - ✅ Menginput data balita
- `manage_ibu_hamil` - ✅ Menginput data ibu hamil
- `manage_lansia` - ✅ Menginput data lansia
- `manage_pemeriksaan` - ✅ Menginput data pemeriksaan kesehatan
- `edit_pemeriksaan` - ✅ Mengedit data pemeriksaan
- `view_data` - ✅ Melihat data kesehatan
- `view_reports` - ✅ Melihat laporan posyandu
- `delete_data` - ✅ Menghapus data
- `export_data` - Export data (Excel/PDF)
- `manage_settings` - Kelola pengaturan sistem

**Login Credentials:**
- Email: admin@posyandu.com
- Password: password

**Dapat Melakukan:**
- ✅ Mengelola akun pengguna
- ✅ Menginput data balita, ibu, ibu hamil, lansia
- ✅ Menginput data pemeriksaan kesehatan
- ✅ Mengedit data pemeriksaan
- ✅ Melihat data kesehatan
- ✅ Melihat laporan posyandu
- ✅ Menghapus data (semua jenis)

---

### 2. **Kader**
Kader dapat mengelola data warga (input data balita, ibu, ibu hamil, lansia) dan melihat laporan.

**Permissions:**
- `manage_keluarga` - ✅ Menginput data ibu/keluarga
- `manage_balita` - ✅ Menginput data balita
- `manage_ibu_hamil` - ✅ Menginput data ibu hamil
- `manage_lansia` - ✅ Menginput data lansia
- `view_data` - ✅ Melihat data kesehatan
- `view_reports` - ✅ Melihat laporan posyandu

**Login Credentials:**
- Email: kader@posyandu.com
- Password: password

**Dapat Melakukan:**
- ✅ Menginput data balita
- ✅ Menginput data ibu
- ✅ Menginput data ibu hamil
- ✅ Menginput data lansia
- ✅ Melihat data kesehatan
- ✅ Melihat laporan posyandu
- ❌ Menginput data pemeriksaan
- ❌ Mengedit data pemeriksaan
- ❌ Menghapus data

---

### 3. **Bidan**
Bidan fokus pada pemeriksaan kesehatan (menginput dan mengedit pemeriksaan).

**Permissions:**
- `manage_pemeriksaan` - ✅ Menginput data pemeriksaan kesehatan
- `edit_pemeriksaan` - ✅ Mengedit data pemeriksaan
- `view_data` - ✅ Melihat data kesehatan
- `view_reports` - ✅ Melihat laporan posyandu

**Login Credentials:**
- Email: bidan@posyandu.com
- Password: password

**Dapat Melakukan:**
- ✅ Menginput data pemeriksaan kesehatan (Balita, Ibu Hamil, Lansia)
- ✅ Mengedit data pemeriksaan
- ✅ Melihat data kesehatan
- ✅ Melihat laporan posyandu
- ❌ Menginput data balita, ibu, ibu hamil, lansia
- ❌ Menghapus data

---

## Tabel Hak Akses (Permissions Matrix)

| Kegiatan / Hak Akses | Admin | Kader | Bidan |
|---------------------|-------|-------|-------|
| Mengelola akun pengguna | ✅ | ❌ | ❌ |
| Menginput data balita | ✅ | ✅ | ❌ |
| Menginput data ibu | ✅ | ✅ | ❌ |
| Menginput data ibu hamil | ✅ | ✅ | ❌ |
| Menginput data lansia | ✅ | ✅ | ❌ |
| Menginput data pemeriksaan kesehatan | ✅ | ❌ | ✅ |
| Mengedit data pemeriksaan | ✅ | ❌ | ✅ |
| Melihat data kesehatan | ✅ | ✅ | ✅ |
| Melihat laporan posyandu | ✅ | ✅ | ✅ |
| Menghapus data | ✅ | ❌ | ❌ |

---

## Penggunaan di Controller

### Check Role
```php
// Cek apakah user adalah admin
if (auth()->user()->isAdmin()) {
    // Kode untuk admin
}

// Cek apakah user adalah kader
if (auth()->user()->isKader()) {
    // Kode untuk kader
}

// Cek apakah user adalah bidan
if (auth()->user()->isBidan()) {
    // Kode untuk bidan
}
```

### Check Permission
```php
// Cek single permission
if (auth()->user()->hasPermission('manage_users')) {
    // User memiliki permission manage_users
}

// Cek multiple permissions (salah satu)
if (auth()->user()->hasAnyPermission(['manage_balita', 'manage_ibu_hamil'])) {
    // User memiliki minimal 1 dari permissions tersebut
}

// Cek multiple permissions (semua harus ada)
if (auth()->user()->hasAllPermissions(['manage_balita', 'view_reports'])) {
    // User memiliki semua permissions tersebut
}
```

---

## Penggunaan di Routes

### Menggunakan Middleware Role
```php
// Hanya admin yang bisa akses
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});

// Multiple roles
Route::middleware(['auth', 'role:admin,kader'])->group(function () {
    Route::resource('keluarga', KeluargaController::class);
});
```

### Menggunakan Middleware Permission
```php
// Hanya yang punya permission manage_users
Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});

// Multiple permissions (salah satu saja sudah cukup)
Route::middleware(['auth', 'permission:manage_balita,manage_ibu_hamil'])->group(function () {
    Route::get('/pemeriksaan', [PemeriksaanController::class, 'index']);
});
```

---

## Penggunaan di Blade Templates

### Check Role (Method 1 - Manual)
```blade
@if(auth()->user()->isAdmin())
    <a href="{{ route('admin.settings') }}">Pengaturan Sistem</a>
@endif

@if(auth()->user()->isKader() || auth()->user()->isBidan())
    <a href="{{ route('pemeriksaan.index') }}">Data Pemeriksaan</a>
@endif
```

### Check Role (Method 2 - Blade Directive) ⭐ Recommended
```blade
@admin
    <a href="{{ route('admin.settings') }}">Pengaturan Sistem</a>
@endadmin

@kader
    <p>Selamat datang, Kader!</p>
@endkader

@bidan
    <p>Selamat datang, Bidan!</p>
@endbidan
```

### Check Permission (Method 1 - Manual)
```blade
@if(auth()->user()->hasPermission('manage_users'))
    <button>Tambah User</button>
@endif

@if(auth()->user()->hasPermission('export_data'))
    <button>Export Data</button>
@endif
```

### Check Permission (Method 2 - Blade Directive) ⭐ Recommended
```blade
@haspermission('manage_users')
    <button class="btn btn-primary">Tambah User</button>
@endhaspermission

@haspermission('export_data')
    <a href="{{ route('laporan.export-excel', 'balita') }}" class="btn btn-success">
        Export Excel
    </a>
@endhaspermission
```

### Contoh Kombinasi
```blade
<nav>
    @admin
        <li><a href="{{ route('users.index') }}">Kelola User</a></li>
        <li><a href="{{ route('settings.index') }}">Pengaturan</a></li>
    @endadmin

    @haspermission('manage_keluarga')
        <li><a href="{{ route('keluarga.index') }}">Data Keluarga</a></li>
    @endhaspermission

    @haspermission('view_reports')
        <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
    @endhaspermission
</nav>
```

---

## Contoh Implementasi di Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // Semua method butuh authentication
        $this->middleware('auth');
        
        // Method tertentu butuh permission
        $this->middleware('permission:manage_users')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        // Admin bisa lihat semua user
        if (auth()->user()->isAdmin()) {
            $users = User::with('role')->get();
        } else {
            // Role lain cuma bisa lihat profil sendiri
            $users = User::where('id', auth()->id())->get();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Hanya admin yang sampai sini (sudah dicek middleware)
        return view('users.create');
    }
}
```

---

## Admin Full Power

Admin memiliki **privilege khusus**: 
- ✅ Bypass semua permission checks di middleware `permission`
- ✅ Akses ke semua fitur tanpa pembatasan
- ✅ Dapat mengubah data user lain
- ✅ Dapat mengatur role dan permissions

Admin adalah **Super User** dengan kontrol penuh terhadap aplikasi.

---

## Catatan Penting

1. **Admin Bypass**: Admin otomatis punya akses ke semua permission tanpa perlu dicek satu-satu
2. **Multiple Middleware**: Bisa combine `role` dan `permission` middleware sekaligus
3. **Custom Permission**: Tambah permission baru di `RoleSeeder.php` jika diperlukan
4. **Security**: Selalu gunakan middleware `auth` sebelum middleware `role` atau `permission`

---

## Troubleshooting

### User tidak bisa akses halaman
1. Pastikan user sudah login
2. Cek role user di database
3. Cek permission yang dimiliki role tersebut
4. Pastikan middleware sudah terdaftar di `bootstrap/app.php`

### Permission tidak bekerja
1. Clear cache: `php artisan config:clear`
2. Clear cache: `php artisan cache:clear`
3. Restart server

### Menambah Permission Baru
Edit file `database/seeders/RoleSeeder.php` dan tambahkan permission baru, lalu:
```bash
php artisan migrate:fresh --seed
```

⚠️ **Warning**: Command di atas akan menghapus semua data!

---

## Support

Jika ada pertanyaan atau issue, silakan hubungi administrator sistem.
