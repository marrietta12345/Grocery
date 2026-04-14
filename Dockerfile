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

# Set workdir
WORKDIR /app

# Copy files
COPY . .

# Create directories
RUN mkdir -p storage bootstrap/cache public/storage

# Set permissions
RUN chmod -R 755 storage bootstrap/cache && chown -R www-data:www-data /app

# Install PHP dependencies only (skip NPM build)
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# Run post-install scripts
RUN composer run-script post-install-cmd

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

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
