FROM php:8.1-apache

# Install required packages
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libicu-dev \
    libpq-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    openssl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        opcache \
        intl \
        xml \
        zip \
        pcntl \
    && pecl install mcrypt-1.0.4 \
    && docker-php-ext-enable mcrypt

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache modules
RUN a2enmod rewrite \
    && a2enmod headers \
    && a2enmod ssl

# Copy Apache virtual host configuration for your domain
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Install phpMyAdmin
RUN curl -o /tmp/phpmyadmin.tar.gz -SL https://files.phpmyadmin.net/phpMyAdmin/5.1.1/phpMyAdmin-5.1.1-all-languages.tar.gz \
    && tar -xzf /tmp/phpmyadmin.tar.gz -C /var/www/html \
    && mv /var/www/html/phpMyAdmin-5.1.1-all-languages /var/www/html/phpmyadmin \
    && rm -f /tmp/phpmyadmin.tar.gz \
    && chown -R www-data:www-data /var/www/html/phpmyadmin

