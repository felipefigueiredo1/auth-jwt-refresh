FROM php:8-fpm

COPY php.ini /etc/php/php.ini

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

EXPOSE 9000

CMD ["php-fpm"]