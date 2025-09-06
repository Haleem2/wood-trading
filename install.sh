#!/bin/bash

# Wood Trading Application Installation Script

echo "🌲 Wood Trading Application Installation Script"
echo "=============================================="

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.3 or higher."
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "✅ PHP version: $PHP_VERSION"

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install NPM dependencies (if Node.js is available)
if command -v npm &> /dev/null; then
    echo "📦 Installing NPM dependencies..."
    npm install
    npm run production
else
    echo "⚠️  Node.js/NPM not found. Skipping frontend asset compilation."
fi

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    echo "⚠️  Please update your .env file with your database credentials and other settings."
fi

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Run seeders
echo "🌱 Seeding database with sample data..."
php artisan db:seed --force

# Generate API documentation
echo "📚 Generating API documentation..."
php artisan l5-swagger:generate

# Set permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear caches
echo "🧹 Clearing application caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "🎉 Installation completed successfully!"
echo ""
echo "Next steps:"
echo "1. Update your .env file with your database credentials"
echo "2. Configure your web server to point to the public directory"
echo "3. Visit http://your-domain/api/documentation for API documentation"
echo ""
echo "Default users:"
echo "- Owner/Admin: admin@woodtrading.com / password"
echo "- Salesperson: sarah@woodtrading.com / password"
echo "- Storekeeper: mike@woodtrading.com / password"
echo "- Accountant: lisa@woodtrading.com / password"
echo ""
echo "Happy trading! 🌲"
