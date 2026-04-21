# Sistem Aset Kantor

Sistem manajemen aset kantor modern menggunakan CodeIgniter 4 dengan antarmuka yang elegan dan responsif.

## Fitur Utama

✨ **Landing Page Login Admin**
- Username & Password
- Captcha numerik acak 6 digit untuk keamanan login
- Desain modern dan responsif

📊 **Dashboard**
- Menu navigasi yang intuitif
- Akses mudah ke data barang

📦 **Manajemen Aset**
- Tambah data barang dengan informasi lengkap:
  - Nama barang
  - Merk/vendor
  - Tahun pengadaan (pilih tahun)
  - Foto/gambar barang (upload)
  - Jenis aset (Aset atau Non Aset)
  - Kondisi (Baik / Rusak Ringan / Rusak Berat)
  - Status otomatis (Ada / Dipinjam / Hilang)

📱 **QR Code Generation**
- Generate otomatis QR code per barang
- Untuk tracking dan identifikasi aset

## Persyaratan

- PHP 8.2 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
- Laragon atau web server sejenis

## Instalasi

### 1. Setup Database

Buat database MySQL baru:
```bash
mysql -u root
```

```sql
CREATE DATABASE sistem_aset CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Clone/Setup Project

```bash
cd c:\laragon\www
git clone <repository-url> sistem-aset
cd sistem-aset
composer install
```

### 3. Konfigurasi Database

Edit file `app/Config/Database.php`:
```php
public array $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'sistem_aset',
    'DBDriver' => 'MySQLi',
    // ... konfigurasi lainnya
];
```

### 3a. Konfigurasi Base URL

Edit file `.env`, lalu pastikan nilainya seperti ini:

```ini
app.baseURL = 'http://localhost/sistem-aset/'
```

Gunakan URL di atas (tanpa `/public/`) agar routing sesuai struktur project.

### 4. Migrasi Database

```bash
php spark migrate
```

### 5. Seeder Data Admin

```bash
php spark db:seed UserSeeder
```

### 6. Jalankan Server

```bash
php spark serve
```

Server akan berjalan di: `http://localhost:8080`

## Login Admin

- **Username**: `@Adminaset2026`
- **Password**: `@Aset2026`

## Struktur Database

### Tabel `users`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| username | VARCHAR(100) | Unique |
| password | VARCHAR(255) | Hashed |
| created_at | DATETIME | Waktu dibuat |
| updated_at | DATETIME | Waktu diperbarui |

### Tabel `assets`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT | Primary Key |
| nama_barang | VARCHAR(255) | Nama aset |
| merk_barang | VARCHAR(255) | Merk/vendor |
| tahun_pengadaan | YEAR | Tahun perolehan |
| foto | VARCHAR(255) | Nama file foto |
| jenis_aset | ENUM | 'aset' atau 'non_aset' |
| kondisi | ENUM | 'baik', 'rusak_ringan', 'rusak_berat' |
| status | ENUM | 'ada', 'dipinjam', 'hilang' |
| qr_code | VARCHAR(255) | Nama file QR code |
| created_at | DATETIME | Waktu dibuat |
| updated_at | DATETIME | Waktu diperbarui |

## Struktur File Penting

```
sistem-aset/
├── app/
│   ├── Controllers/
│   │   ├── Auth.php           # Controller login
│   │   ├── Dashboard.php       # Controller dashboard
│   │   └── Assets.php          # Controller manajemen aset
│   ├── Models/
│   │   ├── UserModel.php       # Model user
│   │   └── AssetModel.php      # Model aset
│   ├── Views/
│   │   ├── auth/login.php      # Halaman login
│   │   ├── dashboard/index.php # Halaman dashboard
│   │   └── assets/             # View aset
│   └── Database/
│       ├── Migrations/         # File migrasi
│       └── Seeds/              # File seeder
├── public/
│   ├── index.php
│   └── uploads/                # Folder upload foto & QR code
└── writable/
    └── logs/                   # Log files
```

## Penggunaan

### Login
1. Akses `http://localhost:8080`
2. Masukkan username: `@Adminaset2026`
3. Masukkan password: `@Aset2026`
4. Jawab captcha aritmatika
5. Klik Login

### Menambah Barang
1. Dari dashboard, klik "Tambah Barang"
2. Isi form dengan informasi barang:
   - Nama barang (wajib)
   - Merk barang
   - Tahun pengadaan
   - Upload foto
   - Pilih jenis aset
   - Pilih kondisi
3. Klik "Simpan Data Barang"
4. QR code akan otomatis di-generate

### Melihat Data Barang
1. Klik menu "Data Barang"
2. Lihat semua aset dalam bentuk kartu
3. Klik "Lihat" untuk detail lengkap

## Fitur Keamanan

- ✅ Password di-hash dengan bcrypt
- ✅ Captcha untuk mencegah brute force
- ✅ Session validation
- ✅ CSRF protection (built-in CodeIgniter)

## Troubleshooting

### Error: Access denied for user
**Solusi**: Pastikan kredensial database sudah benar di `app/Config/Database.php`

### Error: Table not found
**Solusi**: Jalankan migrasi: `php spark migrate`

### Foto tidak tampil
**Solusi**: Pastikan folder `public/uploads/` ada dan writable

### QR Code error
**Solusi**: Pastikan `endroid/qr-code` terinstall: `composer require endroid/qr-code`

## Developer

Dikembangkan dengan ❤️ menggunakan CodeIgniter 4
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
