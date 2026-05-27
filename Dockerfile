FROM php:8.2-apache

# Install required PHP extensions and system tools
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install zip mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy root project files (including ExternalConfiguration.php)
COPY composer.json composer.lock ExternalConfiguration.php /var/www/html/
COPY LICENSE README.md /var/www/html/

# Copy php-microform sample into web root
COPY php-microform/ /var/www/html/

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "DirectoryIndex router.php" >> /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
