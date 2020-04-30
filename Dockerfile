FROM wordpress:5.3.2-php7.3
LABEL maintainer="wpdev@aplaceformom.com"

ARG environment
ENV environment=${environment}
ADD --chown=www-data:www-data ./html /var/www/html
WORKDIR /var/www/html

EXPOSE 80
