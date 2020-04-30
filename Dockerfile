FROM php:7.4-apache
COPY src/ /var/www/html
COPY php.ini $PHP_INI_DIR/conf.d/
RUN chmod +x /var/www/html/sws/csvtk
EXPOSE 80