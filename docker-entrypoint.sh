#!/bin/bash

# Ensure vendor exists
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Ensure .env exists
if [ ! -f ".env" ]; then
    echo "⚙️ Copying .env file..."
    cp .env.example .env
fi

# Generate app key if missing
if ! grep -q "APP_KEY=" .env || [ -z "$(grep APP_KEY .env | cut -d '=' -f2)" ]; then
    echo "🔑 Generating Laravel app key..."
    php artisan key:generate
fi

echo "🔧 Fixing Laravel permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;

exec "$@"