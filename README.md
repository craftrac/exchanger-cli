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
1. Define a valid API key inside the docker-compose.yaml file.
2. Configure any other environment variables inside the docker-compose.yaml file.
3. Run the docker-compose or podman compose command to build the cli and execute the related services
```shell
docker-compose up -d
OR
podman-compose up -d
```
4. Execute the CLI either by entering the container terminal (default container name is exchanger-cli_web_1) or by running the CLI proxy
```shell
docker exec -it exchanger-cli_web_1 /bin/bash 
php /app/index.php <action> [<parameter1> <parameter2>]
OR
podman exec -it exchanger-cli_web_1 /bin/bash
php /app/index.php <action> [<parameter1> <parameter2>]
OR
./cli.sh <action> [<parameter1> <parameter2>]
```
The default action is 'exchange-rates' and the default parameter is todays date.
Currently there are 2 actions available:
- fetch-rates (fetches data from open exchange rates into the database)
- refresh-materialized-view (refreshes the database materialized view that contains the statistics)

## Database administration
You may monitor the database and/or add more data to it using the Adminer web app.
The administration panel is accessible through "localhost:8080" or any other port you chose during the build process.

## Alternative way to run
In case you don't want to run it using Docker, you can run it locally using PHP 8.2
and define the corresponding environment variables in the OS
requirements:
- php 8.2
- postgresql
```shell
php /app/index.php <action> [<parameter1> <parameter2>]
```
