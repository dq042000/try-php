FROM ubuntu:22.04
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get clean && apt-get -y update && apt-get -y upgrade && apt-get install -y locales curl software-properties-common git \
        && locale-gen zh_TW.UTF-8
RUN LC_ALL=zh_TW.UTF-8

RUN apt-get install software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update --fix-missing

RUN apt-get install -y --force-yes zip unzip php8.2-bcmath php8.2-bz2 php8.2-cli php8.2-common php8.2-curl \ 
        php8.2-cgi php8.2-dev php8.2-fpm php8.2-gd php8.2-gmp php8.2-imap php8.2-intl \
        php8.2-ldap php8.2-mbstring php8.2-mysql \
        php8.2-odbc php8.2-opcache php8.2-pgsql php8.2-phpdbg php8.2-pspell \
        php8.2-readline php8.2-soap php8.2-sqlite3 \
        php8.2-tidy php8.2-xml php8.2-xmlrpc php8.2-xsl php8.2-zip php8.2-apcu \
        php8.2-redis php8.2-mongodb php8.2-memcached php8.2-imagick php8.2-xdebug php8.2-apcu composer

RUN apt-get update && apt-get install -y supervisor && \
    chmod 777 /var/run && \
    touch /var/run/supervisor.sock && \
    chmod 777 /var/run/supervisor.sock

RUN sed -i "s/;date.timezone =.*/date.timezone = Asia\/Taipei/" /etc/php/8.2/cli/php.ini
RUN sed -i "s/;date.timezone =.*/date.timezone = Asia\/Taipei/" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/display_errors = Off/display_errors = On/" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/upload_max_filesize = .*/upload_max_filesize = 60M/" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/post_max_size = .*/post_max_size = 65M/" /etc/php/8.2/fpm/php.ini
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.2/fpm/php.ini
RUN sed -i -e "s/pid =.*/pid = \/var\/run\/php8.2-fpm.pid/" /etc/php/8.2/fpm/php-fpm.conf
RUN sed -i -e "s/error_log =.*/error_log = \/proc\/self\/fd\/2/" /etc/php/8.2/fpm/php-fpm.conf
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/8.2/fpm/php-fpm.conf
RUN sed -i "s/listen = .*/listen = 9000/" /etc/php/8.2/fpm/pool.d/www.conf
RUN sed -i "s/;catch_workers_output = .*/catch_workers_output = yes/" /etc/php/8.2/fpm/pool.d/www.conf
RUN curl https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php
RUN composer self-update --2.2
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


WORKDIR /var/app

EXPOSE 9000

CMD ["php-fpm8.2"]

