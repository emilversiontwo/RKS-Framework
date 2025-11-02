FROM php:8.4-fpm-alpine
LABEL authors="soup"

RUN set -ex \
	&& apk --no-cache add postgresql-libs php-cli postgresql-dev \
	&& docker-php-ext-install pdo pdo_pgsql\
	&& apk del postgresql-dev

WORKDIR /var/www/html

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pcov xdebug json mbstring xml

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer self-update

COPY . .

RUN composer install

RUN composer dump-autoload --optimize