# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copy semua file project ke dalam container
COPY . /var/www/html

# Set direktori kerja
WORKDIR /var/www/html

# Set permission agar Laravel bisa nulis ke storage
RUN chmod -R 777 storage bootstrap/cache

# Install composer (kalau belum ada di image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Jalankan composer install (tanpa dev dependencies)
RUN composer install --no-dev --optimize-autoloader

# Jalankan artisan key:generate
RUN php artisan key:generate

# Expose port 80 untuk web server
EXPOSE 80

# Jalankan Laravel pakai built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
