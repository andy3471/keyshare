FROM composer:1.9.3 as build
WORKDIR /app
COPY . /app
COPY .env.example /app/.env
RUN composer install

FROM php:7.3-apache
EXPOSE 80
COPY --from=build /app /app
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo pdo_mysql
RUN apt update && apt install cron -y
RUN echo '* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1' >> /etc/crontab   
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN chown -R www-data:www-data /app \
    && a2enmod rewrite
WORKDIR /app
RUN php artisan storage:link

