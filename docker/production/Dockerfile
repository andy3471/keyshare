FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    redis \
    pdo_pgsql \
    zip

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]