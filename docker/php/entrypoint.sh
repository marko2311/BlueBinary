#!/bin/bash

set -e

if [ -n "$APP_USER_UID" ] && [ -n "$APP_USER_GID" ]; then
    chown -R "$APP_USER_UID:$APP_USER_GID" /var/www/html
fi

if [ ! -f "public/index.php" ]; then
    composer create-project --ignore-platform-req=ext-intl codeigniter4/appstarter .
fi

if [ -d "writable" ]; then
    chown -R "$APP_USER_UID:$APP_USER_GID" writable
    chmod -R 775 writable
fi

if [ "$APP_ENV" = "development" ]; then
    cp .env.dev .env
elif [ "$APP_ENV" = "production" ]; then
    cp .env.prod .env
fi

exec php-fpm
