FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo pdo_mysql exif

RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html
