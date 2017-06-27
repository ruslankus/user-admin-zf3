FROM ruslankus/php56-ubuntu:v5

MAINTAINER ruslan.kiricenko@locatory.com

RUN apt-get update
RUN apt-get install -y git wget \
 && a2enmod php5 \
 && a2enmod rewrite

# RUN sed -ie 's/memory_limit\ =\ 128M/memory_limit\ =\ 2G/g' /etc/php5/apache2/php.ini
#RUN sed -ie 's/\;date\.timezone\ =/date\.timezone\ =\ Europe\/Helsinki/g' /etc/php5/apache2/php.ini
# RUN sed -ie 's/upload_max_filesize\ =\ 2M/upload_max_filesize\ =\ 200M/g' /etc/php5/apache2/php.ini
# RUN sed -ie 's/post_max_size\ =\ 8M/post_max_size\ =\ 200M/g' /etc/php5/apache2/php.ini

#enable xdebug
RUN echo "xdebug.remote_enable=on" >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo "xdebug.idekey='PHPSTORM'" >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo 'xdebug.remote_handler="dbgp"' >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /etc/php/5.6/mods-available/xdebug.ini



RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# Install phpunit
RUN wget https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit


RUN rm /etc/apache2/sites-available/000-default.conf \
 && rm /etc/apache2/sites-enabled/000-default.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY default.conf /etc/apache2/sites-enabled/default.conf

VOLUME /var/www

ENV TERM xterm
EXPOSE 22 80 3306

#ENTRYPOINT /usr/sbin/apache2ctl -D FOREGROUND
# By default start up apache in the foreground, override with /bin/bash for interative.
CMD usr/sbin/apache2ctl -D FOREGROUND

