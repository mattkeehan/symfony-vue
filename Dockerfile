FROM ubuntu:latest
MAINTAINER Matt Keehan <matt.keehan@gmail.com>

# Install apache, PHP, and other required tools
RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
  apache2 php7.4 php7.4-mysql libapache2-mod-php7.4 curl git zip unzip php-zip php-xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Enable apache mods.
RUN a2enmod php7.4
RUN a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.4/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Expose apache.
EXPOSE 8000

# Copy this repo into place.
ADD www /var/www

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# By default start up apache in the foreground, override with /bin/bash for interative.


# Symfony requires some git setup
RUN git config --global user.email "you@example.com"
RUN git config --global user.name "Your Name"

# run Symfony
WORKDIR /var/www/
CMD /usr/sbin/apache2ctl -D FOREGROUND
#CMD symfony server:start -D FOREGROUND
