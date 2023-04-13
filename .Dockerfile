FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip

# Clear cache
RUN rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd zip exif pcntl bcmath

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-dev --no-scripts --no-autoloader --ansi

# Copy NPM files
COPY package.json package-lock.json ./

# Install NPM dependencies
RUN npm install

# Copy application files
COPY . .

# Generate optimized class loader
RUN composer dump-autoload --optimize --ansi

# Build assets with Vite
RUN npm run prod

# Set file permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
