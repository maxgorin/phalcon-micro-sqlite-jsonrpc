FROM phpdockerio/php74-swoole

WORKDIR /var/www

RUN apt-get update \
    && apt-get -y install git php7.4-sqlite\
    && apt-get -y --no-install-recommends install build-essential php7.4-dev php-pear

# Install psr
RUN pecl install psr \
    && echo "extension=psr.so" >> /etc/php/7.4/cli/php.ini

# Install phalcon
RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash \
    && apt-get install -y php7.4-phalcon=4.0.2-884+php7.4

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear apt
RUN apt-get autoremove --purge -y build-essential php7.4-dev php-pear \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENTRYPOINT ["/bin/sh", "entrypoint.sh"]