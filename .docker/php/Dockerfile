FROM ubuntu:20.04
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get clean && apt-get -y update && apt-get -y upgrade && apt-get install -y locales curl software-properties-common git \
        && locale-gen zh_TW.UTF-8
RUN LC_ALL=zh_TW.UTF-8

RUN apt install software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update --fix-missing

RUN apt-get install -y --force-yes zip unzip php8.1-bcmath php8.1-bz2 php8.1-cli php8.1-common php8.1-curl \ 
        php8.1-cgi php8.1-dev php8.1-fpm php8.1-gd php8.1-gmp php8.1-imap php8.1-intl \
        php8.1-ldap php8.1-mbstring php8.1-mysql \
        php8.1-odbc php8.1-opcache php8.1-pgsql php8.1-phpdbg php8.1-pspell \
        php8.1-readline php8.1-soap php8.1-sqlite3 \
        php8.1-tidy php8.1-xml php8.1-xmlrpc php8.1-xsl php8.1-zip php8.1-apcu \
        php8.1-redis php8.1-mongodb php8.1-memcached php8.1-imagick php8.1-xdebug composer

RUN sed -i "s/;date.timezone =.*/date.timezone = Asia\/Taipei/" /etc/php/8.1/cli/php.ini
RUN sed -i "s/;date.timezone =.*/date.timezone = Asia\/Taipei/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/display_errors = Off/display_errors = On/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/upload_max_filesize = .*/upload_max_filesize = 60M/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/post_max_size = .*/post_max_size = 65M/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.1/fpm/php.ini
RUN sed -i -e "s/pid =.*/pid = \/var\/run\/php8.1-fpm.pid/" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i -e "s/error_log =.*/error_log = \/proc\/self\/fd\/2/" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i "s/listen = .*/listen = 9000/" /etc/php/8.1/fpm/pool.d/www.conf
RUN sed -i "s/;catch_workers_output = .*/catch_workers_output = yes/" /etc/php/8.1/fpm/pool.d/www.conf
RUN curl https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php
RUN composer self-update --2.2
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


WORKDIR /var/app

EXPOSE 9000

CMD ["php-fpm8.1"]
