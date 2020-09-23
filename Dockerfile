FROM php:7.4-apache

RUN apt-get update && apt-get install -y gnupg2 && \
	echo 'deb http://cloud.r-project.org/bin/linux/debian buster-cran40/' >> /etc/apt/sources.list && \
	apt-key adv --keyserver keys.gnupg.net --recv-key 'E19F5F87128899B192B1A2C2AD5F960A256A04AF' && \
	apt-get update && \
	apt install -y -t buster-cran40 r-base r-base-dev r-recommended  libssl-dev libcurl4-openssl-dev libxml2-dev msmtp && \
	mkdir /usr/share/man/man1/ && \
	apt-get install -y default-jre default-jdk && \
	R CMD javareconf

COPY dependencies/ /usr/local/lib/R/site-library/mailR/java
COPY install_packages.R /var/www/html/
COPY php.ini $PHP_INI_DIR/conf.d/
COPY ports.conf /etc/apache2/ports.conf

RUN Rscript /var/www/html/install_packages.R

COPY src/ /var/www/html
RUN chmod +x /var/www/html/sws/csvtk
COPY main.sh main.sh

EXPOSE 8083
