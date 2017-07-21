FROM alpine:latest

LABEL MAINTAINER "k2leving@gmail.com"

RUN apk add --no-cache --update bash curl git mysql-client nano php7 php7-mbstring php7-pdo php7-pdo_mysql php7-phar && \
  curl -O https://getcomposer.org/composer.phar && \
  mv composer.phar /usr/local/bin/composer && \
  chmod 755 /usr/local/bin/composer
