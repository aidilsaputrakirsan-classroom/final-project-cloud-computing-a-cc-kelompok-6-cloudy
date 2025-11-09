-- ============================================================
-- COPY PASTE SCRIPT INI KE PGADMIN - PASTI BERHASIL!
-- ============================================================

-- STEP 1: Hapus jika sudah ada (skip jika error)
DROP USER IF EXISTS cloudy_user CASCADE;
DROP DATABASE IF EXISTS cloudy_project;

-- STEP 2: Buat user baru
CREATE USER cloudy_user WITH PASSWORD 'cloudy123';

-- STEP 3: Buat database
CREATE DATABASE cloudy_project OWNER cloudy_user;

-- STEP 4: Berikan semua privileges
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;

-- SELESAI! Lanjut ke script SETUP-SCHEMA-PRIVILEGES.sql


