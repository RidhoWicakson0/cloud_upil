# ============================
# Stage 1: Build Frontend (Vite)
# ============================
FROM node:20 AS frontend

# Set working directory
WORKDIR /app

# Salin file konfigurasi Vite & package
COPY package*.json vite.config.js ./

# Salin resource frontend Laravel
COPY resources ./resources
COPY public ./public

# Install dependencies dan build
RUN npm install
RUN npm run build


# ============================
# Stage 2: Build Laravel Backend
# ============================
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file Laravel ke container
COPY . .

# Copy hasil build frontend dari tahap pertama
COPY --from=frontend /app/public/build ./public/build

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data storage bootstrap/cache

# Jalankan Laravel dengan built-in server
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
