FROM php:8.1-cli

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock /var/www/
RUN composer install --no-autoloader --no-scripts

COPY . /var/www

CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/public"]
