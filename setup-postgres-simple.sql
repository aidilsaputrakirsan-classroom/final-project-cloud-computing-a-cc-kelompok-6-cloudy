-- ============================================
-- SETUP POSTGRESQL UNTUK PROYEK CLOUDY
-- ============================================
-- Copy-paste script ini ke pgAdmin Query Tool dan jalankan
-- Pastikan Anda sudah login ke PostgreSQL server

-- 1. Buat user baru dengan password yang jelas
CREATE USER IF NOT EXISTS cloudy_user WITH PASSWORD 'cloudy123';

-- 2. Buat database
CREATE DATABASE IF NOT EXISTS cloudy_project;

-- 3. Berikan semua privileges ke user
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;

-- 4. Connect ke database (jalankan ini secara terpisah setelah connect ke cloudy_project)
-- \c cloudy_project
-- GRANT ALL ON SCHEMA public TO cloudy_user;
-- ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;
-- ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;

-- CATATAN: Setelah menjalankan script ini:
-- 1. Connect ke database cloudy_project di pgAdmin
-- 2. Jalankan perintah GRANT di atas (yang di-comment) di Query Tool
-- 3. Atau jalankan script setup-postgres-schema.sql


