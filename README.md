# Play Video - Video Access Management System

Aplikasi backend Laravel untuk mengelola akses video dengan sistem role-based access control (RBAC). Sistem ini memungkinkan admin untuk mengatur hak akses customer terhadap video-video tertentu dengan kontrol waktu akses yang fleksibel.

## Daftar Isi
- [Fitur](#fitur)
- [Requirement](#requirement)
- [Instalasi](#instalasi)
- [Konfigurasi Database](#konfigurasi-database)
- [Migrasi Database](#migrasi-database)
- [Role & Hak Akses](#role--hak-akses)
- [Struktur Database](#struktur-database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)

## Fitur

- **Autentikasi**: Menggunakan Laravel Sanctum untuk API authentication
- **Role-Based Access Control**: Sistem role dengan admin dan customer
- **Video Management**: Admin dapat mengelola video dengan thumbnail dan deskripsi
- **Access Request System**: Customer dapat meminta akses video
- **Time-Based Access**: Admin dapat mengatur waktu akses video untuk setiap customer
- **Access Status Tracking**: Monitoring status permintaan akses (menunggu persetujuan, diizinkan, ditolak, izin kadaluarsa)

## Requirement

- **PHP**: v8.1 atau lebih tinggi
- **Composer**: v2.0 atau lebih tinggi
- **Database**: MySQL
- **Node.js**: v14 atau lebih tinggi (untuk asset compilation)
- **Git**: Untuk version control

### Framework & Libraries
- **Laravel**: v10.0
- **Laravel Tinker**: v2.8 (Interactive shell)
- **Tailwind CSS**: v4.2 (css framework)

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd playVideo
```
ubah repository url jadi url repository ini yang ada di github

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies Node.js
```bash
npm install
```
### 4. Setup Environment File
```bash
# Copy file .env.example ke .env
cp .env.example .env
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

Edit file `.env` sesuaikan dengan konfigurasi lokal Anda:
```env
APP_NAME=PlayVideo
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=play_video
DB_USERNAME=root
DB_PASSWORD=

```

## Konfigurasi Database

### 1. Buat Database
```bash
# MySQL
mysql -u root -p
> CREATE DATABASE play_video;
```


### 2. Update Konfigurasi di `.env`
Sesuaikan dengan database yang ingin Anda gunakan.

## Migrasi Database

### Jalankan Migrasi & Seed

```bash
# Fresh migration (reset database dan jalankan migrasi + seeding)
php artisan migrate:fresh --seed
```

Atau langkah per langkah:

```bash
# Jalankan migrasi saja
php artisan migrate

# Jalankan seeding saja
php artisan db:seed
```

### Migrasi yang Dijalankan

1. **create_roles_table**: Tabel untuk menyimpan data role
2. **create_users_table**: Tabel untuk menyimpan data user
3. **create_password_reset_tokens_table**: Tabel untuk token reset password
4. **create_failed_jobs_table**: Tabel untuk job yang gagal
5. **create_personal_access_tokens_table**: Tabel untuk Sanctum tokens
6. **create_videos_table**: Tabel untuk data video
7. **create_video_access_reqs_table**: Tabel untuk permintaan akses video
8. **create_video_access_times_table**: Tabel untuk waktu akses video

## Role & Hak Akses

Sistem ini menyediakan 2 role utama dengan hak akses berbeda:

### 1. **ADMIN**
Admin adalah pengguna dengan hak akses penuh terhadap sistem.

**Hak Akses:**
- ✅ Mengelola video (create, read, update, delete)
- ✅ Melihat semua permintaan akses dari customer
- ✅ Menyetujui atau menolak permintaan akses video
- ✅ Mengatur waktu akses video untuk setiap customer
- ✅ Mengubah status akses (diizinkan, ditolak, izin kadaluarsa)
- ✅ Melihat laporan akses video
- ✅ Mengelola pengguna sistem
- ✅ Mengakses dashboard admin

### 2. **CUSTOMER**
Customer adalah pengguna yang hanya bisa mengakses video yang sudah disetujui oleh admin.

**Hak Akses:**
- ✅ Melihat daftar video yang tersedia
- ✅ Melakukan permintaan akses untuk video tertentu
- ✅ Melihat status permintaan akses mereka
- ✅ Menonton video yang sudah disetujui (dalam periode waktu yang ditentukan)
- ❌ Tidak bisa membuat, edit, atau delete video
- ❌ Tidak bisa menyetujui permintaan akses
- ❌ Tidak bisa mengakses data video yang tidak disetujui

## Struktur Database

### Tabel: roles
```
id (Integer, Primary Key)
role_name (String) - Nama role: "admin", "customer"
created_at (Timestamp)
updated_at (Timestamp)
```

### Tabel: users
```
id (Integer, Primary Key)
name (String) - Nama lengkap user
email (String, Unique) - Email user
username (String) - Username unik
password (String) - Password terenkripsi
role_id (Integer, Foreign Key) - Relasi ke tabel roles
email_verified_at (Timestamp, Nullable)
remember_token (String, Nullable)
created_at (Timestamp)
updated_at (Timestamp)
```

### Tabel: videos
```
id (Integer, Primary Key)
title (String) - Judul video
description (String) - Deskripsi video
thumbnail (String) - Path ke file thumbnail
video_path (String) - Path ke file video
created_at (Timestamp)
updated_at (Timestamp)
```

### Tabel: video_access_reqs
```
id (Integer, Primary Key)
user_id (Integer, Foreign Key) - User yang meminta akses
video_id (Integer, Foreign Key) - Video yang diakses
status (Enum) - Status permintaan:
  - "menunggu persetujuan" (default)
  - "diizinkan"
  - "ditolak"
  - "izin kadaluarsa"
created_at (Timestamp)
updated_at (Timestamp)
```

### Tabel: video_access_times
```
id (Integer, Primary Key)
video_access_req_id (Integer, Foreign Key) - Relasi ke video_access_reqs
start_date (Date, Nullable) - Tanggal mulai akses
end_date (Date, Nullable) - Tanggal berakhir akses
created_at (Timestamp)
updated_at (Timestamp)
```

## Relasi Model

### User Model
```
- User memiliki satu Role (belongsTo)
- User memiliki banyak VideoAccessReq (hasMany)
- User memiliki banyak VideoAccessTime (hasMany)
```

### Role Model
```
- Role memiliki banyak User (hasMany)
```

### Video Model
```
- Video memiliki banyak VideoAccessReq (hasMany)
```

### VideoAccessReq Model
```
- VideoAccessReq milik satu User (belongsTo)
- VideoAccessReq milik satu Video (belongsTo)
- VideoAccessReq memiliki satu VideoAccessTime (hasOne)
```

### VideoAccessTime Model
```
- VideoAccessTime milik satu VideoAccessReq (belongsTo)
```

## Seeding Data

Aplikasi dilengkapi dengan seeders untuk testing dan development:

### RoleSeeder
Membuat 2 role standar:
- `admin` - Administrator
- `customer` - Customer

### UserSeeder
Membuat user dummy untuk testing (jika dikonfigurasi)

### DatabaseSeeder
Main seeder yang menjalankan semua seeder lainnya.

Jalankan seeding:
```bash
php artisan db:seed
```

Atau khusus role seeder:
```bash
php artisan db:seed --class=RoleSeeder
```

## Menjalankan Aplikasi

### Development Server
```bash
# Terminal 1: Jalankan Laravel Development Server
php artisan serve

# Server akan berjalan di: http://localhost:8000
```

### Terminal Tambahan

```bash
# Terminal 2: Watch dan compile assets (Vite)
npm run dev
```
## Akun demo
jika anda telah menjalankan main seedernya, maka akan ada 2 akun demo untuk login, dengan 2 role yang berbeda, yaitu Admin dan Customer

### Admin
username: admin
password: password

### Customer
username: customer
password: password

## Struktur Project

```
playVideo/
├── app/
│   ├── Console/           # Console commands
│   ├── Exceptions/        # Exception handling
│   ├── Http/
│   │   ├── Controllers/   # API Controllers
│   │   ├── Kernel.php     # HTTP Kernel
│   │   └── Middleware/    # Custom middleware
│   ├── Models/            # Eloquent Models
│   └── Providers/         # Service providers
├── database/
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   ├── seeders/          # Database seeders
│   └── sql/              # SQL dumps
├── routes/
│   ├── api.php           # API routes
│   ├── web.php           # Web routes
│   └── channels.php      # Broadcasting channels
├── resources/
│   ├── css/              # CSS files
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── config/               # Configuration files
├── storage/              # Storage directory
├── tests/                # Test files
└── vendor/               # Dependencies
```

## Command Penting

```bash
# Migration
php artisan migrate              # Jalankan migrasi
php artisan migrate:fresh        # Reset dan jalankan migrasi
php artisan migrate:fresh --seed # Reset, migrasi, dan seed
php artisan migrate:rollback     # Rollback migrasi terakhir
php artisan migrate:reset        # Rollback semua migrasi

# Seeding
php artisan db:seed                    # Jalankan semua seeder
php artisan db:seed --class=RoleSeeder # Jalankan seeder spesifik

# Tinker
php artisan tinker               # Buka interactive shell

# Serve
php artisan serve                # Jalankan development server
php artisan serve --port=8001    # Jalankan di port berbeda

# Cache & Optimization
php artisan cache:clear          # Clear semua cache
php artisan config:cache         # Cache konfigurasi
php artisan route:cache          # Cache routes
```

