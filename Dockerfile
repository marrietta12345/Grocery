FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies first for cache efficiency
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# Copy the application source
COPY . .

# Ensure environment fallback and optimized Laravel cache
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate --ansi --force \
    && php artisan route:cache

# Create runtime directories and set permissions
RUN mkdir -p storage bootstrap/cache public/storage \
    && chmod -R 755 storage bootstrap/cache \
    && chown -R www-data:www-data /app

# Configure Apache to serve Laravel
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/laravel.conf && \
    echo 'ServerName localhost' >> /etc/apache2/sites-available/laravel.conf && \
    echo 'DocumentRoot /app/public' >> /etc/apache2/sites-available/laravel.conf && \
    echo '<Directory /app>' >> /etc/apache2/sites-available/laravel.conf && \
    echo 'AllowOverride All' >> /etc/apache2/sites-available/laravel.conf && \
    echo 'Require all granted' >> /etc/apache2/sites-available/laravel.conf && \
    echo '</Directory>' >> /etc/apache2/sites-available/laravel.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/laravel.conf && \
    a2ensite laravel.conf && a2dissite 000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
