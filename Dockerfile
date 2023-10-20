FROM php:8.2-apache as base

# Install dependencies
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libzip-dev unzip && \
    docker-php-ext-install -j$(nproc) pdo pdo_mysql && \
    a2enmod rewrite headers && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exposer le port 80
EXPOSE 80

# Add xdebug
ARG XDEBUG_ENABLE=0
ENV XDEBUG_ENABLE=${XDEBUG_ENABLE}
RUN if [ "$XDEBUG_ENABLE" -eq 1 ]; then \
        pecl install xdebug && \
        docker-php-ext-enable xdebug && \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.mode=develop,debug,profile" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.output_dir=/var/www/html/var/log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Lancer Apache en arrière-plan
CMD ["apache2-foreground"]