# Development Dockerfile
FROM php:8.1-apache

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer (available for later if needed)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY app/ /var/www/html/
COPY composer.json composer.lock* ./

# Install PHP dependencies (none required in production for this app)
# Skipping composer install to avoid network dependency during build

# Configure Apache
RUN a2enmod rewrite
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Change ownership for Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]