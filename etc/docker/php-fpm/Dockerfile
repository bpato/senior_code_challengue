FROM php:8.3-fpm
LABEL maintainer="Brais Pato <braispato@hotmail.com>"

# Set timezone
RUN rm /etc/localtime && \
    ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    date

# Basico
RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
        libmcrypt-dev \
		libjpeg62-turbo-dev \
		libpcre3-dev \
		libpng-dev \
		libfreetype6-dev \
		libxml2-dev \
		libicu-dev \
		libzip-dev \
		libonig-dev \
        libxslt1-dev \
		default-mysql-client \
		wget \
		unzip \
		git \
		curl \
        vim \
        nmap \
		libcurl4-openssl-dev \
        gcc make autoconf libc-dev pkg-config libtool \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include \
    && docker-php-ext-install gd

RUN docker-php-ext-install intl \
    && docker-php-ext-install soap \
    && docker-php-ext-install zip \
    && docker-php-ext-install exif \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install iconv \
    && docker-php-ext-install xsl \
    && docker-php-ext-enable zip \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-source extract \
    && if [ -d "/usr/src/php/ext/mysql" ]; then docker-php-ext-install mysql; fi \
	&& if [ -d "/usr/src/php/ext/opcache" ]; then docker-php-ext-install opcache; fi \
    && docker-php-source delete

# Habilitamos xdebug
RUN pecl update-channels \
    && pecl install -f xdebug \
    && pecl install -f mcrypt \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable mcrypt

WORKDIR /var/www/app/src

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini
