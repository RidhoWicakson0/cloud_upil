# Stage 1: Build frontend
FROM node:18 AS build-frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm install
RUN npm run build

# Stage 2: Setup PHP and Laravel
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip libpng-dev libonig-dev libxml2-dev libzip-dev curl && \
    docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
WORKDIR /var/www/html
COPY . .

# Copy built assets from Node stage
COPY --from=build-frontend /app/public/build ./public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key and cache config
RUN php artisan key:generate
RUN php artisan config:cache

EXPOSE 80
CMD php artisan serve --host=0.0.0.0 --port=80
