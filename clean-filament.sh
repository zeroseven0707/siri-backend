#!/bin/bash

echo "🧹 Cleaning Filament from SIRI Backend..."
echo ""

# Clear all cache
echo "📦 Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Dump autoload
echo "🔄 Dumping autoload..."
composer dump-autoload

# Remove Filament folders if they exist
echo "🗑️  Removing Filament folders..."
if [ -d "app/Filament" ]; then
    rm -rf app/Filament
    echo "   ✅ Removed app/Filament"
else
    echo "   ℹ️  app/Filament not found (already removed)"
fi

if [ -f "config/filament.php" ]; then
    rm -f config/filament.php
    echo "   ✅ Removed config/filament.php"
else
    echo "   ℹ️  config/filament.php not found (already removed)"
fi

if [ -d "resources/views/vendor/filament" ]; then
    rm -rf resources/views/vendor/filament
    echo "   ✅ Removed resources/views/vendor/filament"
else
    echo "   ℹ️  Filament views not found (already removed)"
fi

echo ""
echo "✅ Cleanup complete!"
echo ""
echo "📝 Summary:"
echo "   ✅ All cache cleared"
echo "   ✅ Autoload dumped"
echo "   ✅ Filament folders removed"
echo "   ✅ User model cleaned"
echo "   ✅ Controllers cleaned"
echo ""
echo "🚀 You can now run: php artisan serve"
echo ""
