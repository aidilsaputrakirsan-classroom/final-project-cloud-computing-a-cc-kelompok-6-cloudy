# Script untuk test koneksi database
Write-Host "`n=== TEST KONEKSI DATABASE ===" -ForegroundColor Cyan

Write-Host "`n1. Memeriksa konfigurasi .env..." -ForegroundColor Yellow
Get-Content .env | Select-String -Pattern "DB_"

Write-Host "`n2. Clearing config cache..." -ForegroundColor Yellow
php artisan config:clear 2>&1 | Out-Null

Write-Host "`n3. Testing koneksi database..." -ForegroundColor Yellow
$result = php artisan migrate:status 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n=== BERHASIL! Koneksi database OK ===" -ForegroundColor Green
    Write-Host "`nLangkah selanjutnya:" -ForegroundColor Yellow
    Write-Host "  php artisan migrate" -ForegroundColor White
    Write-Host "  php artisan db:seed --class=AdminUserSeeder" -ForegroundColor White
    Write-Host "  php artisan serve" -ForegroundColor White
} else {
    Write-Host "`n=== ERROR! Koneksi database GAGAL ===" -ForegroundColor Red
    Write-Host "`nPenyebab kemungkinan:" -ForegroundColor Yellow
    Write-Host "  1. User 'cloudy_user' belum dibuat di PostgreSQL" -ForegroundColor White
    Write-Host "  2. Database 'cloudy_project' belum dibuat" -ForegroundColor White
    Write-Host "  3. Password tidak sesuai" -ForegroundColor White
    Write-Host "  4. PostgreSQL service tidak berjalan" -ForegroundColor White
    Write-Host "`nSOLUSI:" -ForegroundColor Yellow
    Write-Host "  1. Buka pgAdmin" -ForegroundColor White
    Write-Host "  2. Login ke PostgreSQL" -ForegroundColor White
    Write-Host "  3. Klik kanan 'Databases' -> Query Tool" -ForegroundColor White
    Write-Host "  4. Copy-paste file FIX-SEKARANG.sql dan jalankan" -ForegroundColor White
    Write-Host "  5. Connect ke database 'cloudy_project'" -ForegroundColor White
    Write-Host "  6. Copy-paste file SETUP-SCHEMA-PRIVILEGES.sql dan jalankan" -ForegroundColor White
    Write-Host "`nAtau lihat file: CARA-FIX-ERROR-LENGKAP.md" -ForegroundColor Cyan
}

Write-Host "`n"


