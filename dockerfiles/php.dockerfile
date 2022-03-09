FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli