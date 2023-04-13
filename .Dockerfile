FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install application dependencies
RUN npm install

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Start Apache server
CMD ["apache2-foreground"]
