FROM php:7.4-apache
COPY src/ /var/www/html
COPY php.ini $PHP_INI_DIR/conf.d/
RUN apt-get update && apt-get install -y gnupg2
RUN echo 'deb http://cloud.r-project.org/bin/linux/debian buster-cran40/' >> /etc/apt/sources.list
RUN apt-key adv --keyserver keys.gnupg.net --recv-key 'E19F5F87128899B192B1A2C2AD5F960A256A04AF'
RUN apt-get update
RUN apt install -y -t buster-cran40 r-base r-base-dev r-recommended  libssl-dev libcurl4-openssl-dev libxml2-dev
RUN mkdir /usr/share/man/man1/
RUN apt-get install -y default-jre
RUN apt-get install -y default-jdk
RUN R CMD javareconf
RUN Rscript /var/www/html/install_packages.R
RUN chmod +x /var/www/html/sws/csvtk
EXPOSE 80