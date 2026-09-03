# NEW: Dockerfile untuk deploy KapanRich ke Render.com
# Base image: PHP 8.3 dengan FPM (sesuai composer.json: "php": "^8.3")

# ---- Stage 1: Build frontend assets (Vite/Tailwind) ----
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Stage 2: PHP application ----
FROM php:8.3-fpm AS php-app

# Install system dependencies & PHP extensions yang dibutuhkan Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files dulu supaya layer caching lebih efisien
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy seluruh source code
COPY . .

# Copy hasil build assets dari stage node-builder
COPY --from=node-builder /app/public/build ./public/build

# Jalankan post-install scripts composer (discover packages, dsb)
RUN composer run-script post-autoload-dump

# Set permission untuk storage & bootstrap/cache (wajib writable oleh Laravel)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy konfigurasi Nginx & Supervisor
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]
