FROM debian

RUN apt-get update &&\
    apt-get install -y\
        php5-dev\
        build-essential\
        git

RUN git clone http://github.com/BitOne/php-meminfo

RUN cd /php-meminfo/analyzer/ && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php composer-setup.php &&\
    php -r "unlink('composer-setup.php');" &&\
    php composer.phar install

RUN cd /php-meminfo/extension/ && \
    phpize &&\
    ./configure --enable-meminfo &&\
    make &&\
    make install 

RUN echo 'extension=meminfo.so' >> /etc/php5/cli/php.ini

CMD tail -f /dev/null
