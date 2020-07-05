FROM php:7.3-fpm


RUN apt-get update && apt-get install -y \    
    mariadb-client \
    vim \
    net-tools \
    iputils-ping

RUN docker-php-ext-install pdo_mysql mbstring
RUN docker-php-ext-install sockets
RUN docker-php-ext-install mysqli