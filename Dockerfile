# Gunakan image PHP dengan ekstensi yang diperlukan
FROM php:8.2-fpm

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Node.js (untuk build Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy file composer dan install dependensi PHP
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install --no-dev --optimize-autoloader

# Copy seluruh project
COPY . .

# Build aset frontend menggunakan Vite
RUN npm install && npm run build

# Pastikan direktori storage dan bootstrap/cache bisa ditulis
RUN chmod -R 777 storage bootstrap/cache

# Jalankan aplikasi Laravel
CMD php artisan serve --host=0.0.0.0 --port=80
