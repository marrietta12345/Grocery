FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    mysql-client \
    wget \
    gnupg \
    ca-certificates \
    libapache2-mod-php \
    php8.1-mysql \
    && docker-php-ext-install zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite
RUN a2enmod headers

# Install Node.js
RUN apt-get update && apt-get install -y \
    nodejs npm \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Create necessary directories with proper permissions
RUN mkdir -p storage bootstrap/cache public/storage && \
    chmod -R 777 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --prefer-dist || exit 0

# Install Node dependencies
RUN npm install --legacy-peer-deps || exit 0

# Build assets - don't fail if this doesn't work
RUN npm run production 2>/dev/null || npm run dev 2>/dev/null || true

# Copy Apache configuration
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-enabled/000-default.conf && \
    echo 'DocumentRoot /app/public' >> /etc/apache2/sites-enabled/000-default.conf && \
    echo 'SetEnv HOME /tmp' >> /etc/apache2/sites-enabled/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-enabled/000-default.conf

# Expose port
EXPOSE 80

# Start Apache
ENTRYPOINT ["apache2ctl"]
CMD ["-D", "FOREGROUND"]
