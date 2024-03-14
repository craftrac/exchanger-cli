# exchanger-cli
php currency exchanger cli that mines data from API to postgres, wrapped in docker
The cli is a multi-container application that includes:
    - the CLI
    - the Postgres Database
    - Adminer web app that can be used to manage the database

CLI container initializes a cronjob as well to be run every day at 5:45

## Dependencies
- php 8.2
- postgresql
- composer

## Usage
```shell
docker-compose up -d
```

## Alternative way to run
In case you don't want to run it using Docker, you can run it locally using PHP 8.2
and define the required environment variables in `.env`
requirements:
- php 8.2
- postgresql
```shell
```
