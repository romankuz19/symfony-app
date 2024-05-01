FROM php:8.2-fpm-alpine

RUN set -o errexit -o nounset -o pipefail -o xtrace; \
    \
    # Install system packages.
    apk update; \
    apk upgrade; \
    apk \
        add --no-cache \
            bash \
            build-base \
            curl \
            git \
            linux-headers \
            make \
            nano; \
    \
    # Clean up.
    rm -fr /tmp/* /var/tmp/*

RUN apk add --update nodejs npm;

# Retrieve the script used to install PHP extensions from the source container.
COPY --from=mlocati/php-extension-installer:2.1.10 /usr/bin/install-php-extensions /usr/local/bin/

RUN set -o errexit -o nounset -o pipefail -o xtrace; \
    \
    # Install PHP extensions.
    install-php-extensions \
        intl \
        opcache \
        pdo_pgsql \
        xdebug;

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN set -o errexit -o nounset -o pipefail -o xtrace; \
    \
    composer --global config repos.packagist composer 'https://mirrors.tencent.com/composer/'
ENV COMPOSER_ALLOW_SUPERUSER=1


WORKDIR /var/www/html
