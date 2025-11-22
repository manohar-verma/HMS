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

# 🔐 Fix Traefik certificate file permissions (host side)
if [ -f "./dynamic/acme.json" ]; then
    echo "🔐 Securing Traefik acme.json on host..."
    chmod 600 ./dynamic/acme.json
    # Also fix inside the running Traefik container if it exists
    if docker ps --format '{{.Names}}' | grep -q '^dokploy-traefik$'; then
        echo "🔐 Securing Traefik acme.json inside container..."
        docker exec -it dokploy-traefik chmod 600 /etc/traefik/dynamic/acme.json
    fi
fi

exec "$@"