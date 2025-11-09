# Script Setup PostgreSQL untuk Proyek Cloudy
# Pastikan PostgreSQL sudah terinstall dan service berjalan

Write-Host "`n=== SETUP POSTGRESQL UNTUK PROYEK CLOUDY ===" -ForegroundColor Cyan
Write-Host "`nLangkah-langkah:" -ForegroundColor Yellow

Write-Host "`n1. PASTIKAN PASSWORD POSTGRESQL ANDA" -ForegroundColor Green
Write-Host "   Masukkan password user 'postgres' di PostgreSQL Anda:" -ForegroundColor White
$password = Read-Host "   Password PostgreSQL (tekan Enter jika kosong)"

if ([string]::IsNullOrWhiteSpace($password)) {
    $password = ""
    Write-Host "   Menggunakan password kosong" -ForegroundColor Yellow
} else {
    Write-Host "   Password akan diupdate" -ForegroundColor Green
}

Write-Host "`n2. UPDATE FILE .ENV" -ForegroundColor Green
# Backup .env
Copy-Item .env .env.backup -ErrorAction SilentlyContinue
Write-Host "   Backup .env dibuat: .env.backup" -ForegroundColor Gray

# Update .env
$envContent = Get-Content .env -Raw
$envContent = $envContent -replace 'DB_PASSWORD=postgres', "DB_PASSWORD=$password"
$envContent | Set-Content .env -NoNewline

Write-Host "   File .env telah diperbarui!" -ForegroundColor Green

Write-Host "`n3. CLEAR CONFIG CACHE" -ForegroundColor Green
php artisan config:clear
Write-Host "   Config cache cleared!" -ForegroundColor Green

Write-Host "`n4. TEST KONEKSI DATABASE" -ForegroundColor Green
Write-Host "   Testing connection..." -ForegroundColor White

# Test koneksi
$testResult = php artisan migrate:status 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "   ✓ Koneksi database berhasil!" -ForegroundColor Green
    Write-Host "`n5. JALANKAN MIGRASI" -ForegroundColor Green
    Write-Host "   Running migrations..." -ForegroundColor White
    php artisan migrate
    Write-Host "   ✓ Migrasi selesai!" -ForegroundColor Green
    
    Write-Host "`n6. SEED DATABASE" -ForegroundColor Green
    Write-Host "   Seeding admin user..." -ForegroundColor White
    php artisan db:seed --class=AdminUserSeeder
    Write-Host "   ✓ Seeder selesai!" -ForegroundColor Green
    
    Write-Host "`n=== SETUP SELESAI ===" -ForegroundColor Green
    Write-Host "`nLogin dengan:" -ForegroundColor Cyan
    Write-Host "   Email: admin@cloudywear.test" -ForegroundColor White
    Write-Host "   Password: password123" -ForegroundColor White
    Write-Host "`nJalankan: php artisan serve" -ForegroundColor Yellow
} else {
    Write-Host "   ✗ Koneksi database gagal!" -ForegroundColor Red
    Write-Host "`nTROUBLESHOOTING:" -ForegroundColor Yellow
    Write-Host "   1. Pastikan PostgreSQL service berjalan" -ForegroundColor White
    Write-Host "   2. Pastikan database 'cloudy_project' sudah dibuat:" -ForegroundColor White
    Write-Host "      CREATE DATABASE cloudy_project;" -ForegroundColor Gray
    Write-Host "   3. Pastikan password PostgreSQL benar" -ForegroundColor White
    Write-Host "   4. Cek koneksi di pgAdmin terlebih dahulu" -ForegroundColor White
    Write-Host "`nLihat file SOLUSI_ERROR_DATABASE.md untuk bantuan lebih lanjut" -ForegroundColor Cyan
}


