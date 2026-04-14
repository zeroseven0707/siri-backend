# SIRI Admin Panel Setup Script (PowerShell)
# This script will remove Filament and setup custom admin panel

Write-Host "🚀 SIRI Admin Panel Setup" -ForegroundColor Cyan
Write-Host "==========================" -ForegroundColor Cyan
Write-Host ""

# Check if composer is installed
if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Composer is not installed. Please install composer first." -ForegroundColor Red
    exit 1
}

# Check if artisan file exists
if (-not (Test-Path "artisan")) {
    Write-Host "❌ artisan file not found. Please run this script from Laravel root directory." -ForegroundColor Red
    exit 1
}

Write-Host "📦 Step 1: Removing Filament..." -ForegroundColor Yellow
composer remove filament/filament --no-interaction

Write-Host ""
Write-Host "🗑️  Step 2: Cleaning up Filament files..." -ForegroundColor Yellow
if (Test-Path "app/Filament") {
    Remove-Item -Recurse -Force "app/Filament"
}
if (Test-Path "config/filament.php") {
    Remove-Item -Force "config/filament.php"
}
if (Test-Path "resources/views/vendor/filament") {
    Remove-Item -Recurse -Force "resources/views/vendor/filament"
}

Write-Host ""
Write-Host "🧹 Step 3: Clearing cache..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

Write-Host ""
Write-Host "✅ Filament removed successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "👤 Step 4: Creating admin user..." -ForegroundColor Yellow
Write-Host ""

# Prompt for admin details
$admin_name = Read-Host "Enter admin name (default: Admin)"
if ([string]::IsNullOrWhiteSpace($admin_name)) { $admin_name = "Admin" }

$admin_email = Read-Host "Enter admin email (default: admin@siri.app)"
if ([string]::IsNullOrWhiteSpace($admin_email)) { $admin_email = "admin@siri.app" }

$admin_password = Read-Host "Enter admin password (default: password)" -AsSecureString
$admin_password_plain = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($admin_password))
if ([string]::IsNullOrWhiteSpace($admin_password_plain)) { $admin_password_plain = "password" }

$admin_phone = Read-Host "Enter admin phone (default: +6281234567890)"
if ([string]::IsNullOrWhiteSpace($admin_phone)) { $admin_phone = "+6281234567890" }

# Create admin user using artisan tinker
$tinkerCommand = @"
\App\Models\User::create([
    'name' => '$admin_name',
    'email' => '$admin_email',
    'password' => bcrypt('$admin_password_plain'),
    'role' => 'admin',
    'phone' => '$admin_phone'
]);
echo 'Admin user created successfully!';
"@

php artisan tinker --execute="$tinkerCommand"

Write-Host ""
Write-Host "✅ Setup completed successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "📝 Admin Panel Details:" -ForegroundColor Cyan
Write-Host "   URL: http://localhost:8000/admin/login" -ForegroundColor White
Write-Host "   Email: $admin_email" -ForegroundColor White
Write-Host "   Password: $admin_password_plain" -ForegroundColor White
Write-Host ""
Write-Host "🚀 Start the server with: php artisan serve" -ForegroundColor Yellow
Write-Host ""
Write-Host "Happy coding! 💖" -ForegroundColor Magenta
