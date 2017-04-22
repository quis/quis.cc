FROM wordpress:latest

RUN docker-php-ext-install exif

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
