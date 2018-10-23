# Update

---

## From [1.2.0](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.2.0) to [1.2.1](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.2.1)

```sh
rm public/js/app.js
yarn prod && php artisan view:clear && php artisan config:cache
```

## From [1.1.2](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.1.2) to [1.2.0](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.2.0)

* Remove cached files

```sh
rm .env
composer run-script post-root-package-install
rm public/js/app.js
yarn prod && php artisan view:clear && php artisan config:cache
```

* `Edit .env file to connect to a LDAP server like `[ the example file](./.env.example)

## From [1.1.1](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.1.1) to [1.1.2](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.1.2)

* Remove cached files

```sh
rm public/js/app.js
yarn prod && php artisan view:clear && php artisan config:cache
```

## From [1.1.0](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.0.0) to [1.1.1](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.1.1)

* Remove cached files

```sh
rm public/js/app.js
yarn prod && php artisan view:clear && php artisan config:cache
```

## From [1.0.0](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.0.0) to [1.1.0](https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PVA-EV/tree/1.1.0)

* Remove cached files

```sh
php artisan migrate
rm public/js/app.js
yarn prod && php artisan view:clear && php artisan config:cache
```