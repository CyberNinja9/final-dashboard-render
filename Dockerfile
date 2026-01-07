FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-enable pdo_pgsql

# FORCE CACHE BREAK
RUN echo "FORCE_REBUILD_$(date +%s)"

COPY . /var/www/html/
