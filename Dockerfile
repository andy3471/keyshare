FROM composer:1.9.3 as build
WORKDIR /app
COPY . /app
COPY .env.example /app/.env
RUN composer install

FROM php:7.3-apache
EXPOSE 80
COPY --from=build /app /app
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/start.sh /usr/local/bin/start.sh
WORKDIR /app

RUN chown -R www-data:www-data /app \
    && docker-php-ext-install pdo pdo_mysql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && a2enmod rewrite \
    && chmod u+x /usr/local/bin/start.sh

RUN pecl install redis && docker-php-ext-enable redis

CMD ["/usr/local/bin/start.sh"]