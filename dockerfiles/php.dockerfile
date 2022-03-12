FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

RUN apk update \
    && apk add ca-certificates wget libzip-dev zip

RUN docker-php-ext-install mysqli pdo pdo_mysql zip \
    && docker-php-ext-enable pdo_mysql