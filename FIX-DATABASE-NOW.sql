-- ========================================
-- COPY PASTE SCRIPT INI KE PGADMIN
-- ========================================
-- 
-- CARA MENGGUNAKAN:
-- 1. Buka pgAdmin
-- 2. Login ke PostgreSQL (gunakan password yang Anda tahu)
-- 3. Klik kanan pada "Databases" → "Query Tool"
-- 4. Copy-paste script ini
-- 5. Klik Execute (F5)
-- 6. Setelah selesai, connect ke database "cloudy_project"
-- 7. Jalankan script di bagian bawah (SETUP SCHEMA)

-- ========================================
-- STEP 1: BUAT USER DAN DATABASE
-- ========================================

-- Hapus user jika sudah ada (opsional, skip jika error)
-- DROP USER IF EXISTS cloudy_user CASCADE;

-- Hapus database jika sudah ada (opsional, skip jika error)
-- DROP DATABASE IF EXISTS cloudy_project;

-- Buat user baru
CREATE USER cloudy_user WITH PASSWORD 'cloudy123';

-- Buat database
CREATE DATABASE cloudy_project OWNER cloudy_user;

-- Berikan privileges
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;

-- ========================================
-- STEP 2: SETUP SCHEMA (JALANKAN SETELAH CONNECT KE DATABASE cloudy_project)
-- ========================================
-- 
-- SETELAH STEP 1 SELESAI:
-- 1. Di pgAdmin, klik kanan database "cloudy_project"
-- 2. Pilih "Query Tool"
-- 3. Copy-paste script di bawah ini dan jalankan:

/*
-- Connect ke database (otomatis jika sudah di Query Tool database cloudy_project)
-- \c cloudy_project

-- Berikan privileges ke schema
GRANT ALL ON SCHEMA public TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON FUNCTIONS TO cloudy_user;

-- Set owner schema ke user
ALTER SCHEMA public OWNER TO cloudy_user;

-- Verify
SELECT * FROM information_schema.role_table_grants WHERE grantee = 'cloudy_user';
*/


