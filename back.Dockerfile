FROM php:8.1-fpm-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer
# RUN docker-php-ext-install pdo_mysql sockets
RUN set -ex \
    && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

# RUN apk add --update

RUN apk update

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN apk add --no-cache $PHPIZE_DEPS \
#     && pecl install xdebug-2.9.7 \
#     && docker-php-ext-enable xdebug

WORKDIR /var/www/html/backend
COPY . .
