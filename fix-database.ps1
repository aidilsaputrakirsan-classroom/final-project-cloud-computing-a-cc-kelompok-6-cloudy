# Script untuk memperbaiki konfigurasi database
# Opsi 1: Gunakan user postgres default (disarankan)

Write-Host "Memperbarui konfigurasi database di .env..." -ForegroundColor Yellow

# Backup .env
Copy-Item .env .env.backup -ErrorAction SilentlyContinue
Write-Host "Backup .env dibuat: .env.backup" -ForegroundColor Green

# Baca konten .env
$envContent = Get-Content .env -Raw

# Update database configuration untuk menggunakan postgres user
$envContent = $envContent -replace 'DB_USERNAME=laravel_user', 'DB_USERNAME=postgres'
$envContent = $envContent -replace 'DB_PASSWORD=laravel_pass', 'DB_PASSWORD=postgres'
$envContent = $envContent -replace 'DB_DATABASE=laravel_db', 'DB_DATABASE=cloudy_project'

# Simpan kembali
$envContent | Set-Content .env -NoNewline

Write-Host "`nKonfigurasi database telah diperbarui:" -ForegroundColor Green
Write-Host "DB_USERNAME=postgres" -ForegroundColor Cyan
Write-Host "DB_PASSWORD=postgres" -ForegroundColor Cyan
Write-Host "DB_DATABASE=cloudy_project" -ForegroundColor Cyan
Write-Host "`nCATATAN:" -ForegroundColor Yellow
Write-Host "1. Pastikan password PostgreSQL user 'postgres' adalah 'postgres'" -ForegroundColor White
Write-Host "2. Jika password berbeda, update DB_PASSWORD di .env secara manual" -ForegroundColor White
Write-Host "3. Pastikan database 'cloudy_project' sudah dibuat di PostgreSQL" -ForegroundColor White
Write-Host "4. Jika belum ada, buat database dengan: CREATE DATABASE cloudy_project;" -ForegroundColor White
Write-Host "`nJalankan: php artisan config:clear" -ForegroundColor Yellow
Write-Host "Kemudian: php artisan migrate" -ForegroundColor Yellow


