FROM muserpol/pva:1.1
ADD . /var/www/html/public
RUN chown www-data -R /var/www/html/public
WORKDIR cd /var/www/html/public
RUN composer install
RUN yarn
RUN yarn prod
RUN chown www-data -R /var/www/html/public
RUN service nginx restart