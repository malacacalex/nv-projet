FROM php:8.2-apache

# PHP
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y zlib1g-dev libwebp-dev libpng-dev libzip-dev && \
    docker-php-ext-install gd zip mysqli

# Apache
RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80

