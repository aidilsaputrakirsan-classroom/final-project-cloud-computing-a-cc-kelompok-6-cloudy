-- ============================================================
-- SETUP SCHEMA PRIVILEGES - WAJIB DIJALANKAN!
-- ============================================================
-- 
-- CARA MENGGUNAKAN:
-- 1. Di pgAdmin, klik kanan pada database "cloudy_project" (di sidebar kiri)
-- 2. Pilih "Query Tool"
-- 3. Copy-paste SEMUA script di bawah ini
-- 4. Klik "Execute" (F5)
-- 5. Pastikan tidak ada error
--
-- PENTING: Script ini HARUS dijalankan SETELAH database dibuat!
-- ============================================================

-- Connect ke database (otomatis jika sudah di Query Tool database cloudy_project)
-- Jika belum connect, uncomment baris di bawah:
-- \c cloudy_project

-- ============================================================
-- BERIKAN PRIVILEGES KE SCHEMA PUBLIC
-- ============================================================
GRANT ALL ON SCHEMA public TO cloudy_user;

-- Set owner schema
ALTER SCHEMA public OWNER TO cloudy_user;

-- ============================================================
-- SET DEFAULT PRIVILEGES
-- ============================================================
ALTER DEFAULT PRIVILEGES IN SCHEMA public 
    GRANT ALL ON TABLES TO cloudy_user;

ALTER DEFAULT PRIVILEGES IN SCHEMA public 
    GRANT ALL ON SEQUENCES TO cloudy_user;

ALTER DEFAULT PRIVILEGES IN SCHEMA public 
    GRANT ALL ON FUNCTIONS TO cloudy_user;

-- ============================================================
-- BERIKAN PRIVILEGES LANGSUNG KE PUBLIC SCHEMA
-- ============================================================
GRANT CREATE ON SCHEMA public TO cloudy_user;
GRANT USAGE ON SCHEMA public TO cloudy_user;

-- ============================================================
-- VERIFIKASI (opsional)
-- ============================================================
SELECT 
    grantee, 
    table_schema, 
    privilege_type 
FROM information_schema.role_table_grants 
WHERE grantee = 'cloudy_user'
LIMIT 10;

-- ============================================================
-- CATATAN: Setelah ini, test koneksi dengan:
-- php artisan migrate:status
-- ============================================================


