FROM php:7.1-fpm-alpine3.4

# add non-root user app
RUN set -x \
    && addgroup -g 1001 -S app \
    && adduser -u 1001 -D -S -G app app

# install pdo_mysql and composer and other utilities
RUN apk update --no-cache \
    && apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache mysql-dev \
    && apk add --no-cache git \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && docker-php-ext-install pdo pdo_mysql

# install mysql client
RUN apk add --update mysql mysql-client && rm -f /var/cache/apk/*

# set up Europe/Warsaw timezone
RUN apk add --no-cache tzdata
ENV TZ=Europe/Warsaw

# Configure php
COPY php.ini /usr/local/etc/php/php.ini
