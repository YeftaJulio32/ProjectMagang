# Laravel Project

Proyek Laravel ini dibuat untuk [deskripsi singkat aplikasi Anda].

## Persyaratan Sistem

Pastikan sistem Anda memiliki:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite
- Web server (Apache/Nginx) atau gunakan built-in server Laravel

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/repository-name.git
cd repository-name
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
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

### 6. Compile Assets

```bash
# Development
npm run dev

# Production
npm run build

# Watch mode untuk development
npm run watch
```

### 7. Storage Link (jika menggunakan file upload)

```bash
php artisan storage:link
```

## Menjalankan Aplikasi

### Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

### Dengan Valet (macOS/Linux)

```bash
valet link
```

### Dengan Docker (jika tersedia docker-compose.yml)

```bash
docker-compose up -d
```

## Perintah Tambahan

### Cache & Optimization

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Queue (jika menggunakan job queue)

```bash
php artisan queue:work
```

### Scheduled Tasks (jika ada)

Tambahkan ke crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Testing

```bash
# Jalankan test
php artisan test

# Atau dengan PHPUnit
./vendor/bin/phpunit
```

## Struktur Folder Penting

```
app/
├── Http/Controllers/    # Controllers
├── Models/             # Eloquent Models
├── Services/           # Business Logic
├── Mail/              # Mail classes
└── Jobs/              # Queue jobs

resources/
├── views/             # Blade templates
├── js/               # JavaScript files
└── css/              # CSS files

database/
├── migrations/        # Database migrations
└── seeders/          # Database seeders

routes/
├── web.php           # Web routes
└── api.php           # API routes
```

## Konfigurasi Tambahan

### Mail Configuration

Edit konfigurasi email di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Upload

Jika aplikasi menggunakan file upload, pastikan folder `storage` memiliki permission yang tepat:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Troubleshooting

### Error Permission Denied

```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error Composer

```bash
composer dump-autoload
```

### Error NPM

```bash
rm -rf node_modules
rm package-lock.json
npm install
```

## Kontribusi

1. Fork repository
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Proyek ini menggunakan lisensi [MIT License](LICENSE).

## Kontak

- Developer: [Nama Anda]
- Email: [email@example.com]
- Project Link: [https://github.com/username/repository-name](https://github.com/username/repository-name)
