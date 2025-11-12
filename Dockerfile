FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \                     # ✅ PostgreSQL support
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \                # ✅ PostgreSQL PDO extension
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Ensure Git safe directory for Laravel
RUN git config --global --add safe.directory /var/www/html

# Copy project files
COPY . .

# Laravel setup during build (optional)
RUN mkdir -p vendor \
    && composer install --no-interaction --prefer-dist --optimize-autoloader \
    && cp .env.example .env \
    && echo "✅ Laravel setup complete." \
    || (echo "❌ Laravel setup failed. Check Composer or Artisan output." && exit 1)

# Copy runtime entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Use entrypoint to fix permissions at runtime
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]