# Laravel Project

Proyek Laravel ini dibuat untuk membuat portal berita dengan menggunakan API External Winnicode.

## Persyaratan Sistem

Pastikan sistem Anda memiliki:

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL/PostgreSQL/SQLite
-   Web server (Apache/Nginx) atau gunakan built-in server Laravel

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/FebriTPP/PortalBerita.git
cd PortalBerita
```

### 2. Instalasi Dependencies

```bash
# Install/update PHP dependencies
composer install          # Gunakan ini pertama kali
composer update           # Jalankan ini jika ingin update ke versi terbaru sesuai composer.json

# Install/update JavaScript dependencies (Node.js)
npm install               # Menginstal semua dependencies sesuai package-lock.json
npm update                # (Opsional) Update package yang sudah terinstall ke versi terbaru yang diizinkan
```

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

### 5. Migrasi Database

```bash
# Jalankan migrasi
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 6. Storage Link (jika menggunakan file upload)

```bash
php artisan storage:link
```

**Catatan:** Pastikan anda memiliki avatar default yang tersedia di direktori `public/storage/avatars` dengan nama `default-avatar.png`. Jika file tersebut belum ada, tambahkan file avatar default ke lokasi berikut:

```
public/storage/avatars/default-avatar.png
```

File ini akan digunakan sebagai fallback jika pengguna tidak memiliki avatar yang diunggah dan perhatikan namanya.

## Menjalankan Aplikasi

### 1. Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`
