FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Allow .htaccess in /var/www/html
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

# Create logs directory with proper permissions
RUN mkdir -p /var/www/logs && chown www-data:www-data /var/www/logs && chmod 755 /var/www/logs

# Copy PHP source files into Apache folder
COPY src/ /var/www/html/
