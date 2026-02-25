FROM php:8.2-apache

# Install database extensions for MySQL/MariaDB
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Enable Apache mod_rewrite just in case routing is used
RUN a2enmod rewrite

# Copy custom apache config to allow overrides
COPY apache.conf /etc/apache2/conf-available/custom-dir.conf
RUN a2enconf custom-dir

# Copy project files to Apache root
COPY . /var/www/html/

# Ensure appropriate file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Coolify Proxy
EXPOSE 80
