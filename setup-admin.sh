#!/bin/bash

# SIRI Admin Panel Setup Script
# This script will remove Filament and setup custom admin panel

echo "🚀 SIRI Admin Panel Setup"
echo "=========================="
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install composer first."
    exit 1
fi

# Check if php artisan is available
if [ ! -f "artisan" ]; then
    echo "❌ artisan file not found. Please run this script from Laravel root directory."
    exit 1
fi

echo "📦 Step 1: Removing Filament..."
composer remove filament/filament --no-interaction

echo ""
echo "🗑️  Step 2: Cleaning up Filament files..."
rm -rf app/Filament
rm -f config/filament.php
rm -rf resources/views/vendor/filament

echo ""
echo "🧹 Step 3: Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

echo ""
echo "✅ Filament removed successfully!"
echo ""
echo "👤 Step 4: Creating admin user..."
echo ""

# Prompt for admin details
read -p "Enter admin name (default: Admin): " admin_name
admin_name=${admin_name:-Admin}

read -p "Enter admin email (default: admin@siri.app): " admin_email
admin_email=${admin_email:-admin@siri.app}

read -sp "Enter admin password (default: password): " admin_password
echo ""
admin_password=${admin_password:-password}

read -p "Enter admin phone (default: +6281234567890): " admin_phone
admin_phone=${admin_phone:-+6281234567890}

# Create admin user using artisan tinker
php artisan tinker --execute="
\App\Models\User::create([
    'name' => '$admin_name',
    'email' => '$admin_email',
    'password' => bcrypt('$admin_password'),
    'role' => 'admin',
    'phone' => '$admin_phone'
]);
echo 'Admin user created successfully!';
"

echo ""
echo "✅ Setup completed successfully!"
echo ""
echo "📝 Admin Panel Details:"
echo "   URL: http://localhost:8000/admin/login"
echo "   Email: $admin_email"
echo "   Password: $admin_password"
echo ""
echo "🚀 Start the server with: php artisan serve"
echo ""
echo "Happy coding! 💖"
