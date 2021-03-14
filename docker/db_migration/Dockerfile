FROM php:7.4-fpm

# install PHP extensions
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# install git
RUN apt-get update && \
	apt-get install -y wget && \
	apt-get install -y openssl && \
    apt-get install -y git && \
	apt-get install -y zip && \
	apt-get install -y unzip

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --quiet
RUN php -r "unlink('composer-setup.php');"

# install phinx
RUN php composer.phar global require 'robmorgan/phinx'
RUN docker-php-ext-install pdo pdo_mysql

# install dockerize
ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# prepare entrypoint
COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
