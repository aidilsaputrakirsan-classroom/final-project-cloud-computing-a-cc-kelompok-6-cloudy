-- Script untuk setup database PostgreSQL
-- Jalankan script ini di pgAdmin atau psql

-- 1. Buat database (jika belum ada)
CREATE DATABASE laravel_db;

-- 2. Buat user (jika belum ada)
CREATE USER laravel_user WITH PASSWORD 'laravel_pass';

-- 3. Berikan privileges kepada user
GRANT ALL PRIVILEGES ON DATABASE laravel_db TO laravel_user;

-- 4. Connect ke database dan berikan schema privileges
\c laravel_db
GRANT ALL ON SCHEMA public TO laravel_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO laravel_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO laravel_user;

-- Jika user sudah ada, gunakan perintah ini untuk reset password:
-- ALTER USER laravel_user WITH PASSWORD 'laravel_pass';


