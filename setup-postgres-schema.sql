-- ============================================
-- SETUP SCHEMA PRIVILEGES
-- ============================================
-- Jalankan script ini SETELAH connect ke database cloudy_project
-- Di pgAdmin: Klik kanan database cloudy_project → Query Tool → Paste script ini → Execute

-- Berikan privileges ke schema public
GRANT ALL ON SCHEMA public TO cloudy_user;

-- Set default privileges untuk tabel
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;

-- Set default privileges untuk sequences
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;

-- Set default privileges untuk functions (opsional)
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON FUNCTIONS TO cloudy_user;

-- Verify privileges
SELECT * FROM information_schema.role_table_grants WHERE grantee = 'cloudy_user';


