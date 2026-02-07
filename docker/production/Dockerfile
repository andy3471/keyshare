FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    redis \
    pdo_pgsql \
    zip \
    gd \
    intl

COPY . /app

CMD ["php", "artisan", "octane:frankenphp"]
