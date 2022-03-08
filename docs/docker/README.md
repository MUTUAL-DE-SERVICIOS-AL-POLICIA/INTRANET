# DOCKERIZING THE PROJECT

## Requirements

* [Docker](https://docs.docker.com/install/)
* Internet connection

## Docker deploy

```sh
docker run -d -p 80:80 --name intranet muserpol/intranet
```
* In the root project's path

copy .env
* Modify `.env` file with desired data

```sh
service nginx restart
```