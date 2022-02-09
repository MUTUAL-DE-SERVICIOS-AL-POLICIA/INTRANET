FROM muserpol/pva:1.1
USER root
ADD . /var/www/html/public
WORKDIR /var/www/html/public
RUN php -r \"file_exists('.env') || copy('.env.example', '.env');\""
RUN yes|php artisan key:generate
RUN composer install
RUN yarn
RUN yarn prod
RUN chown www-data -R /var/www/html/public