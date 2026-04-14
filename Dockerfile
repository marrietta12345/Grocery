FROM php:8.1-alpine

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN apk add --no-cache nodejs npm

WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build
RUN npm install --legacy-peer-deps && npm run production || echo "Asset build failed, continuing..."

# Set permissions
RUN chown -R nobody:nobody /app && chmod -R 755 /app/storage /app/bootstrap/cache

# Generate app key
RUN php artisan key:generate || true

# Expose port
EXPOSE 8080

# Start PHP server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public/"]
