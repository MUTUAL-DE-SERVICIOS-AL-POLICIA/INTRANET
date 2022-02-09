FROM muserpol/pva:1.1
USER root
ADD . /var/www/html/public
WORKDIR /var/www/html/public
CMD composer run-script post-root-package-install
CMD composer install
CMD yarn
CMD yes|php artisan key:generate
CMD yarn prod
CMD chown www-data -R /var/www/html/public