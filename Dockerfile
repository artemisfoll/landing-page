FROM php:7.3.28-fpm
RUN apt-get update && apt-get install -y libmcrypt-dev git libzip-dev zip \
    mariadb-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && pecl install mcrypt-1.0.3 && docker-php-ext-enable mcrypt
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
