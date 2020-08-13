#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if  [ "$role" != "keygen" ]; then
    (cd /app && php artisan cache:clear && php artisan view:clear)
    echo "Running migrations..."
    (cd /app && php artisan migrate)
fi

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /app && php artisan optimize && php artisan view:cache)
fi

if [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php /app/artisan queue:work --verbose --tries=3 --timeout=90

elif [ "$role" = "scheduler" ]; then

    echo "Running the scheduler..."
    while [ true ]
    do
      php /app/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

elif [ "$role" = "keygen" ]; then

    echo "Generating an app key..."
    (cd /app && php artisan key:generate --show)

else
    exec apache2-foreground
fi