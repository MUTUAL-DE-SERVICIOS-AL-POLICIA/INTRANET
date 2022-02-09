FROM muserpol/pva:1.1
USER root
ADD . /var/www/html/public
WORKDIR /var/www/html/public
RUN yes|php artisan key:generate
RUN composer install
RUN yarn
RUN yarn prod
RUN chown www-data -R /var/www/html/public