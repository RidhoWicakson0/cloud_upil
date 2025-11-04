FROM php:8.2-apache

# Install dependencies Laravel yang umum
RUN apt-get update && apt-get install -y \
    zip unzip git libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy file project
COPY . /var/www/html

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Jalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
