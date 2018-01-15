# After5app backend
Restful API based app, php7 with laravel

[![buddy pipeline](https://app.buddy.works/oanamuntean8/backend/pipelines/pipeline/41634/badge.svg?token=413a5bdcf3c74d83fdb0047cf554673026828cd77b89904ec57572465a4c7280 "buddy pipeline")](https://app.buddy.works/oanamuntean8/backend/pipelines/pipeline/41634)

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5b553a5fdab9037961dd)

### Config
All necessary configs are in env.example. Just copy env.example to .env

### Run with docker

```
$ docker-compose up -d
```
- start the containers

```
$ docker-compose run php bash
```
- ssh in php container and execute commands

```
$ docker-compose stop
```
- stop the containers


### Setting up this beauty!

```
$ cp .env.example .env
```
- copy .env.example to .env (don't forget to edit this file according to your needs)

First ssh in php container, then execute the commands below

```
$ composer install
```
- install all dependencies for laravel and PHP

```
$ php artisan key:generate
```
- generate a new key for your application

```
$ php artisan jwt:secret
```
- generate a new key for JWT token

```
$ php artisan migrate:refresh --seed
```
- reset current migrations, migrate the database, seed the database

```
$ php artisan optimize --force
$ php artisan route:cache
$ php artisan config:cache
```
- cache route and config (only for production or frontend work)

```
$ php artisan
```
- for a list of all available commands

### Run tests ###

```
$ phpunit
```
- run tests

### Database ###

```
$ php artisan migrate
```
- migrate the database

```
$ php artisan migrate:reset
```
- reset all migrations

```
$ php artisan db:seed
```
- seed the database with dummy data