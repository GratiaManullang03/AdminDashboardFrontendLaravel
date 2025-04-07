# Stage 1: Build Composer dependencies
FROM composer:2.6 as vendor

WORKDIR /app

COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Build Node dependencies (if needed)
FROM node:18 as frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm install

COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

# Stage 3: Application image
FROM php:8.2-apache

WORKDIR /var/www/html

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip mbstring exif pcntl bcmath opcache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application files
COPY . .
COPY --from=vendor /app/vendor/ vendor/
COPY --from=frontend /app/public/build/ public/build/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Expose port (Railway will override this with $PORT)
EXPOSE 8080

# Start command (Railway will override this with your startCommand)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]