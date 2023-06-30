ARG PHP_VERSION=7.4.33
ARG NGINX_VERSION=1.24.0
ARG COMPOSER_VERSION=2.5.8

FROM composer:${COMPOSER_VERSION} AS composer

FROM php:${PHP_VERSION}-fpm-buster AS php_base_notification_app
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
ENV TZ="Europe/Warsaw"
ARG USER_ID
ARG GROUP_ID
ARG USER_NAME

RUN : "${USER_ID:?You not specified a USER_ID args. Run docker-build.sh}"
RUN : "${GROUP_ID:?You not specified a GROUP_ID args. Run docker-build.sh}"
RUN : "${USER_NAME:?You not specified a USER_NAME args. Run docker-build.sh}"

RUN mkdir -p /home/${USER_NAME} &&\
    chown ${USER_ID}:${GROUP_ID} /home/${USER_NAME} &&\
    chown ${USER_ID}:${GROUP_ID} /var/www/html &&\
    groupadd -g ${GROUP_ID} ${USER_NAME} &&\
    useradd -d "/home/${USER_NAME}" -u ${USER_ID} -g ${GROUP_ID} -m -s /bin/bash ${USER_NAME}

RUN apt-get update && apt-get install --fix-missing -y \
    libzip-dev curl git wget zlib1g-dev libxml2-dev libicu-dev vim \
    libpng-dev libjpeg-dev libfreetype6-dev acl netcat --no-install-recommends \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install zip intl pdo pdo_mysql opcache

COPY --from=composer /usr/bin/composer /usr/bin/composer

FROM php_base_notification_app AS php_notification_app
ARG USER_ID
ARG GROUP_ID
ARG USER_NAME
ARG APP_ENV=prod

WORKDIR /var/www/html

USER ${USER_NAME}

# prevent the reinstallation of vendors at every changes in the source code
COPY --chown=${USER_ID}:${GROUP_ID} composer.json composer.lock symfony.lock ./
RUN set -eux; \
	composer install --no-dev --prefer-dist --no-autoloader --no-scripts --no-progress --no-suggest; \
	composer clear-cache

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY --chown=${USER_ID}:${GROUP_ID} .env .env.test ./
COPY --chown=${USER_ID}:${GROUP_ID} bin bin/
COPY --chown=${USER_ID}:${GROUP_ID} config config/
COPY --chown=${USER_ID}:${GROUP_ID} public public/
COPY --chown=${USER_ID}:${GROUP_ID} src src/
COPY --chown=${USER_ID}:${GROUP_ID} migrations migrations/
COPY --chown=${USER_ID}:${GROUP_ID} templates templates/
COPY --chown=${USER_ID}:${GROUP_ID} translations translations/

RUN set -eux; \
	mkdir -p var/cache var/log && \
	chown -R ${USER_ID}:${GROUP_ID} -R var && \
	composer dump-autoload --no-dev --classmap-authoritative && \
	APP_SECRET='' composer --no-dev run-script post-install-cmd && \
	chmod +x bin/console && sync

VOLUME /var/www/html/var

COPY --chown=${USER_ID}:${GROUP_ID} ./docker/php/entrypoint.sh /usr/local/entrypoint.sh
RUN chmod 755 /usr/local/entrypoint.sh

ENTRYPOINT ["/usr/local/entrypoint.sh"]
CMD ["php-fpm"]

FROM nginx:${NGINX_VERSION} AS nginx_notification_app
ARG USER_ID
ARG GROUP_ID
ARG USER_NAME

WORKDIR /var/www/html

RUN mkdir /etc/ssl/selfsigned && openssl req -x509 -nodes -days 365 -subj "/C=PL/ST=14/O=Company, Inc./CN=Company" \
    -addext "subjectAltName=DNS:dev.company.com" -newkey rsa:2048 -keyout /etc/ssl/selfsigned/nginx-selfsigned.key -out \
    /etc/ssl/selfsigned/nginx-selfsigned.crt

RUN mkdir -p /home/${USER_NAME} &&\
    chown ${USER_ID}:${GROUP_ID} /home/${USER_NAME} &&\
    chown ${USER_ID}:${GROUP_ID} /var/www/html &&\
    groupadd -g ${GROUP_ID} ${USER_NAME} &&\
    useradd -d "/home/${USER_NAME}" -u ${USER_ID} -g ${GROUP_ID} -m -s /bin/bash ${USER_NAME}

RUN chown ${USER_ID}:${GROUP_ID} /etc/ssl/selfsigned/nginx-selfsigned.key && \
    chown ${USER_ID}:${GROUP_ID} /etc/ssl/selfsigned/nginx-selfsigned.crt

USER ${USER_NAME}

COPY --from=php_fostertravel /var/www/html/public public/
