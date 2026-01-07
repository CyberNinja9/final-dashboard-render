FROM php:8.2-apache

RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y curl

COPY . /var/www/html/

