FROM php:8.3-fpm

RUN docker-php-ext-install pdo pdo_mysql
# add composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# add git
RUN apt-get update && apt-get install -y git
# add zip
RUN apt-get update && apt-get install -y zip unzip
# add vim
RUN apt-get update && apt-get install -y vim
# add xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# add group and user
RUN groupadd -g 1000 app
RUN useradd -u 1000 -ms /bin/bash -g app app

# change owner
RUN chown -R app:app /var/www/html

WORKDIR /var/www/html

CMD ["php-fpm"]
