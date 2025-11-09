# Script untuk switch ke SQLite (lebih mudah untuk development)
# SQLite tidak memerlukan setup database server

Write-Host "Mengubah konfigurasi database ke SQLite..." -ForegroundColor Yellow

# Backup .env
Copy-Item .env .env.backup-pgsql -ErrorAction SilentlyContinue

# Baca konten .env
$envContent = Get-Content .env -Raw

# Update ke SQLite
$envContent = $envContent -replace 'DB_CONNECTION=pgsql', 'DB_CONNECTION=sqlite'
# Comment out PostgreSQL settings (optional, Laravel akan ignore jika connection=sqlite)
$envContent = $envContent -replace 'DB_HOST=127.0.0.1', '#DB_HOST=127.0.0.1'
$envContent = $envContent -replace 'DB_PORT=5432', '#DB_PORT=5432'
$envContent = $envContent -replace 'DB_DATABASE=cloudy_project', '#DB_DATABASE=cloudy_project'
$envContent = $envContent -replace 'DB_USERNAME=postgres', '#DB_USERNAME=postgres'
$envContent = $envContent -replace 'DB_PASSWORD=postgres', '#DB_PASSWORD=postgres'

# Simpan
$envContent | Set-Content .env -NoNewline

Write-Host "`nKonfigurasi telah diubah ke SQLite!" -ForegroundColor Green
Write-Host "`nLangkah selanjutnya:" -ForegroundColor Cyan
Write-Host "1. php artisan config:clear" -ForegroundColor White
Write-Host "2. New-Item -ItemType File -Path database/database.sqlite -Force" -ForegroundColor White
Write-Host "3. php artisan migrate" -ForegroundColor White
Write-Host "4. php artisan db:seed --class=AdminUserSeeder" -ForegroundColor White
Write-Host "`nCatatan: Backup .env tersimpan sebagai .env.backup-pgsql" -ForegroundColor Yellow

