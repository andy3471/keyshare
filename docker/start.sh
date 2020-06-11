#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
    (cd /app && php artisan optimize && php artisan view:cache)
fi

if [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php /app/artisan queue:work --verbose --tries=3 --timeout=90

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php /app/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    exec apache2-foreground
fi