FROM ubuntu:20.04 AS AMS

ARG AntMediaServer

ARG BranchName=master

#Running update and install makes the builder not to use cache which resolves some updates
RUN apt-get update && apt-get install -y curl libcap2 wget net-tools iproute2 cron logrotate

RUN cd home \
    && pwd \
    && wget ${AntMediaServer} \
    && wget https://raw.githubusercontent.com/ant-media/Scripts/${BranchName}/install_ant-media-server.sh \
    && chmod 755 install_ant-media-server.sh

RUN cd home \
    && pwd \
    && ./install_ant-media-server.sh -i ams.zip -s false

EXPOSE 5080

ENTRYPOINT ["/usr/local/antmedia/start.sh"]

FROM php:8.1-fpm AS PHP

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmemcached-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev
RUN pecl install memcached zlib zip
RUN docker-php-ext-install -j$(nproc) mbstring pdo pdo_mysql gd
RUN docker-php-ext-enable memcached

WORKDIR /var/www/app

RUN cd /var/www/app \
    && php artiisan migrate \
    && composer dump-autoload

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM nginx AS nginx

ADD docker/nginx/test.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/app