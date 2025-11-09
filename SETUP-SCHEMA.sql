-- ========================================
-- SETUP SCHEMA PRIVILEGES
-- ========================================
-- 
-- JALANKAN SCRIPT INI SETELAH:
-- 1. Database "cloudy_project" sudah dibuat
-- 2. User "cloudy_user" sudah dibuat
-- 
-- CARA:
-- 1. Di pgAdmin, klik kanan database "cloudy_project"
-- 2. Pilih "Query Tool"
-- 3. Copy-paste script ini
-- 4. Klik Execute (F5)

-- Berikan privileges ke schema
GRANT ALL ON SCHEMA public TO cloudy_user;

-- Set default privileges untuk tabel
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;

-- Set default privileges untuk sequences
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;

-- Set default privileges untuk functions
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON FUNCTIONS TO cloudy_user;

-- Set owner schema
ALTER SCHEMA public OWNER TO cloudy_user;

-- Verify privileges
SELECT 
    grantee, 
    table_schema, 
    privilege_type 
FROM information_schema.role_table_grants 
WHERE grantee = 'cloudy_user';


