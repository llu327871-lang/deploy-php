FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Allow .htaccess in /var/www/html
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

# Copy PHP source files into Apache folder
COPY src/ /var/www/html/
