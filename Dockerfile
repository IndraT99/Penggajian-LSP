# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install dependencies sistem yang diperlukan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Aktifkan Apache mod_rewrite
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# PERBAIKAN DI SINI: Kita hanya ubah sites-available dan apache2.conf utama
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy file composer dari image composer resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy seluruh file project ke dalam container
COPY . /var/www/html

# Install dependensi via Composer
RUN composer install --no-dev --optimize-autoloader

# Ubah permission folder storage dan bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]