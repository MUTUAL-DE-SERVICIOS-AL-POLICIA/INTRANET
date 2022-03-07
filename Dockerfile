FROM muserpol/pva:1.1
ADD . /var/www/html/public
WORKDIR /var/www/html/public
#CMD cp .env.example .env
RUN composer run-script post-root-package-install
RUN composer install
RUN npm install
# # CMD yarn
RUN npm run prod
RUN yes|php artisan key:generate
# # CMD yarn prod
RUN chown www-data -R /var/www/html/public