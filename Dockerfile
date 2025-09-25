FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel source code
COPY . .

# Copy wait script and make it executable
COPY wait-for-app.sh /wait-for-app.sh
RUN chmod +x /wait-for-app.sh

# Trust the repo directory (fixes Git ownership warning)
RUN git config --global --add safe.directory /var/www/html

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ensure correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate Laravel app key if not already set
RUN php artisan key:generate || echo "App key already set"

# Optional: create storage symlink for public access
RUN php artisan storage:link || echo "Storage link already exists"

# Optional: run migrations (can also be done via post-deploy script)
# RUN php artisan migrate --force || echo "Migration skipped"

# Start PHP-FPM
CMD ["php-fpm"]