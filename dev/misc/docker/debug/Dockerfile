FROM ubuntu:18.04

MAINTAINER Akarsh Thodupunuri <akarsh.thodupunuri@guidance.com>

# disable interactive functions
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
      apt-get -y install sudo

# Environment
ENV PHP_VERSION 7.2

RUN apt-get update && \
    apt-get install -y --no-install-recommends apt-utils software-properties-common git-core curl zlib1g-dev build-essential libssl-dev libreadline-dev libyaml-dev libsqlite3-dev \
      sqlite3 libxml2-dev libxslt1-dev libcurl4-openssl-dev libffi-dev ca-certificates

RUN apt-get update && apt-get install -y --no-install-recommends \
    # Install PHP 7.2
    libapache2-mod-php${PHP_VERSION} \
    imagemagick \
    # Install PHP modules
    php${PHP_MAJOR}-bcmath \
    php${PHP_MAJOR}-ctype \
    php${PHP_MAJOR}-dom \
    php${PHP_MAJOR}-gmp \
    php${PHP_MAJOR}-gd \
    php${PHP_MAJOR}-imagick \
    php${PHP_MAJOR}-redis \
    php${PHP_MAJOR}-xsl \
    php${PHP_MAJOR}-iconv \
    php${PHP_MAJOR}-curl \
    php${PHP_MAJOR}-zip \
    php${PHP_MAJOR}-bz2 \
    php${PHP_MAJOR}-cli \
    php${PHP_MAJOR}-common \
    php${PHP_MAJOR}-mbstring \
    php${PHP_MAJOR}-mysql \
    php${PHP_MAJOR}-curl \
    php${PHP_MAJOR}-intl \
    php${PHP_MAJOR}-opcache \
    php${PHP_MAJOR}-json \
    php${PHP_MAJOR}-xml \
    php${PHP_MAJOR}-xmlrpc \
    php${PHP_MAJOR}-readline \
    php${PHP_MAJOR}-tidy \
    php${PHP_MAJOR}-xdebug \
    php${PHP_MAJOR}-xsl \
    php${PHP_MAJOR}-soap \
    php${PHP_MAJOR}-apcu \ 
    php${PHP_MAJOR}-geoip \
    php${PHP_MAJOR}-ssh2 \
    php${PHP_MAJOR}-yaml \
    php${PHP_MAJOR}-tideways && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        echo "xdebug.remote_enable=1" >> /etc/php/7.2/mods-available/xdebug.ini; \
        echo "xdebug.remote_autostart=1" >> /etc/php/7.2/mods-available/xdebug.ini; \
        echo "xdebug.remote_connect_back=0" >> /etc/php/7.2/mods-available/xdebug.ini; \
        echo "xdebug.profiler_enable=0" >> /etc/php/7.2/mods-available/xdebug.ini; \
        echo "xdebug.remote_host=192.168.1.121" >> /etc/php/7.2/mods-available/xdebug.ini; \
        echo "xdebug.remote_port=9000 " >> /etc/php/7.2/mods-available/xdebug.ini; \
    fi ;

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the current directory into container
COPY . /var/tests_skeleton

WORKDIR /var/tests_skeleton

#RUN sudo chmod +x docker-entrypoint.sh
#
#ENTRYPOINT ["/var/tests_skeleton/docker-entrypoint.sh"]

# CMD ["DemoCest.php"]

