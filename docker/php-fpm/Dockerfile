FROM php:8.0-fpm

RUN apt update && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer


RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt install nodejs -y

RUN npm config set registry http://registry.npmjs.org/


COPY . ./
RUN composer install

