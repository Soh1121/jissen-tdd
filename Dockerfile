FROM php:8.4-apache

ENV TZ=Asia/Tokyo

RUN apt-get update \
    && apt-get install -y git zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
