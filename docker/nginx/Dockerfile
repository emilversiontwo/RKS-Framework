FROM nginx:latest
LABEL authors="soup"

COPY ./docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

COPY ./public/ /var/www/html/public

COPY ./src /var/www/html/src