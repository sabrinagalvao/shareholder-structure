FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql xml

WORKDIR /var/www

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

EXPOSE 9000

CMD ["php-fpm"]
