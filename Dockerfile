FROM php:8.1-fpm

USER root

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
    && docker-php-ext-install zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js using NodeSource repository
RUN mkdir -p /etc/apt/keyrings && \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_16.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list && \
    apt-get update && apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Create necessary directories
RUN mkdir -p storage bootstrap/cache public/storage && \
    chmod -R 755 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --prefer-dist

# Install Node dependencies and build assets
RUN npm install --legacy-peer-deps && npm run production || npm run dev || echo "Asset build skipped"

# Generate APP_KEY if not set
RUN touch .env && \
    if ! grep -q "APP_KEY=base64" .env; then php artisan key:generate --force; fi

# Expose port
EXPOSE 8080

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
