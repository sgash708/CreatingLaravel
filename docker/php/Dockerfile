FROM php:7.3-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y vim zlib1g-dev libzip-dev mariadb-client \
    && docker-php-ext-install zip pdo_mysql

# nodeJSをインストール
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# 作業環境
WORKDIR /var/www

# laravelをインストール
RUN composer global require "laravel/installer"