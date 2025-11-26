FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy PHP source files into Apache folder
COPY src/ /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite
