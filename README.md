# Sistem Aset Berbasis Web

Sistem manajemen aset kantor menggunakan CodeIgniter 4.

## Fitur

- Landing page login admin
- Login dengan username, password, dan captcha penjumlahan/pengurangan
- Dashboard setelah login
- Menu aset untuk mencatat barang (nama, spesifikasi, jenis)
- Generate QR code otomatis per barang

## Setup

1. Pastikan PHP 8.2+, MySQL, Composer terinstall.

2. Clone atau download proyek ini.

3. Install dependencies:
   ```
   composer install
   ```

4. Buat database MySQL bernama `sistem_aset`.

5. Update konfigurasi database di `app/Config/Database.php`:
   - hostname: localhost
   - username: root (atau sesuai)
   - password: (sesuai)
   - database: sistem_aset

6. Jalankan migrasi:
   ```
   php spark migrate
   ```

7. Jalankan seeder untuk user admin:
   ```
   php spark db:seed UserSeeder
   ```

8. Jalankan server:
   ```
   php spark serve
   ```

9. Akses di browser: http://localhost:8080

## Login

- Username: admin
- Password: admin123

## Struktur Database

- users: id, username, password, created_at, updated_at
- assets: id, nama_barang, spesifikasi, jenis_barang, qr_code, created_at, updated_at
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
