FROM php:8.1-bullseye

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    mariadb-client \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies
RUN npm install --legacy-peer-deps

# Build assets
RUN npm run production 2>/dev/null || true

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Start PHP server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public/"]
