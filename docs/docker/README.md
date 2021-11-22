# DOCKERIZING THE PROJECT

## Requirements

* [Docker](https://docs.docker.com/install/)
* Internet connection

## Docker deploy

```sh
docker run -d -p 80:80 --name intranet -v .:/var/www/html/public muserpol/pva:1.1
```
* In the root project's path

copy .env
* Modify `.env` file with desired data

```sh
chmod +x docs/docker/init.sh
docker exec intranet /bin/sh -c /var/www/html/public/docs/docker/init.sh
```