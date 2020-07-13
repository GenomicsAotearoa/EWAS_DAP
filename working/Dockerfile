FROM gaewasp/ewasp
COPY src/ /var/www/html
COPY php.ini $PHP_INI_DIR/conf.d/
COPY ports.conf /etc/apache2/ports.conf
COPY main.sh main.sh
RUN chmod +x /var/www/html/sws/csvtk
ENTRYPOINT ["./main.sh"]
EXPOSE 8083