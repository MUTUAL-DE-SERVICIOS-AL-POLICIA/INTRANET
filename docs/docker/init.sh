chown www-data -R /var/www/html/public
cd /var/www/html/public
composer run-script post-root-package-install
composer install
yarn 
yes|composer run-script post-create-project-cmd
yarn prod
composer run-script post-autoload-dump
service nginx restart