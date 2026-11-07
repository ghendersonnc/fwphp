FROM php:8.2.35-fpm-alpine
ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions  \
    && install-php-extensions gd pdo_mysql mysqli exif imagick apcu \
    && apk add --no-cache linux-headers \
    && apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && addgroup -g ${GID} -S  ub \
    && adduser -G ub -S -D -s /bin/sh -u ${UID} ub \
    && sed -i "s/user =n www-data/user = ub/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = ub/g" /usr/local/etc/php-fpm.d/www.conf \
    && composer install

USER ub