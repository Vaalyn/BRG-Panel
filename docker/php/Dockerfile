FROM php:7.4-fpm

RUN apt-get update

RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https zlib1g-dev libicu-dev g++
RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https advancecomp pngcrush gifsicle jpegoptim
RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https libjpeg-progs libimage-exiftool-perl
RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https pngnq libpng-dev
RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https optipng pngquant
RUN DEBIAN_FRONTEND=noninteractive apt-get install -q -y --no-install-recommends apt-transport-https libwebp-dev libjpeg-dev libjpeg62-turbo-dev libxpm-dev libfreetype6 libfreetype6-dev libonig-dev

# Install iconv PHP extension
RUN docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-enable iconv

# Install GD PHP extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-enable gd

# Install other PHP extensions
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install bcmath && docker-php-ext-enable bcmath
RUN docker-php-ext-install exif && docker-php-ext-enable exif
RUN docker-php-ext-install mbstring && docker-php-ext-enable mbstring
RUN docker-php-ext-install intl && docker-php-ext-enable intl

COPY ./php.ini $PHP_INI_DIR/php.ini
