FROM muserpol/pva:1.1
ADD . /var/www/html/public
WORKDIR /var/www/html/public
#CMD cp .env.example .env
CMD composer run-script post-root-package-install
CMD composer install
# CMD yarn
CMD npm run prod
CMD yes|php artisan key:generate
# CMD yarn prod
RUN chown www-data -R /var/www/html/public