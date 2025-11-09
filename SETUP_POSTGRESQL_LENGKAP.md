# 🗄️ Setup PostgreSQL Lengkap untuk Proyek Cloudy

## 📋 Prerequisites

1. PostgreSQL sudah terinstall
2. PostgreSQL service sedang berjalan
3. pgAdmin terinstall (opsional, untuk GUI)

## 🚀 Langkah-langkah Setup

### Step 1: Buat Database di PostgreSQL

**Opsi A: Menggunakan pgAdmin (GUI)**
1. Buka **pgAdmin**
2. Connect ke PostgreSQL server (gunakan password PostgreSQL Anda)
3. Klik kanan pada **"Databases"** → **"Create"** → **"Database"**
4. Nama database: `cloudy_project`
5. Klik **"Save"**

**Opsi B: Menggunakan psql (Command Line)**
```bash
# Masuk ke psql
psql -U postgres

# Buat database
CREATE DATABASE cloudy_project;

# Keluar
\q
```

**Opsi C: Menggunakan SQL Script**
Jalankan di pgAdmin atau psql:
```sql
CREATE DATABASE cloudy_project;
```

### Step 2: Update Konfigurasi di .env

File `.env` harus dikonfigurasi dengan benar:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=cloudy_project
DB_USERNAME=postgres
DB_PASSWORD=MASUKKAN_PASSWORD_POSTGRESQL_ANDA_DISINI
```

**PENTING:** Ganti `MASUKKAN_PASSWORD_POSTGRESQL_ANDA_DISINI` dengan password PostgreSQL yang benar!

**Cara Update Password di .env:**

**Menggunakan PowerShell:**
```powershell
# Ganti 'password_anda' dengan password PostgreSQL yang benar
(Get-Content .env) -replace 'DB_PASSWORD=postgres', 'DB_PASSWORD=password_anda' | Set-Content .env
```

**Atau edit manual:**
1. Buka file `.env`
2. Cari baris `DB_PASSWORD=postgres`
3. Ganti dengan password PostgreSQL Anda
4. Simpan file

### Step 3: Clear Config Cache

```bash
php artisan config:clear
```

### Step 4: Test Koneksi Database

```bash
php artisan migrate:status
```

Jika berhasil, Anda akan melihat status migrasi (kosong jika belum ada migrasi).

Jika error, cek:
- Password PostgreSQL benar
- Database `cloudy_project` sudah dibuat
- PostgreSQL service berjalan

### Step 5: Jalankan Migrasi

```bash
php artisan migrate
```

Ini akan membuat semua tabel yang diperlukan di database.

### Step 6: Seed Database (Admin User)

```bash
php artisan db:seed --class=AdminUserSeeder
```

Ini akan membuat user admin dengan:
- **Email:** `admin@cloudywear.test`
- **Password:** `password123`

### Step 7: Test Aplikasi

```bash
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

Login dengan:
- **Email:** `admin@cloudywear.test`
- **Password:** `password123`

## 🔧 Menggunakan Script Otomatis

Untuk memudahkan, gunakan script `setup-postgresql.ps1`:

```powershell
.\setup-postgresql.ps1
```

Script ini akan:
1. Meminta password PostgreSQL
2. Update file `.env`
3. Clear config cache
4. Test koneksi
5. Jalankan migrasi
6. Seed database

## 🐛 Troubleshooting

### Error: password authentication failed

**Penyebab:** Password PostgreSQL di `.env` salah

**Solusi:**
1. Cek password di pgAdmin (password yang Anda gunakan untuk login)
2. Update `DB_PASSWORD` di `.env`
3. Clear config: `php artisan config:clear`
4. Test lagi: `php artisan migrate:status`

### Error: database "cloudy_project" does not exist

**Penyebab:** Database belum dibuat

**Solusi:**
1. Buat database di PostgreSQL:
   ```sql
   CREATE DATABASE cloudy_project;
   ```
2. Atau ubah nama database di `.env` ke database yang sudah ada

### Error: connection refused

**Penyebab:** PostgreSQL service tidak berjalan

**Solusi:**
1. Start PostgreSQL service:
   - Windows: Services → PostgreSQL → Start
   - Atau: `net start postgresql-x64-16` (sesuai versi)
2. Cek port: Default PostgreSQL port adalah 5432

### Error: Permission denied

**Penyebab:** User tidak memiliki akses ke database

**Solusi:**
```sql
-- Berikan privileges
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO postgres;

-- Connect ke database
\c cloudy_project

-- Berikan schema privileges
GRANT ALL ON SCHEMA public TO postgres;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO postgres;
```

## 📝 Checklist Setup

- [ ] PostgreSQL terinstall dan service berjalan
- [ ] Database `cloudy_project` sudah dibuat
- [ ] File `.env` dikonfigurasi dengan benar (password benar)
- [ ] Config cache cleared (`php artisan config:clear`)
- [ ] Koneksi database berhasil (`php artisan migrate:status`)
- [ ] Migrasi berhasil (`php artisan migrate`)
- [ ] Seeder berhasil (`php artisan db:seed --class=AdminUserSeeder`)
- [ ] Aplikasi bisa diakses (`php artisan serve`)
- [ ] Bisa login dengan admin@cloudywear.test / password123

## 🎯 Quick Setup (Jika Sudah Tahu Password PostgreSQL)

```powershell
# 1. Update password di .env (ganti 'password_anda' dengan password PostgreSQL)
(Get-Content .env) -replace 'DB_PASSWORD=postgres', 'DB_PASSWORD=password_anda' | Set-Content .env

# 2. Clear config
php artisan config:clear

# 3. Test koneksi
php artisan migrate:status

# 4. Migrate
php artisan migrate

# 5. Seed
php artisan db:seed --class=AdminUserSeeder

# 6. Test aplikasi
php artisan serve
```

## 💡 Tips

1. **Password PostgreSQL biasanya:**
   - Password yang Anda set saat install PostgreSQL
   - Atau kosong (jika menggunakan XAMPP/Laragon)
   - Atau `postgres` (default)

2. **Jika lupa password PostgreSQL:**
   - Reset password melalui pgAdmin
   - Atau edit `pg_hba.conf` dan restart service

3. **Untuk development, pastikan:**
   - Database name: `cloudy_project`
   - User: `postgres` (atau user lain dengan privileges)
   - Host: `127.0.0.1`
   - Port: `5432`

## ✅ Setelah Setup Berhasil

Aplikasi siap digunakan! Login dengan:
- **Email:** `admin@cloudywear.test`
- **Password:** `password123`

Selamat coding! 🎉


