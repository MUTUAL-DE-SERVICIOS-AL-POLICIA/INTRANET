FROM muserpol/pva:1.1
ADD . /var/www/html/public
RUN docker/init.sh 