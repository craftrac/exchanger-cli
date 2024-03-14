FROM php:8.2-fpm-alpine

# Define default environment variable values
ARG API_BASE_PATH="https://openexchangerates.org/api/"
ARG DEVELOPMENT_MODE=false
ARG DB_PASSWORD="password"
ARG DB_HOST="localhost"
ARG DB_USER="postgres"
ARG DB_NAME="openexchangerates"

ENV API_BASE_PATH=$API_BASE_PATH;
ENV API_KEY=$API_KEY;
ENV DB_PASSWORD=$PGSQL_PASSWORD;
ENV DB_HOST=$PGSQL_HOST;
ENV DB_USER=$PGSQL_USER;
ENV DB_NAME=$PGSQL_DB;

RUN apk update && apk upgrade
RUN apk add composer
# FROM php:8.2-cli
COPY index.php composer.json /app/
COPY ./src /app/src/

WORKDIR /app/
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# Install PHP extensions
RUN chmod +x /usr/local/bin/install-php-extensions; \
    install-php-extensions pdo_pgsql zip 

# Setup cronjob
RUN touch /var/log/cron.log
RUN (crontab -l ; echo "45 5 * * * php /app/index.php >> /var/log/cron.log 2>&1") | crontab -

RUN composer install
# CMD [ "php", "-a" ]
CMD ["php-fpm"]
# CMD [ "php", "./index.php" ]
