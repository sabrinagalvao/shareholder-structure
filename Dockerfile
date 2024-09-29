FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libxml2-dev \
    git \
    unzip \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql xml \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

EXPOSE 9000

CMD ["symfony", "server:start", "--no-tls", "--port=8000", "--dir=public", "--allow-http"]
