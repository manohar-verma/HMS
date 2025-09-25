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

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel source code
COPY . .

# Ensure Composer is executable
RUN chmod +x /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Trust the repo directory (fixes Git ownership warning)
RUN git config --global --add safe.directory /var/www/html

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Generate Laravel app key if not already set
RUN php artisan key:generate || echo "App key already set"

# Create storage symlink
RUN php artisan storage:link || echo "Storage link already exists"

# Optional: run migrations (can be triggered externally)
# RUN php artisan migrate --force || echo "Migration skipped"

# Start PHP-FPM
CMD ["php-fpm"]
