FROM php:8.2-fpm as builder

MAINTAINER support@crossjobs.co

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libmemcached-dev \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        openssh-server \
        libmagickwand-dev \
        git \
        cron \
        nano \
        libxml2-dev \
        libreadline-dev \
        libgmp-dev \
        mariadb-client \
        unzip

# Install the PHP mailparse extension

RUN set -e \
    && pecl install mailparse \
    && docker-php-ext-enable mailparse

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer
# Source the bash
RUN . ~/.bashrc

ENV COMPOSER_MEMORY_LIMIT='-1'

WORKDIR /app

# Copy only composer files for caching
COPY ./composer.json  ./composer.json
COPY ./composer.lock  ./composer.lock

RUN usermod -u 1000 www-data

# Install composer dependencies
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader -vvv

# Stage 2
FROM nginx:alpine

COPY ./docker/nginx/nginx.conf /etc/nginx/

RUN apk update \
    && apk upgrade \
    && apk --update add logrotate \
    && apk add --no-cache openssl \
    && apk add --no-cache bash

RUN apk add --no-cache curl

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

ARG PHP_UPSTREAM_CONTAINER=crossjobs-community
ARG PHP_UPSTREAM_PORT=9000

# Create 'messages' file used from 'logrotate'
RUN touch /var/log/messages

# Copy 'logrotate' config file
COPY ./docker/nginx/logrotate/nginx /etc/logrotate.d/

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www

# Copy web files to the appropriate directory
COPY . /var/www/

# Copy vendor directory from builder stage
COPY --from=builder /app/vendor /var/www/vendor
COPY ./docker/nginx/ssl /etc/nginx/ssl
COPY ./docker/nginx/sites/ /etc/nginx/sites-available

# Set permissions for storage directory and all its subdirectories
RUN mkdir -p /var/www/storage \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage

ADD ./docker/nginx/startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh
CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 80
