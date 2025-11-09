# Script untuk membuat user PostgreSQL baru dengan password yang jelas
# Ini alternatif jika password postgres tidak diketahui

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  BUAT USER POSTGRESQL BARU" -ForegroundColor Yellow
Write-Host "========================================`n" -ForegroundColor Cyan

Write-Host "Script ini akan membantu Anda membuat user PostgreSQL baru." -ForegroundColor Green
Write-Host "User baru akan memiliki password yang jelas dan mudah diingat.`n" -ForegroundColor Green

Write-Host "Langkah-langkah:" -ForegroundColor Yellow
Write-Host "1. Buka pgAdmin" -ForegroundColor White
Write-Host "2. Login ke PostgreSQL server (gunakan password yang Anda tahu)" -ForegroundColor White
Write-Host "3. Buka Query Tool (Tools → Query Tool)" -ForegroundColor White
Write-Host "4. Copy-paste SQL berikut dan jalankan:`n" -ForegroundColor White

$sqlScript = @"
-- Buat user baru dengan password yang jelas
CREATE USER cloudy_user WITH PASSWORD 'cloudy123';

-- Buat database
CREATE DATABASE cloudy_project;

-- Berikan privileges
GRANT ALL PRIVILEGES ON DATABASE cloudy_project TO cloudy_user;

-- Connect ke database dan berikan schema privileges
\c cloudy_project
GRANT ALL ON SCHEMA public TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO cloudy_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO cloudy_user;
"@

Write-Host $sqlScript -ForegroundColor Gray

Write-Host "`n5. Setelah SQL berhasil dijalankan, tekan Enter untuk update .env..." -ForegroundColor Yellow
Read-Host "   (Tekan Enter setelah SQL berhasil dijalankan)"

# Update .env
Write-Host "`nMemperbarui file .env..." -ForegroundColor Green
$envContent = Get-Content .env -Raw
$envContent = $envContent -replace 'DB_USERNAME=postgres', 'DB_USERNAME=cloudy_user'
$envContent = $envContent -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=cloudy123'
$envContent = $envContent -replace 'DB_DATABASE=.*', 'DB_DATABASE=cloudy_project'
$envContent | Set-Content .env -NoNewline

Write-Host "✓ File .env diperbarui!" -ForegroundColor Green
Write-Host "  DB_USERNAME=cloudy_user" -ForegroundColor Gray
Write-Host "  DB_PASSWORD=cloudy123" -ForegroundColor Gray
Write-Host "  DB_DATABASE=cloudy_project" -ForegroundColor Gray

# Clear config
Write-Host "`nMembersihkan config cache..." -ForegroundColor Green
php artisan config:clear 2>&1 | Out-Null

# Test
Write-Host "`nTesting koneksi..." -ForegroundColor Green
$result = php artisan migrate:status 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n========================================" -ForegroundColor Green
    Write-Host "  ✓ BERHASIL! Koneksi database OK" -ForegroundColor Green
    Write-Host "========================================`n" -ForegroundColor Green
    
    Write-Host "Jalankan migrasi:" -ForegroundColor Yellow
    Write-Host "  php artisan migrate" -ForegroundColor White
    Write-Host "  php artisan db:seed --class=AdminUserSeeder" -ForegroundColor White
} else {
    Write-Host "`n========================================" -ForegroundColor Red
    Write-Host "  ✗ Masih error!" -ForegroundColor Red
    Write-Host "========================================`n" -ForegroundColor Red
    Write-Host "Pastikan:" -ForegroundColor Yellow
    Write-Host "1. SQL script di atas sudah berhasil dijalankan di pgAdmin" -ForegroundColor White
    Write-Host "2. Tidak ada error saat menjalankan SQL" -ForegroundColor White
    Write-Host "3. PostgreSQL service sedang berjalan" -ForegroundColor White
}


