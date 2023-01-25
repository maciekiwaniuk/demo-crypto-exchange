FROM php:8.1-fpm

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
#RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

#RUN chmod +x /entrypoint.sh
#ENTRYPOINT ["entrypoint.sh"]
#
#COPY --link ./entrypoint.sh /usr/local/bin/docker-entrypoint
#RUN chmod +x /usr/local/bin/docker-entrypoint
#
#ENTRYPOINT ["docker-entrypoint"]


COPY docker/php/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

#CMD /entrypoint.sh

#ENTRYPOINT ["/entrypoint.sh"]

#RUN cd bin
#RUN tr -d '\015' <console >console.new
#RUN mv console console.old
#RUN mv console.new console
