FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install --ignore-platform-reqs

CMD ["php-fpm"]
