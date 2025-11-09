# 🚀 Solusi Error Database PostgreSQL

## ❌ Error yang Terjadi
```
SQLSTATE[08006] [7] FATAL: password authentication failed for user "postgres"
```

## ✅ Solusi yang Tersedia

### 🎯 OPSI 1: Perbaiki Password PostgreSQL (Disarankan untuk Production)

#### Langkah 1: Cek Password di pgAdmin
1. Buka **pgAdmin**
2. Lihat password yang Anda gunakan saat login
3. Update `.env` dengan password yang benar:
   ```powershell
   (Get-Content .env) -replace 'DB_PASSWORD=postgres', 'DB_PASSWORD=password_anda' | Set-Content .env
   php artisan config:clear
   ```

#### Langkah 2: Test Koneksi
```bash
php artisan migrate:status
```

#### Langkah 3: Jika Berhasil, Jalankan Migrasi
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

**📖 Detail lengkap:** Lihat file `FIX_PASSWORD.md`

---

### 🚀 OPSI 2: Gunakan SQLite (Paling Mudah untuk Development)

SQLite tidak memerlukan setup server database, lebih cepat untuk development.

#### Langkah 1: Switch ke SQLite
```powershell
.\switch-to-sqlite.ps1
```

Atau manual:
```powershell
# Update .env
(Get-Content .env) -replace 'DB_CONNECTION=pgsql', 'DB_CONNECTION=sqlite' | Set-Content .env
php artisan config:clear
```

#### Langkah 2: Buat File Database
```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

#### Langkah 3: Migrasi
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

#### Langkah 4: Test Aplikasi
```bash
php artisan serve
```

---

### 🔧 OPSI 3: Buat User PostgreSQL Baru

Jika tidak tahu password postgres, buat user baru:

1. **Buka pgAdmin** atau **psql**
2. **Jalankan SQL berikut:**
```sql
CREATE USER cloudy_user WITH PASSWORD 'cloudy123';
CREATE DATABASE cloudy_project;
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;
\c cloudy_project
GRANT ALL ON SCHEMA public TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;
```

3. **Update `.env`:**
```env
DB_USERNAME=cloudy_user
DB_PASSWORD=cloudy123
DB_DATABASE=cloudy_project
```

4. **Clear config:**
```bash
php artisan config:clear
php artisan migrate
```

---

## 📋 Checklist Setelah Setup

- [ ] Database connection berhasil (test dengan `php artisan migrate:status`)
- [ ] Migrasi berhasil (`php artisan migrate`)
- [ ] Seeder berhasil (`php artisan db:seed --class=AdminUserSeeder`)
- [ ] Aplikasi bisa diakses (`php artisan serve`)
- [ ] Bisa login dengan:
  - Email: `admin@cloudywear.test`
  - Password: `password123`

---

## 🆘 Masih Error?

### Error: Database does not exist
**Solusi:** Buat database terlebih dahulu
```sql
CREATE DATABASE cloudy_project;
```

### Error: Connection refused
**Solusi:** Pastikan PostgreSQL service berjalan
- Windows: Services → PostgreSQL
- Atau: `pg_isready` di command line

### Error: Permission denied
**Solusi:** Berikan privileges ke user
```sql
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO username;
\c cloudy_project
GRANT ALL ON SCHEMA public TO username;
```

---

## 💡 Rekomendasi

- **Untuk Development:** Gunakan **SQLite** (lebih mudah, tidak perlu setup)
- **Untuk Production:** Gunakan **PostgreSQL** (lebih robust, scalable)

---

## 📁 File-file Bantuan

1. `FIX_PASSWORD.md` - Panduan lengkap perbaikan password PostgreSQL
2. `DATABASE_SETUP.md` - Panduan setup database
3. `setup-database.sql` - Script SQL untuk setup database
4. `switch-to-sqlite.ps1` - Script untuk switch ke SQLite
5. `fix-database.ps1` - Script untuk fix konfigurasi database

---

## ✅ Quick Fix (Paling Cepat)

**Untuk development cepat, gunakan SQLite:**
```powershell
# 1. Switch ke SQLite
(Get-Content .env) -replace 'DB_CONNECTION=pgsql', 'DB_CONNECTION=sqlite' | Set-Content .env

# 2. Clear config
php artisan config:clear

# 3. Buat database file
New-Item -ItemType File -Path database/database.sqlite -Force

# 4. Migrate
php artisan migrate

# 5. Seed
php artisan db:seed --class=AdminUserSeeder

# 6. Test
php artisan serve
```

**Selesai! 🎉**


