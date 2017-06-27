FROM ubuntu:trusty

MAINTAINER ruslan.kiricenko@locatory.com

RUN apt-get update
RUN apt-get -y upgrade

# Install apache and supplimentary programs.
RUN apt-get -y install apache2 curl vim wget mc

# Install required by PHP 5.6
RUN DEBIAN_FRONTEND=noninteractive \
    apt-get -y install language-pack-en-base &&\
    export LC_ALL=en_US.UTF-8 && \
    export LANG=en_US.UTF-8
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get -y install software-properties-common
RUN DEBIAN_FRONTEND=noninteractive LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
RUN DEBIAN_FRONTEND=noninteractive LC_ALL=en_US.UTF-8 \
    apt-get update && apt-get -y install \
    php5.6 php5.6-mbstring php5.6-mcrypt php5.6-mysql php5.6-xml php5.6-gd php5.6-curl php5.6-zip libapache2-mod-php5 php5.6-xdebug


# Install composer
#RUN apt-get -y install php5.6-cli git
RUN curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install phpunit
RUN wget https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit

# Add vim config
RUN touch ~/.vimrc
RUN echo "set nocompatible" >> ~/.vimrc



# RUN sed -ie 's/memory_limit\ =\ 128M/memory_limit\ =\ 2G/g' /etc/php5/apache2/php.ini
RUN sed -ie 's/\;date\.timezone\ =/date\.timezone\ =\ Europe\/Helsinki/g' /etc/php5/apache2/php.ini
# RUN sed -ie 's/upload_max_filesize\ =\ 2M/upload_max_filesize\ =\ 200M/g' /etc/php5/apache2/php.ini
# RUN sed -ie 's/post_max_size\ =\ 8M/post_max_size\ =\ 200M/g' /etc/php5/apache2/php.ini

#enable xdebug
RUN echo "xdebug.remote_enable=on" >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo "xdebug.idekey='PHPSTORM'" >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo 'xdebug.remote_handler="dbgp"' >> /etc/php/5.6/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /etc/php/5.6/mods-available/xdebug.ini

# Enable apache mods.
RUN a2enmod php5
RUN a2enmod rewrite


RUN rm /etc/apache2/sites-available/000-default.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY default.conf /etc/apache2/sites-enabled/default.conf

VOLUME /var/www

ENV TERM xterm
EXPOSE 80 3306

ENTRYPOINT /usr/sbin/apache2ctl -D FOREGROUND
# By default start up apache in the foreground, override with /bin/bash for interative.
CMD ["/usr/sbin/apache2ctl", "-D" "FOREGROUND"]

