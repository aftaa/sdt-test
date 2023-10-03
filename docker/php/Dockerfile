FROM php:8.2-fpm
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install pdo_pgsql
WORKDIR /var/www/sdt
CMD ["php-fpm"]
