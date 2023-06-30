#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
    mkdir -p var/cache var/log

    #	https://symfony.com/doc/current/setup/file_permissions.html#using-acl-on-a-system-that-supports-setfacl-linux-bsd
    setfacl -R -m u:"$(whoami)":rwX var
    setfacl -dR -m u:"$(whoami)":rwX var

    if [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-progress --no-suggest --no-interaction
        bin/console assets:install --no-interaction
    fi

    if [ "$APP_ENV" = 'prod' ]; then
        bin/console cache:clear
    fi

    until bin/console doctrine:query:sql "select 1" >/dev/null 2>&1; do
        (echo >&2 "Waiting for MySQL to be ready...")
        sleep 1
    done

    bin/console doctrine:migrations:migrate --no-interaction
fi

exec docker-php-entrypoint "$@"