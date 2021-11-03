# Base image
FROM php:7.4-apache

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Run apt update and install some dependancies needed for docker-php-ext
RUN apt update && apt install -y apt-utils libzip-dev unzip zip libpng-dev libmcrypt-dev git curl nano sqlite3 nodejs npm
RUN apt update && apt install -y unzip libpng-dev libmcrypt-dev \
    curl libicu-dev libxml2-dev libssl-dev libsqlite3-dev libsqlite3-0


# install curl builder
RUN apt install libcurl4-gnutls-dev

# Install PHP extensions
RUN docker-php-ext-install mysqli curl zip dom session opcache

# Update web root to public
# See: https://hub.docker.com/_/php#changing-documentroot-or-other-apache-configuration
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN usermod -u 1000 www-data
RUN usermod -G staff www-data


# Enable mod_rewrite
RUN a2enmod rewrite
