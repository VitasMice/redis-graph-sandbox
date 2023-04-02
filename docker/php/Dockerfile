FROM php:8.1-fpm-alpine

RUN addgroup -g 1000 -S app && \
    adduser -u 1000 -S app -G app

RUN apk add \
    build-base \
    git \
    autoconf

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:2.1 /usr/bin/composer /usr/local/bin/composer

USER app
