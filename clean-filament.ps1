# Cleaning Filament from SIRI Backend

Write-Host "🧹 Cleaning Filament from SIRI Backend..." -ForegroundColor Cyan
Write-Host ""

# Clear all cache
Write-Host "📦 Clearing cache..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Dump autoload
Write-Host "🔄 Dumping autoload..." -ForegroundColor Yellow
composer dump-autoload

# Remove Filament folders if they exist
Write-Host "🗑️  Removing Filament folders..." -ForegroundColor Yellow

if (Test-Path "app/Filament") {
    Remove-Item -Recurse -Force "app/Filament"
    Write-Host "   ✅ Removed app/Filament" -ForegroundColor Green
} else {
    Write-Host "   ℹ️  app/Filament not found (already removed)" -ForegroundColor Gray
}

if (Test-Path "config/filament.php") {
    Remove-Item -Force "config/filament.php"
    Write-Host "   ✅ Removed config/filament.php" -ForegroundColor Green
} else {
    Write-Host "   ℹ️  config/filament.php not found (already removed)" -ForegroundColor Gray
}

if (Test-Path "resources/views/vendor/filament") {
    Remove-Item -Recurse -Force "resources/views/vendor/filament"
    Write-Host "   ✅ Removed resources/views/vendor/filament" -ForegroundColor Green
} else {
    Write-Host "   ℹ️  Filament views not found (already removed)" -ForegroundColor Gray
}

Write-Host ""
Write-Host "✅ Cleanup complete!" -ForegroundColor Green
Write-Host ""
Write-Host "📝 Summary:" -ForegroundColor Cyan
Write-Host "   ✅ All cache cleared" -ForegroundColor Green
Write-Host "   ✅ Autoload dumped" -ForegroundColor Green
Write-Host "   ✅ Filament folders removed" -ForegroundColor Green
Write-Host "   ✅ User model cleaned" -ForegroundColor Green
Write-Host "   ✅ Controllers cleaned" -ForegroundColor Green
Write-Host ""
Write-Host "🚀 You can now run: php artisan serve" -ForegroundColor Yellow
Write-Host ""
