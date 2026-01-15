FROM php:8.2-fpm

# Set memory limit
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel source code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permission for Laravel
RUN chmod -R 775 storage bootstrap/cache

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
# Expose port
EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]



