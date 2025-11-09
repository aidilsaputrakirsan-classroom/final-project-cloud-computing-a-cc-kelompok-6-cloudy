# Script untuk switch ke SQLite (paling mudah, tidak perlu setup database server)
Write-Host "`n=== SWITCH KE SQLITE ===" -ForegroundColor Cyan
Write-Host "SQLite tidak memerlukan setup database server!`n" -ForegroundColor Green

# Backup .env
Copy-Item .env .env.backup-pgsql-$(Get-Date -Format 'yyyyMMdd-HHmmss') -ErrorAction SilentlyContinue
Write-Host "Backup .env dibuat" -ForegroundColor Gray

# Update .env
$envContent = Get-Content .env -Raw
$envContent = $envContent -replace 'DB_CONNECTION=pgsql', 'DB_CONNECTION=sqlite'
# Comment PostgreSQL settings
$envContent = $envContent -replace 'DB_HOST=127.0.0.1', '#DB_HOST=127.0.0.1'
$envContent = $envContent -replace 'DB_PORT=5432', '#DB_PORT=5432'
$envContent = $envContent -replace 'DB_DATABASE=cloudy_project', '#DB_DATABASE=cloudy_project'
$envContent = $envContent -replace 'DB_USERNAME=cloudy_user', '#DB_USERNAME=cloudy_user'
$envContent = $envContent -replace 'DB_PASSWORD=cloudy123', '#DB_PASSWORD=cloudy123'
$envContent | Set-Content .env -NoNewline

Write-Host "✓ File .env telah diupdate ke SQLite" -ForegroundColor Green

# Clear config
Write-Host "`nClearing config cache..." -ForegroundColor Yellow
php artisan config:clear 2>&1 | Out-Null

# Buat database file
Write-Host "Creating database file..." -ForegroundColor Yellow
if (Test-Path "database/database.sqlite") {
    Write-Host "Database file sudah ada" -ForegroundColor Gray
} else {
    New-Item -ItemType File -Path "database/database.sqlite" -Force | Out-Null
    Write-Host "✓ Database file dibuat" -ForegroundColor Green
}

# Test koneksi
Write-Host "`nTesting koneksi..." -ForegroundColor Yellow
$result = php artisan migrate:status 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n=== BERHASIL! Koneksi SQLite OK ===" -ForegroundColor Green
    Write-Host "`nLangkah selanjutnya:" -ForegroundColor Yellow
    Write-Host "  php artisan migrate" -ForegroundColor White
    Write-Host "  php artisan db:seed --class=AdminUserSeeder" -ForegroundColor White
    Write-Host "  php artisan serve" -ForegroundColor White
    Write-Host "`nLogin dengan: admin@cloudywear.test / password123" -ForegroundColor Cyan
} else {
    Write-Host "`n=== ERROR ===" -ForegroundColor Red
    Write-Host $result -ForegroundColor Yellow
}

Write-Host "`n"

