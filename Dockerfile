FROM muserpol/pva:1.1
USER root
ADD . /var/www/html/public
WORKDIR /var/www/html/public
RUN composer run-script post-root-package-install
RUN composer install
RUN yarn
RUN yes|php artisan key:generate
RUN yarn prod
RUN chown www-data -R /var/www/html/public