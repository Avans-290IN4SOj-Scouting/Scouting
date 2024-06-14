# Gebruik de officiële PHP 8.0 image met Apache
FROM php:8.0-apache

# Stel de werkdirectory in
WORKDIR /var/www/html

# Installeer systeemafhankelijkheden
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Installeer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopieer de bestaande applicatie bestanden naar de container
COPY . /var/www/html

# Geef de juiste permissies
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Installeer Laravel afhankelijkheden
RUN composer install --no-dev --optimize-autoloader

# Stel de Apache configuratie in voor Laravel
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose poort 80 and 443
EXPOSE 80
EXPOSE 443

# Start Apache in de voorgrond
CMD ["apache2-foreground"]
