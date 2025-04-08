FROM php:8.2-apache

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Configure Apache
RUN a2enmod rewrite
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Copy app files
COPY . .

# Install Composer (skip jika sudah include vendor)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Gunakan PORT dari env variable Railway
ENV PORT=8080
EXPOSE $PORT

# Gunakan Apache sebagai web server (lebih stabil)
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    docker-php-entrypoint apache2-foreground