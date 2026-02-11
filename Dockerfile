FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libpq-dev \
    curl \
    nodejs \
    npm \
 && docker-php-ext-install pdo pdo_mysql zip exif pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app files
COPY . /var/www/html

# Ensure permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Install PHP dependencies and build front-end assets
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev || true
RUN npm install --silent || true
RUN npm run build || true

ENV APP_ENV=production

EXPOSE 9000

# Make start script executable (Railway may run `start.sh` from project root)
RUN if [ -f /var/www/html/start.sh ]; then chmod +x /var/www/html/start.sh; fi

# Default command: use start.sh if present, else run php-fpm
CMD ["/bin/bash","-lc","if [ -x /var/www/html/start.sh ]; then /var/www/html/start.sh; else php-fpm; fi"]
