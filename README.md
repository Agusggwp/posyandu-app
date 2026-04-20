<p align="center">
  <img src="https://img.icons8.com/color/480/hospital-room.png" width="160" alt="Posyandu Logo" />
</p>

<h1 align="center">Sistem Informasi Posyandu</h1>

<p align="center">
Platform digital untuk manajemen layanan Posyandu: data keluarga, pemeriksaan kesehatan, panel Kepala Keluarga, dan monitoring admin dalam satu sistem.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/TailwindCSS-UI-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind" />
  <img src="https://img.shields.io/badge/Status-Active%20Development-16A34A?style=for-the-badge" alt="Status" />
</p>

---

## Ringkasan

Sistem ini membantu pengelolaan layanan kesehatan masyarakat secara lebih cepat, rapi, dan terukur untuk beberapa peran sekaligus:

- Admin
- Kader
- Bidan
- Kepala Keluarga

Fokus utama aplikasi adalah pencatatan data dan pemeriksaan kesehatan keluarga berbasis web dengan autentikasi multi-role.

---

## Fitur Aktif

### 1) Manajemen Data Master

- Data Kepala Keluarga
- Data Balita
- Data Ibu Hamil
- Data Nifas
- Data Remaja
- Data Lansia

### 2) Pemeriksaan Kesehatan

- Input dan update pemeriksaan Balita
- Input dan update pemeriksaan Ibu Hamil
- Input dan update pemeriksaan Nifas
- Input dan update pemeriksaan Remaja
- Input dan update pemeriksaan Lansia

### 3) Panel Kepala Keluarga

- Registrasi akun Kepala Keluarga
- Aktivasi akun via email
- Approval akun oleh admin
- Dashboard anggota keluarga dan informasi layanan
- Berita layanan dari pengaturan admin

### 4) Login & Keamanan

- Login multi-role (petugas dan Kepala Keluarga)
- Forgot Password terpisah:
  - Petugas (Admin/Kader/Bidan) satu jalur
  - Kepala Keluarga jalur khusus
- Verifikasi status akun Kepala Keluarga

### 5) Pengaturan Dinamis dari Admin

- Informasi Pusat Kesehatan
- Kustomisasi Login Kepala Keluarga + preview
- Pengaturan Berita Kepala Keluarga + preview
- Kustomisasi Login Admin

### 6) Monitoring Aktivitas

- Activity log aksi penting (login, logout, create, update, delete)
- Pencatatan aktivitas forgot password
- Filter berdasarkan user dan jenis aksi

---

## Teknologi

| Komponen | Stack |
|---|---|
| Backend | Laravel 12 |
| Bahasa | PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS + JavaScript |
| Build Tool | Vite |
| Export Dokumen | DOMPDF |

---

## Struktur Peran

| Peran | Kemampuan Utama |
|---|---|
| Admin | Full access, pengaturan sistem, approval akun, monitoring log |
| Kader | Pengelolaan data sesuai izin role |
| Bidan | Input dan pembaruan data pemeriksaan |
| Kepala Keluarga | Akses dashboard keluarga dan informasi kesehatan |

---

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/username/posyandu.git
cd posyandu
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Buat file environment

```bash
copy .env.example .env
php artisan key:generate
```

### 4. Atur konfigurasi database di .env

Gunakan kredensial MySQL lokal Anda:

- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

### 5. Migrasi dan seed data

```bash
php artisan migrate --seed
```

### 6. Jalankan aplikasi

```bash
php artisan serve
npm run dev
```

Akses aplikasi di:

- http://127.0.0.1:8000

---

## Catatan Pengembangan

- Gunakan role admin untuk konfigurasi awal sistem.
- Untuk pengujian alur Kepala Keluarga, pastikan email activation dan status approval sudah valid.
- Jika ada perubahan route/config/view, jalankan:

```bash
php artisan optimize:clear
```

---

## Roadmap Singkat

- Penyempurnaan dashboard analitik kesehatan
- Peningkatan laporan statistik lintas kategori
- Peningkatan notifikasi layanan

---

## Lisensi

Project ini dikembangkan untuk kebutuhan sistem informasi layanan Posyandu.