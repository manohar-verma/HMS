FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Ensure Git safe directory for Laravel
RUN git config --global --add safe.directory /var/www/html

# Copy project files
COPY . .

# Force vendor folder creation and Laravel bootstrapping
RUN mkdir -p vendor \
    && composer install --no-interaction --prefer-dist --optimize-autoloader || echo "Composer install failed, vendor folder may be incomplete" \
    && cp .env.example .env \
    && php artisan key:generate || echo "Artisan key generation failed"

# Set strict permissions for Laravel runtime
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && find /var/www/html/storage -type f -exec chmod 644 {} \; \
    && find /var/www/html/bootstrap/cache -type f -exec chmod 644 {} \;