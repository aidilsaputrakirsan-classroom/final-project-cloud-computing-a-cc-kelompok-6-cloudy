# Script untuk fix error PostgreSQL secara langsung
# Script ini akan membantu setup PostgreSQL dengan benar

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  FIX POSTGRESQL ERROR - STEP BY STEP" -ForegroundColor Yellow
Write-Host "========================================`n" -ForegroundColor Cyan

# Step 1: Cek konfigurasi saat ini
Write-Host "[1/5] Memeriksa konfigurasi database saat ini..." -ForegroundColor Green
$dbConfig = Get-Content .env | Select-String -Pattern "DB_"
Write-Host $dbConfig -ForegroundColor Gray

# Step 2: Minta input password PostgreSQL
Write-Host "`n[2/5] Masukkan password PostgreSQL user 'postgres':" -ForegroundColor Green
Write-Host "   (Tekan Enter jika password kosong, atau ketik password kemudian Enter)" -ForegroundColor Yellow
$securePassword = Read-Host "   Password" -AsSecureString
$password = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($securePassword))

if ([string]::IsNullOrWhiteSpace($password)) {
    $password = ""
    Write-Host "   Menggunakan password kosong" -ForegroundColor Yellow
} else {
    Write-Host "   Password diterima!" -ForegroundColor Green
}

# Step 3: Update .env
Write-Host "`n[3/5] Memperbarui file .env..." -ForegroundColor Green
Copy-Item .env .env.backup-$(Get-Date -Format 'yyyyMMdd-HHmmss') -ErrorAction SilentlyContinue
Write-Host "   Backup dibuat: .env.backup-*" -ForegroundColor Gray

$envContent = Get-Content .env -Raw
$envContent = $envContent -replace 'DB_PASSWORD=.*', "DB_PASSWORD=$password"
$envContent | Set-Content .env -NoNewline
Write-Host "   File .env diperbarui!" -ForegroundColor Green

# Step 4: Clear config
Write-Host "`n[4/5] Membersihkan config cache..." -ForegroundColor Green
php artisan config:clear 2>&1 | Out-Null
Write-Host "   Config cache cleared!" -ForegroundColor Green

# Step 5: Test koneksi
Write-Host "`n[5/5] Testing koneksi database..." -ForegroundColor Green
Write-Host "   Menjalankan: php artisan migrate:status" -ForegroundColor Gray
$result = php artisan migrate:status 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n========================================" -ForegroundColor Green
    Write-Host "  ✓ KONEKSI DATABASE BERHASIL!" -ForegroundColor Green
    Write-Host "========================================`n" -ForegroundColor Green
    
    Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
    Write-Host "1. php artisan migrate" -ForegroundColor White
    Write-Host "2. php artisan db:seed --class=AdminUserSeeder" -ForegroundColor White
    Write-Host "3. php artisan serve" -ForegroundColor White
    Write-Host "`nLogin dengan: admin@cloudywear.test / password123" -ForegroundColor Cyan
} else {
    Write-Host "`n========================================" -ForegroundColor Red
    Write-Host "  ✗ KONEKSI DATABASE GAGAL!" -ForegroundColor Red
    Write-Host "========================================`n" -ForegroundColor Red
    
    Write-Host "Kemungkinan penyebab:" -ForegroundColor Yellow
    Write-Host "1. Password PostgreSQL salah" -ForegroundColor White
    Write-Host "2. Database 'cloudy_project' belum dibuat" -ForegroundColor White
    Write-Host "3. PostgreSQL service tidak berjalan" -ForegroundColor White
    Write-Host "4. User 'postgres' tidak memiliki akses" -ForegroundColor White
    
    Write-Host "`nSolusi alternatif:" -ForegroundColor Yellow
    Write-Host "1. Buat database di pgAdmin: CREATE DATABASE cloudy_project;" -ForegroundColor White
    Write-Host "2. Atau buat user baru dengan password yang jelas (lihat solusi di bawah)" -ForegroundColor White
    Write-Host "`nJalankan script: .\create-postgres-user.ps1" -ForegroundColor Cyan
}


