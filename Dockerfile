FROM php:8.2-apache

# Install required PHP extensions and system tools
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install zip mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory to php-microform
WORKDIR /var/www/html

# Copy the entire php-microform folder into web root
COPY php-microform/ /var/www/html/

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Run composer install inside php-microform (now web root)
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Create Log directory with correct permissions
RUN mkdir -p /var/www/Log && chown -R www-data:www-data /var/www/Log


# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "DirectoryIndex router.php" >> /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
