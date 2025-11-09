# Panduan Setup Database PostgreSQL

## Status Konfigurasi Saat Ini

File `.env` telah diperbarui dengan konfigurasi berikut:
- **DB_CONNECTION**: pgsql
- **DB_HOST**: 127.0.0.1
- **DB_PORT**: 5432
- **DB_DATABASE**: cloudy_project
- **DB_USERNAME**: postgres
- **DB_PASSWORD**: postgres

## Langkah-langkah Setup

### 1. Pastikan PostgreSQL Berjalan
- Pastikan service PostgreSQL sudah berjalan di sistem Anda
- Cek di Services (Windows) atau dengan command: `pg_isready`

### 2. Verifikasi Password PostgreSQL
Jika password user `postgres` bukan `postgres`, update di file `.env`:
```env
DB_PASSWORD=password_anda_disini
```

### 3. Buat Database (jika belum ada)

**Opsi A: Menggunakan pgAdmin**
1. Buka pgAdmin
2. Connect ke PostgreSQL server
3. Klik kanan pada "Databases" → "Create" → "Database"
4. Nama database: `cloudy_project`
5. Klik "Save"

**Opsi B: Menggunakan psql Command Line**
```bash
psql -U postgres
CREATE DATABASE cloudy_project;
\q
```

**Opsi C: Menggunakan SQL Script**
Jalankan file `setup-database.sql` di pgAdmin atau psql

### 4. Test Koneksi Database

Jalankan command berikut untuk test koneksi:
```bash
php artisan migrate:status
```

Jika berhasil, Anda akan melihat status migrasi.

### 5. Jalankan Migrasi

Setelah database berhasil dibuat, jalankan:
```bash
php artisan migrate
```

### 6. Seed Database (Opsional)

Untuk mengisi data awal:
```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=ProductSeeder
```

## Troubleshooting

### Error: Password authentication failed
**Solusi:**
1. Cek password PostgreSQL user `postgres`
2. Update `DB_PASSWORD` di `.env` sesuai password yang benar
3. Clear config cache: `php artisan config:clear`

### Error: Database does not exist
**Solusi:**
1. Buat database `cloudy_project` di PostgreSQL
2. Pastikan database name di `.env` sesuai

### Error: Connection refused
**Solusi:**
1. Pastikan PostgreSQL service berjalan
2. Cek `DB_HOST` dan `DB_PORT` di `.env`
3. Default port PostgreSQL: 5432

### Menggunakan User Kustom (laravel_user)

Jika Anda ingin menggunakan user `laravel_user`:

1. Buat user di PostgreSQL:
```sql
CREATE USER laravel_user WITH PASSWORD 'laravel_pass';
CREATE DATABASE laravel_db;
GRANT ALL PRIVILEGES ON DATABASE laravel_db TO laravel_user;
\c laravel_db
GRANT ALL ON SCHEMA public TO laravel_user;
```

2. Update `.env`:
```env
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

3. Clear config: `php artisan config:clear`

## Setelah Setup Berhasil

1. Test aplikasi: `php artisan serve`
2. Akses: http://127.0.0.1:8000
3. Login dengan:
   - Email: admin@cloudywear.test
   - Password: password123


