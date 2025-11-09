-- ============================================================
-- SCRIPT INI WAJIB DIJALANKAN DI PGADMIN!
-- ============================================================
-- 
-- CARA MENGGUNAKAN:
-- 1. Buka pgAdmin
-- 2. Login ke PostgreSQL server (masukkan password yang Anda tahu)
-- 3. Setelah login berhasil, klik kanan pada "Databases" (di sidebar kiri)
-- 4. Pilih "Query Tool"
-- 5. Copy-paste SEMUA script di bawah ini ke Query Tool
-- 6. Klik tombol "Execute" (atau tekan F5)
-- 7. Pastikan muncul pesan "Success" atau "Query returned successfully"
--
-- PENTING: Jika ada error "already exists", itu normal, lanjutkan saja!
-- ============================================================

-- Hapus user jika sudah ada (opsional, skip jika error)
DROP USER IF EXISTS cloudy_user CASCADE;

-- Hapus database jika sudah ada (opsional, skip jika error)
DROP DATABASE IF EXISTS cloudy_project;

-- ============================================================
-- BUAT USER BARU
-- ============================================================
CREATE USER cloudy_user WITH 
    PASSWORD 'cloudy123'
    CREATEDB
    CREATEROLE;

-- ============================================================
-- BUAT DATABASE
-- ============================================================
CREATE DATABASE cloudy_project
    WITH OWNER = cloudy_user
    ENCODING = 'UTF8'
    LC_COLLATE = 'C'
    LC_CTYPE = 'C'
    TEMPLATE = template0;

-- ============================================================
-- BERIKAN PRIVILEGES
-- ============================================================
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;

-- ============================================================
-- VERIFIKASI (opsional, untuk cek apakah berhasil)
-- ============================================================
SELECT 
    usename as username,
    usesuper as is_superuser
FROM pg_user 
WHERE usename = 'cloudy_user';

SELECT 
    datname as database_name,
    datdba::regrole as owner
FROM pg_database 
WHERE datname = 'cloudy_project';

-- ============================================================
-- SETELAH INI, LANJUTKAN KE SETUP-SCHEMA.sql
-- ============================================================


